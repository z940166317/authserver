<?php
/**
 * Create by PhpStorm
 * Author Aaron z
 * Date: 2019-07-30
 * Time: 15:18
 */

namespace xlauth\server;


use xlauth\authServerInterface;

class deviceServer extends authServer
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->setAppPlatform('device');
    }

    public function setDeviceId($deviceId){
        if (empty($deviceId)){
            throw new \Exception('deviceId not be empty');
        }

        $this->setParams(['deviceId' => $deviceId]);

        return $this;
    }

}