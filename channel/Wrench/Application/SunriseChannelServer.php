<?php

namespace Wrench\Application;

use Wrench\Application\Application;
use Wrench\Application\NamedApplication;
use Wrench\Exception;

/**
 * Sunrise channel server for signaling and chattting.
 */
class SunriseChannelServer extends Application {
    protected $clients = array();
    protected $config = null;
    protected $channels = array();
    protected $channel_close_pending = array();

    public function __construct($config) {
        $this->config = $config;
        $this->sendChannelEvent('server_start', null);
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
                        echo "channel closed: " . $token . "\n";
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
            $client->log('onData(): ' . $e, 'err');
        }
    }

    private function onChannelMessage($client, $msg) {
        switch ($msg->subtype) {
        case 'open':
            $client->log('channel open: ' . $msg->channel_token . ': ' . $msg->user_name);
            $this->openChannel($msg, $client);
            break;
        case 'close':
            $client->log('channel close: ' . $client->getChannelToken() . ': ' . $client->getName());
            $this->closeChannel($client);
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
                        $sendto->log('send chat message: ' . $e, 'err');
                    }
                }
            }
        } else {
            // send the message to the specified recipient
            if ($sendto = $channel[$msg->recipient]) {
                try {
                    $sendto->send($data);
                } catch (Exception $e) {
                    $sendto->log('send signaling message: ' . $e, 'err');
                }
            }
        }
    }

    private function onSignalingMessage($client, $msg) {
        $channel = $this->channels[$client->getChannelToken()];
        $data = json_encode($msg);

        if ($msg->recipient == 'ns') {
            // no recipient is specified
            foreach ($channel as $sendto) {
                if ($sendto && $sendto !== $client) {
                    try {
                        $sendto->send($data);
                    } catch (Exception $e) {
                        $sendto->log('send signaling message: ' . $e, 'err');
                    }
                }
            }
        } else {
            // send the message to the specified recipient
            if ($sendto = $channel[$msg->recipient]) {
                try {
                    $sendto->send($data);
                } catch (Exception $e) {
                    $sendto->log('send signaling message: ' . $e, 'err');
                }
            }
        }
    }

    public function onDisconnect($client) {
        // if the client is still connected with the channel, close the connection
        $this->closeChannel($client);

        // remove the client from the socket list
        unset($this->clients[$client->getId()]);
    }

    private function printStatus() {
        foreach ($this->channels as $token => $clients) {
            echo "channel:" . $token. "\n";
            foreach ($clients as $c) {
                echo "\t" . $c->getId() . "\n";
            }
        }
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
        $response['participant_cnt'] = count($this->channels[$msg->channel_token]) - 1;

        $participant_list = array();
        foreach ($this->channels[$msg->channel_token] as $participant) {
            if ($participant->getId() !== $client->getId()) {
                $participant_list[$participant->getId()] = array(
                    "name" => $participant->getName(),
                );
            }
        }
        $response['participant_list'] = $participant_list;

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
                    $sendto->log('failed to send channel bye message - ' . $e, 'err');
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
            $client->log('channel close: failed to send response - ' . $e, 'err');
        }

        $data = array();
        $data['client_id'] = $client->getId();
        $data['channel_token'] = $client->getChannelToken();
        $this->sendChannelEvent('client_disconnected', $data);
    }

    private function sendChannelEvent($type, $data) {
        if (!$data) {
            $data = array();
        }
        $data['type'] = $type;
        $this->sendRequestAsync($this->config['rest_server'], $data, 'POST');
    }
}
