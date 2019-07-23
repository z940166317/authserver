<?php
/**
 * Create by PhpStorm
 * Author Aaron z
 * Date: 2019-07-23
 * Time: 10:19
 */

require_once "../vendor/autoload.php";

use xlauth\serverFactory;

$serverFactory = new serverFactory('test'); /*实例化平台*/

$testServer = $serverFactory->getServer();  /*获取服务*/
$testServer->setAppCode('test');    /*设置app*/

$testServer->setClientId('s5oK0ruYn3HAhhycmaZh')->setSecret('9VMDvvVWPLpRcWKJmpzzKNAsorZl0Mu2k0u0f4aoosKSqGllKH')->setParams(['sessionKey' => '3ae285219845205c98985081a75439405caf64a8']); /*设置clientId、secret、请求参数*/

try{
    $ret = $testServer->token();    /*获取token和用户信息*/
//    $ret = $testServer->getUserInfoByToken('025220AA1132CA46EE63C616F5C210BF'); /*通过token获取用户信息*/
//    $ret = $testServer->getTokenByrRefreshToken('3e3bca9eed66499a03e16378fbd7173e');    /*通过refertoken生成新的token*/
}catch (Exception $e){
    print_r($e->getMessage());
    die();
}

print_r($ret);