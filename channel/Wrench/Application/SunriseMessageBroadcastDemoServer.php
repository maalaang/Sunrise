<?php

namespace Wrench\Application;

use Wrench\Application\Application;
use Wrench\Application\NamedApplication;

class SunriseMessageBroadcastDemoServer extends Application
{
    protected $clients = array();
    protected $lastTimestamp = null;

    public function onConnect($client)
    {
        $this->clients[] = $client;
    }

    public function onUpdate()
    {
        // limit updates to once per second
        if(time() > $this->lastTimestamp) {
            $this->lastTimestamp = time();

        }
    }

    public function onData($data, $client)
    {
        foreach ($this->clients as $key => $sendto) {
            try {
                if ($sendto !== $client) {
                    $sendto->send($data);
                }
            } catch (Exception $e) {
                $client->getLogger()->error('Data send failed', $e);
            }
        }
    }

    public function onDisconnect($client)
    {
        if (($key = array_search($client, $this->clients)) !== false) {
            unset($this->clients[$key]);
        }
    }
}
