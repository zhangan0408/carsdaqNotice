<?php


namespace Carsdaq\Notice\Pusher;


use Carsdaq\Notice\IOS\IOSNative;

class IOSNativeCodePusher
{
    protected $ios_pem_mode;

    public function __construct()
    {

    }

    /**
     * 原生IOS推送
     * @param array $data
     * @param array $pemPathArr
     * @return bool
     * @throws \Carsdaq\Notice\Exception\UmengException
     */
    public function sendNativeCodeMsg($data = [],$pemPathArr = []) {
        $nativeCode = new IOSNative($data);
        $this->ios_pem_mode = config('umeng.pem_mode');
        $nativeCode->setParam();
        $nativeCode->setProductionMode($this->ios_pem_mode);
        if ($this->ios_pem_mode) { // 正式
            $pemPath = isset($pemPathArr['master'])? $pemPathArr['master']: '';
            $nativeCode->setPathPem($pemPath);
        } else { // 测试
            $pemPath = isset($pemPathArr['dev'])? $pemPathArr['dev']: '';
            $nativeCode->setPathPem($pemPath);
        }
        $nativeCode->isComplete();
        return $nativeCode->send();
    }

}