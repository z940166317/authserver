<?php
/**
 * Create by PhpStorm
 * Author Aaron z
 * Date: 2019-07-22
 * Time: 14:01
 */

namespace xlauth;


class config
{
    private $files;

    private $conf;

    public function __construct($dir = null)
    {
        if (empty($dir)){
            $dir = __DIR__.'/config';
        }

        $this->scanDir($dir);
        $this->load();
    }

    private function scanDir($dirPath){
        if (!is_dir($dirPath)) return false;
        $dirPath = realpath($dirPath) . '/';
        $dirs = array( $dirPath );

        $fileContainer = array();
        $dirContainer = array();

        try {
            do {
                $workDir = array_pop($dirs);
                $scanResult = scandir($workDir);
                foreach ($scanResult as $files) {
                    if ($files == '.' || $files == '..') continue;
                    $realPath = $workDir . $files;
                    if (is_dir($realPath)) {
                        array_push($dirs, $realPath . '/');
                        $dirContainer[] = $realPath;
                    } elseif (is_file($realPath)) {
                        $fileContainer[] = $realPath;
                    }
                }
            } while ($dirs);
        } catch (\Throwable $throwable) {
            return $throwable;
        }

        $this->files = [ 'files' => $fileContainer, 'dirs' => $dirContainer ];
        return true;
    }

    private function load(){
        if (is_array($this->files)) {
            foreach ($this->files['files'] as $file) {
                $fileNameArr = explode('.', $file);
                $fileSuffix = end($fileNameArr);
                if ($fileSuffix == 'php') {
                    if (is_file($file)) {
                        $confData = require_once $file;
                        if (is_array($confData) && !empty($confData)) {
                            $basename = strtolower(basename($file, '.php'));
                            $this->conf[$basename] = $confData;
                        }
                    }
                }
            }
        }
    }

    public function get($string){

        $list = explode('.',$string);

        if (count($list) == 2){
            $ret = $this->conf[$list[0]][$list[1]];
        }elseif(count($list) == 3){
            $ret = $this->conf[$list[0]][$list[1]][$list[2]];
        }else{
            return new \ErrorException('config up to two level');
        }

        return $ret;
    }

}