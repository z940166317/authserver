#### test
* 仅用来测试服务是否正常
#### qtt
* 必要参数 `ticket` `platform`
* 方式
~~~php
$weixinServer->setTicket($code)->setPlatform($platform);
//or
$qttServer->setTicket($ticket);
$qttServer->setPlatform($platform);
//or
$weixinServer->setParams(['ticket' => $ticket,'platform' => $platform]);
~~~
* ##### _建议使用前两种_
#### weixin
* 必要参数 `code` 
* 若使用 `setParams()`
~~~php
$weixinServer->serParams(['wxCode' => $wxCode]);
~~~
#### meizu
* 必要参数 `token`
#### oppo
* 必要参数 `token`
