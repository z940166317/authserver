<?php
/**
 * Create by PhpStorm
 * Author Aaron z
 * Date: 2019-07-22
 * Time: 14:51
 */

namespace xlauth;


use xlauth\server\deviceServer;
use xlauth\server\meizuServer;
use xlauth\server\oppoServer;
use xlauth\server\qttServer;
use xlauth\server\testServer;
use xlauth\server\weixinServer;

class serverFactory
{
    const PLATFORMARR = ['qtt','weixin','test','oppo','meizu','device']; /*当前支持的服务*/

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

    /**
     * 实例化具体服务
     * @return meizuServer|oppoServer|qttServer|weixinServer
     * @throws \Exception
     */
    public function getServer(){

        switch ($this->platformName){
            case 'test':
                $authServer = new testServer();
                break;
            case 'qtt':
                $authServer = new qttServer();
                break;
            case 'weixin':
                $authServer = new weixinServer();
                break;
            case 'oppo':
                $authServer = new oppoServer();
                break;
            case 'meizu':
                $authServer = new meizuServer();
                break;
            case 'device':
                $authServer = new deviceServer();
                break;
            default:
                throw new \Exception('invalid platform');
                break;
        }

        return $authServer;
    }

}