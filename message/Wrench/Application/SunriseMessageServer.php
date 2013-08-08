<?php

namespace Wrench\Application;

use Wrench\Application\Application;
use Wrench\Application\NamedApplication;

/**
 * Sunrise message server for signaling and chattting.
 */
class SunriseMessageServer extends Application {
    protected $clients = array();
    protected $config = null;
    protected $session_list = array();

    public function __construct($config) {
        $this->config = $config;
        $this->initDatabase();
    }

    public function onConnect($client) {
        $this->clients[] = $client;
    }

    public function onUpdate() {
    }

    public function onData($data, $client) {
        try {
            $msg = json_decode($data);

            switch ($msg->type) {
            case 'session':
                $this->processSessionMessage($data, $client, $msg);
                break;
            case 'chat':
                $this->processChatMessage($data, $client, $msg);
                break;
            case 'bye':
                $this->onDisconnect($client);
                break;
            case 'debug':
                $this->printStatus();
            default:
                $this->processSignalingMessage($data, $client, $msg);
                break;
            }
        } catch (Exception $e) {
            $client->log('onData(): ' . $e, 'err');
        }
    }

    public function onDisconnect($client) {
        $msg = array();
        $msg['type'] = 'bye';
        $msg['participant_id'] = $client->getParticipantId();
        $msg_json = json_encode($msg);

        if (isset($this->session_list[$client->getSessionId()])) {
            foreach ($this->session_list[$client->getSessionId()] as $key => $sendto) {
                try {
                    if ($sendto === $client) {
                        $this->removeClient($client, $key);
                    } else {
                        $sendto->send($msg_json);
                    }
                } catch (Exception $e) {
                    $client->log('Data send failed: ' . $e, 'err');
                }
            }
        } else {
            if (($key = array_search($client, $this->clients)) !== false) {
                $this->removeClient($client, $key);
            }
        }
    }

    public function removeClient($client, $key) {
        if ($client->getParticipantId() !== null) {
            $this->exitSession($client);
        }
        unset($this->clients[$key]);
    }

    private function processChatMessage($data, $client, $msg) {
        foreach ($this->clients as $key => $sendto) {
            try {
                if ($sendto !== $client) {
                    $sendto->send($data);
                }
            } catch (Exception $e) {
                $client->log('Data send failed: ' . $e, 'err');
            }
        }
    }

    private function printStatus() {
        foreach ($this->session_list as $session_id => $clients) {
            echo "session_id:" . $session_id . "\n";
            foreach ($clients as $c) {
                echo "\t" . $c->getParticipantId() . "\n";
            }
        }
    }

    private function processSessionMessage($data, $client, $msg) {
        switch ($msg->subtype) {
        case 'join':
            $client->log('Session Join: ' . $msg->user_name);
            $this->joinSession($msg, $client);
            break;
        case 'exit':
            $client->log('Session Exit: ' . $msg->user_name);
            $this->exitSession($client);
            break;
        }

    }

    private function processSignalingMessage($data, $client, $msg) {
        foreach ($this->session_list[$client->getSessionId()] as $sendto) {
            if ($sendto !== $client) {
                $sendto->send($data);
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

    private function joinSession($msg, $client) {
        global $sr_msg_session_server;
        global $sr_msg_session_api_join;

        if ($client->getParticipantId() !== null) {
            $response = array();
            $response['type'] = 'session';
            $response['subtype'] = 'join';
            $response['result'] = 1;
            $response['msg'] = 'You are in the other room. Please close the other room before joining to a new room';
            $client->send(json_encode($response));
            return;
        }

        // send session join request to the Sunrise VC server
        /*
        $url = $sr_msg_session_server . $sr_msg_session_api_join;
        $params = array();
        $params['session_id'] = $msg->session_id;
        $params['is_registered_user'] = $msg->is_registered_user;
        $params['user_name'] = $msg->user_name;
        $params['user_id'] = $msg->user_id;
        $params['ip_address'] = $client->getIp();

        $this->sendRequestAsync($url, $params, 'POST');
        */

        // store session information
        $client->setSessionId($msg->session_id);
        $client->setParticipantId($msg->participant_id);

        if (isset($this->session_list[$msg->session_id])) {
            $this->session_list[$msg->session_id][] = $client;
        } else {
            $this->session_list[$msg->session_id] = array($msg->participant_id => $client);
        }

        // send response
        $response = array();
        $response['type'] = 'session';
        $response['subtype'] = 'join';
        $response['result'] = 0;

        $client->send(json_encode($response));

    }

    private function exitSession($client) {
        global $sr_msg_session_server;
        global $sr_msg_session_api_exit;

        // send session exit request to the Sunrise VC server
        $url = $sr_msg_session_server . $sr_msg_session_api_exit;
        $params['participant_id'] = $client->getParticipantId();
        $this->sendRequestAsync($url, $params, 'POST');

        // remove this client from the session
        $session = $this->session_list[$client->getSessionid()];
        unset($session[$client->getParticipantId()]);

        if (count($session) == 0) {
            // close the session if there's no one in it
            $this->closeSession($client);
        }

        // send response
        $response = array();
        $response['type'] = 'session';
        $response['subtype'] = 'exit';
        $response['result'] = 0;

        $client->send(json_encode($response));

        // close the connection
        $client->setSessionId(null);
        $client->setParticipantId(null);
    }

    private function closeSession($client) {
        global $sr_msg_session_server;
        global $sr_msg_session_api_close;

        unset($this->session_list[$client->getSessionId()]);

        $url = $sr_msg_session_server . $sr_msg_session_api_close;

        $params['session_id'] = $client->getSessionId();
        $this->sendRequestAsync($url, $params, 'POST');
    }

    private function initDatabase() {
        global $sr_msg_session_server;
        global $sr_msg_session_api_init;

        // send message to initialize database for session information
        $url = $sr_msg_session_server . $sr_msg_session_api_init;
        $this->sendRequestAsync($url, null, 'POST');
    }
}
