<?php

namespace Wrench\Application;

use Wrench\Application\Application;
use Wrench\Application\NamedApplication;

/**
 * Example application demonstrating how to use Application::onUpdate
 *
 * Pushes the server time to all clients every update tick.
 */
class ServerTimeApplication extends Application
{
    protected $clients = array();
    protected $lastTimestamp = null;

    /**
     * @see Wrench\Application.Application::onConnect()
     */
    public function onConnect($client)
    {
        $this->clients[] = $client;
    }

    /**
     * @see Wrench\Application.Application::onUpdate()
     */
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
                $client->log('Data send failed: ' . $e, 'err');
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
