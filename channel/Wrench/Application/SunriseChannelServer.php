<?php

namespace Wrench\Application;

use Wrench\Application\Application;
use Wrench\Application\NamedApplication;

/**
 * Sunrise channel server for signaling and chattting.
 */
class SunriseChannelServer extends Application {
    protected $clients = array();
    protected $config = null;
    protected $channels = array();
    protected $channel_close_pending = array();
    protected $logger = null;

    public function __construct($config) {
        $this->config = $config;
        $this->sendChannelEvent('server_start', null);
        $this->logger = $config['logger'];
    }

    public function onConnect($client) {
        $this->clients[$client->getId()] = $client;
    }

    public function onUpdate() {
        foreach ($this->channels as $token => $channel) {
            if (count($channel) > 0) {
                $this->channel_close_pending[$token] = 0;
            } else {
                if (isset($this->channel_close_pending[$token])) {
                    if (++$this->channel_close_pending[$token] > 100) {
                        $this->logger->debug('channel closed: ' . $token);
                        unset($this->channel_close_pending[$token]);
                        unset($this->channels[$token]);

                        $data = array();
                        $data['channel_token'] = $token;
                        $this->sendChannelEvent('channel_destroyed', $data);
                    }
                } else {
                    $this->channel_close_pending[$token] = 1;
                }
            }
        }
    }

    public function onData($data, $client) {
        try {
            $msg = json_decode($data);
            $msg->sender = $client->getId(); 
            switch ($msg->type) {
            case 'channel':
                $this->onChannelMessage($client, $msg);
                break;
            case 'chat':
                $this->onChatMessage($client, $msg);
                break;
            default:
                $this->onSignalingMessage($client, $msg);
                break;
            }
            // debug
            $this->printStatus();
        } catch (Exception $e) {
            $this->logger->error('Exception on processing data', $e);
        }
    }

    private function onChannelMessage($client, $msg) {
        switch ($msg->subtype) {
        case 'open':
            $this->logger->debug('Channel open: ' . $msg->channel_token . ': ' . $msg->user_name);
            $this->openChannel($msg, $client);
            break;
        case 'close':
            $this->logger->debug('Channel close: ' . $client->getChannelToken() . ': ' . $client->getName());
            $this->closeChannel($client);
            break;
        case 'status':
            $this->logger->debug('Channel status');
            $this->responseCurrentStatus($client);
            break;

        }
    }

    private function onChatMessage($client, $msg) {
        $channel = $this->channels[$client->getChannelToken()];
        $data = json_encode($msg);

        if ($msg->recipient == 'ns') {
            // no recipient is specified
            foreach ($channel as $sendto) {
                if ($sendto && $sendto !== $client) {
                    try {
                        $sendto->send($data);
                    } catch (Exception $e) {
                        $this->logger->error('Failed to send chat message', $e);
                    }
                }
            }
        } else {
            // send the message to the specified recipient
            if ($sendto = $channel[$msg->recipient]) {
                try {
                    $sendto->send($data);
                } catch (Exception $e) {
                    $this->loggererror('Failed to send signaling message', $e);
                }
            }
        }
    }

    private function onSignalingMessage($client, $msg) {
        $channel = $this->channels[$client->getChannelToken()];
        if ($msg->type === 'offer') {
            $msg->name = $client->getName();
        }

        $data = json_encode($msg);

        if ($msg->recipient == 'ns') {
            // no recipient is specified
            foreach ($channel as $sendto) {
                if ($sendto && $sendto !== $client) {
                    try {
                        $sendto->send($data);
                    } catch (Exception $e) {
                        $this->logger->error('Failed to send signaling message', $e);
                    }
                }
            }
        } else {
            // send the message to the specified recipient
            if ($sendto = $channel[$msg->recipient]) {
                try {
                    $sendto->send($data);
                } catch (Exception $e) {
                    $this->logger->error('Failed to send signaling message', $e);
                }
            }
        }
    }

    public function onDisconnect($client) {
        // if the client is still connected with the channel, close the connection
        try {
            $this->closeChannel($client);
        } catch (Exception $e) {
            $this->logger->warn('Exception on closing connection', $e);
        }

        // remove the client from the socket list
        unset($this->clients[$client->getId()]);
    }

