<?php
/**
 * Create by PhpStorm
 * Author Aaron z
 * Date: 2019-07-22
 * Time: 11:32
 */

namespace xlauth\server;


use GuzzleHttp\Client;
use xlauth\authServerInterface;
use xlauth\config;

class authServer implements authServerInterface
{
    private $conf;
    private $headers;

    private $host;
    private $port;

    protected $params;
    protected $response;
    protected $client;
    protected $appCode;
    protected $appPlatform;
    protected $clientId;
    protected $secret;

    public function __construct()
    {
        $this->initialize();
        $this->conf = new config();
        $this->client = new Client();
    }

    public function initialize(){

    }

    /**
     * @param null $dir 绝对目录
     * @throws \Exception
     */
    public function registerConf($dir = null){
        if (empty($dir) || is_file($dir)){
            throw new \Exception('dir is incorrect');
        }

        $this->conf = new config($dir);
    }

    public function token()
    {
        // TODO: Implement send() method.

        $this->getCode();

        $options = [
            'headers' => $this->getHeaders(),
            'form_params' => $this->getParams()
        ];

        $response = $this->client->post($this->getHost().':'.$this->getPort().$this->getTokenApi(),$options);

        $ret = json_decode($response->getBody()->getContents(),true);

        if ($response->getStatusCode() != 200 || $ret['code'] != 0){
            throw new \Exception($ret['msg']);
        }

        $this->response = $ret;
        return $ret;
    }

    public function getAuthRet()
    {
        // TODO: Implement getAuthRet() method.
        return $this->response;
    }

//    public function setConf($key,$value){
//        $this->$key = $value;
//        return $this;
//    }

    public function setParams(array $params){
        foreach ($params as $k => $v){
            $this->params[$k] = $v;
        }
    }

    private function getParams(){
        return $this->params;
    }

    public function setHost(string $host){
        $this->host = $host;
        return $this;
    }

    public function setPort($port){
        $this->port = $port;
        return $this;
    }

    private function getHost(){
        if (!empty($this->host)){
            return $this->host;
        }
        return $this->conf->get('data.host');
    }

    private function getPort(){
        if (!empty($port)){
            return $this->port;
        }
        return $this->conf->get('data.port');
    }

    private function getCodeApi(){
        return $this->conf->get('data.api.code');
    }

    private function getTokenApi(){
        return $this->conf->get('data.api.token');
    }

    private function getRefreshTokenApi(){
        return $this->conf->get('data.api.refreshToken');
    }

    private function getUserInfoApi(){
        return $this->conf->get('data.api.getUserInfo');
    }

    private function getHeaders(){
        $this->headers['appcode'] = $this->appCode;
        $this->headers['appplatform'] = $this->appPlatform;
        return $this->headers;
    }

    public function setHeaders(array $headers){
        foreach ($headers as $k => $v){
            $this->headers[$k] = $v;
        }
    }

    protected function getCode(){
        $options = [
            'headers' => $this->getHeaders(),
            'form_params' => [
                'clientId' => $this->clientId,
                'secret' => $this->secret
            ]
        ];

        $response = $this->client->post($this->getHost().':'.$this->getPort().$this->getCodeApi(),$options);

        $ret = json_decode($response->getBody()->getContents(),true);

        if ($response->getStatusCode() != 200 || $ret['code'] != 0){
            throw new \Exception($ret['msg']);
        }

        $this->params['code'] = $ret['data']['code'];
    }

    public function setAppCode($appCode){
        $this->appCode = $appCode;
        return $this;
    }

    protected function setAppPlatform($appPlatform){
        $this->appPlatform = $appPlatform;
        return $this;
    }

    public function setClientId($clientId){
        $this->clientId = $clientId;
        return $this;
    }

    public function setSecret($secret){
        $this->secret = sha1($secret);
        return $this;
    }

    /**
     * 刷新token
     * @param $refreshToken
     * @return mixed
     * @throws \Exception
     */
    public function getTokenByrRefreshToken($refreshToken){
        if (empty($refreshToken)){
            throw new \Exception('refreshToken is not be empty');
        }

        $options = [
            'headers' => $this->getHeaders(),
            'form_params' => [
                'refreshToken' => $refreshToken,
            ]
        ];

        $response = $this->client->post($this->getHost().':'.$this->getPort().$this->getRefreshTokenApi(),$options);

        $ret = json_decode($response->getBody()->getContents(),true);

        if ($response->getStatusCode() != 200 || $ret['code'] != 0){
            throw new \Exception($ret['msg']);
        }

        $this->response = $ret;
        return $ret;
    }

    /**
     * 通过token获取用户信息
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public function getUserInfoByToken($token){
        if (empty($token)){
            throw new \Exception('token is not be empty');
        }

        $options = [
            'headers' => $this->getHeaders(),
            'form_params' => [
                'token' => $token,
            ]
        ];

        $response = $this->client->post($this->getHost().':'.$this->getPort().$this->getUserInfoApi(),$options);

        $ret = json_decode($response->getBody()->getContents(),true);

        if ($response->getStatusCode() != 200 || $ret['code'] != 0){
            throw new \Exception($ret['msg']);
        }

        $this->response = $ret;
        return $ret;
    }

}