<?php
/**
 * Create by PhpStorm
 * Author Aaron z
 * Date: 2019-07-22
 * Time: 14:51
 */

namespace xlauth;


use xlauth\server\qttServer;
use xlauth\server\testServer;
use xlauth\server\weixinServer;

class serverFactory
{
    const PLATFORMARR = ['qtt','weixin','test'];

    private $platformName;

    /**
     * authServer constructor.
     * @param $platformName string
     * @throws \ErrorException
     */
    public function __construct($platformName)
    {
        $platformName = strtolower($platformName);
        if (!in_array($platformName,self::PLATFORMARR)){
            throw new \ErrorException('not support the platform');
        }

        $this->platformName = $platformName;
    }

    public function getServer(){

        switch ($this->platformName){
            case 'qtt':
                $authServer = new qttServer();
                break;
            case 'weixin':
                $authServer = new weixinServer();
                break;
            default:
                $authServer = new testServer();
                break;
        }

        return $authServer;
    }

}