    private function printStatus() {
        $log = null;

        foreach ($this->channels as $token => $clients) {
            if ($log === null) {
                $log = '';
            } else {
                $log .= "\n";
            }
            $log .= "Channel: " . $token . ' - ';
            foreach ($clients as $c) {
                $log .= $c->getId() . " ";
            }
        }
        $this->logger->debug($log);
    }

    private function sendRequestAsync($url, $params, $type='POST') {
        if ($params !== null && count($params) > 0) {
            foreach ($params as $key => &$val) {
                if (is_array($val)) {
                    $val = implode(',', $val);
                }
                $post_params[] = $key.'='.urlencode($val);
            }
            $post_string = implode('&', $post_params);

        } else {
            $post_string = '';
        }

        $parts=parse_url($url);

        $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);

        // Data goes in the path for a GET request
        if('GET' == $type) {
            $parts['path'] .= '?' . $post_string;
        }

        $out = "$type ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($post_string)."\r\n";
        $out.= "Connection: Close\r\n\r\n";

        // Data goes in the request body for a POST request
        if ('POST' == $type && isset($post_string)) {
            $out .= $post_string;
        }

        fwrite($fp, $out);
        fclose($fp);
    }

    private function openChannel($msg, $client) {
        $client->setChannelToken($msg->channel_token);
        $client->setName($msg->user_name);

        if (isset($this->channels[$msg->channel_token])) {
            $this->channels[$msg->channel_token][$client->getId()] = $client;
        } else {
            $this->channels[$msg->channel_token] = array($client->getId() => $client);
        }

        // send response
        $response = array();
        $response['type'] = 'channel';
        $response['subtype'] = 'open';
        $response['participant_id'] = $client->getId();
        $response['participant_cnt'] = $this->getParticipantCount($this->channels[$msg->channel_token]);
        $response['participant_list'] = $this->getParticipantList($this->channels[$msg->channel_token], $client);

        $client->send(json_encode($response));
    }

    private function closeChannel($client) {
        if ($client->getChannelToken() === null) {
            return;
        }

        $channel = $this->channels[$client->getChannelToken()];

        // send channel close message to the remaining participants
        $msg = array();
        $msg['type'] = 'channel';
        $msg['subtype'] = 'bye';
        $msg['participant_id'] = $client->getId();

        $msg_json = json_encode($msg);

        foreach ($channel as $sendto) {
            if ($sendto && $sendto !== $client) {
                try {
                    $sendto->send($msg_json);
                } catch (Exception $e) {
                    $this->logger->error('Failed to send channel bye message', $e);
                }
            }
        }

        // close the connection between the client and the channel
        unset($this->channels[$client->getChannelToken()][$client->getId()]);

        $client->setChannelToken(null);

        // send response
        $response = array();
        $response['type'] = 'channel';
        $response['subtype'] = 'close';
        $response['result'] = 0;

        try {
            $client->send(json_encode($response));
        } catch (Exception $e) {
            $this->logger->error('Failed to send response for channel close message', $e);
        }

        $data = array();
        $data['client_id'] = $client->getId();
        $data['channel_token'] = $client->getChannelToken();
        $this->sendChannelEvent('client_disconnected', $data);
    }

    private function responseCurrentStatus($client) {
        $response = array();
        $response['type'] = 'channel';
        $response['subtype'] = 'status';
        $response['result'] = 0;
        $response['channel_list'] = $this->getChannelList();
        $response['time'] = date('Y-m-d h:i:s A', time());

        try {
            $client->send(json_encode($response));
        } catch (Exception $e) {
            $this->logger->error('Failed to send response for channel close message', $e);
        }
    }

    private function getParticipantCount($channel) {
        return count($channel) - 1;
    }

    private function getParticipantList($channel, $client) {
        $participant_list = array();
        foreach ($channel as $participant) {
            if (!$client || $participant->getId() !== $client->getId()) {
                $participant_list[$participant->getId()] = array(
                    "name" => $participant->getName(),
                );
            }
        }
        return $participant_list;
    }

    private function getChannelList() {
        $channel_list = array();
        foreach ($this->channels as $token => $channel) {
            $channel_list[$token] = $this->getParticipantList($channel, null);
        }
        return $channel_list;
    }

    private function sendChannelEvent($type, $data) {
        if (!$data) {
            $data = array();
        }
        $data['type'] = $type;
        $this->sendRequestAsync($this->config['rest_server'], $data, 'POST');
    }
}
