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

    public function __construct($config) {
        $this->config = $config;
        $this->initDatabase();
    }

    public function onConnect($client) {
        $this->clients[$client->getId()] = $client;
    }

    public function onUpdate() {
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

//        global $sr_rest_server;
//        global $sr_rest_room_join;

//        if ($client->getParticipantId() !== null) {
//            $response = array();
//            $response['type'] = 'room';
//            $response['subtype'] = 'join';
//            $response['result'] = 1;
//            $response['msg'] = 'You are in the other room. Please close the other room before joining to a new room';
//            $client->send(json_encode($response));
//            return;
//        }

        // send room join request to the Sunrise VC server
        /*
        $url = $sr_rest_server . $sr_rest_room_join;
        $params = array();
        $params['room_id'] = $msg->room_id;
        $params['is_registered_user'] = $msg->is_registered_user;
        $params['user_name'] = $msg->user_name;
        $params['user_id'] = $msg->user_id;
        $params['ip_address'] = $client->getIp();

        $this->sendRequestAsync($url, $params, 'POST');
        */

        // store room information
//        $client->setRoomId($msg->room_id);
//        $client->setParticipantId($msg->participant_id);
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

        // remove the channel if there is no client connected to the channel
        if (count($this->channels[$client->getChannelToken()]) == 0) {
            unset($this->channels[$client->getChannelToken()]);
        }

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

//        global $sr_rest_server;
//        global $sr_rest_room_exit;

        // send room exit request to the Sunrise VC server
//        $url = $sr_rest_server . $sr_rest_room_exit;
//        $params['participant_id'] = $client->getParticipantId();
//        $this->sendRequestAsync($url, $params, 'POST');

        // close the connection
//        $client->setRoomId(null);
//        $client->setParticipantId(null);
    }

    private function closeRoom($client) {
        global $sr_rest_server;
        global $sr_rest_room_close;

        unset($this->channels[$client->getRoomId()]);

        $url = $sr_rest_server . $sr_rest_room_close;

        $params['room_id'] = $client->getRoomId();
        $this->sendRequestAsync($url, $params, 'POST');
    }

    private function initDatabase() {
        global $sr_rest_server;
        global $sr_rest_room_init;

        // send message to initialize database for room information
        $url = $sr_rest_server . $sr_rest_room_init;
        $this->sendRequestAsync($url, null, 'POST');
    }
}
