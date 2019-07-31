XL authServer client
=======================
##### 当前支持趣头条 `qtt` 微信 `weixin` 魅族 `meizu` OPPO `oppo` 扩展中. . .

- Install

~~~
composer require xlwl/authserver
~~~

- Quick start

~~~php
use xlauth\serverFactory;

$serverFactory = new serverFactory('test'); /*实例化平台*/

$testServer = $serverFactory->getServer();  /*获取服务*/
$testServer->setAppCode('test');    /*设置app*/

$testServer->setClientId('s5oK0ruYn3HAhhycmaZh')->setSecret('9VMDvvVWPLpRcWKJmpzzKNAsorZl0Mu2k0u0f4aoosKSqGllKH')->setParams(['sessionKey' => '3ae285219845205c98985081a75439405caf64a8']); /*设置clientId、secret、请求参数*/
//or set host port
$testServer->setHost('http://www.xxx.com')->setPort('')->setClientId('s5oK0ruYn3HAhhycmaZh')->setSecret('9VMDvvVWPLpRcWKJmpzzKNAsorZl0Mu2k0u0f4aoosKSqGllKH')->setParams(['sessionKey' => '3ae285219845205c98985081a75439405caf64a8']); /*设置clientId、secret、请求参数*/

try{
    $ret = $testServer->token();    /*获取token和用户信息*/
//    $ret = $testServer->getUserInfoByToken('025220AA1132CA46EE63C616F5C210BF'); /*通过token获取用户信息*/
//    $ret = $testServer->getTokenByrRefreshToken('3e3bca9eed66499a03e16378fbd7173e');    /*通过refertoken生成新的token*/
}catch (Exception $e){
    print_r($e->getMessage());
    die();
}

print_r($ret);
~~~

- Explain

~~~php
//不同平台认证需要参数不同，需要根据实际情况设置
$testServer->setParams(['code' => $code]); /*微信*/
$testServer->setParams(['ticke' => $ticket,'paltform' => $platform]);   /*趣头条*/
//或者......
$testServer->setSessionKey($sessionKey)->setOtherParam($param)
~~~
[Detailed](./DESCRIPTION.md)