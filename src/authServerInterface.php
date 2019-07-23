<?php
/**
 * Create by PhpStorm
 * Author Aaron z
 * Date: 2019-07-22
 * Time: 11:26
 */

namespace xlauth;


interface authServerInterface
{

    public function token();

    public function getAuthRet();

}