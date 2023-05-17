<?php

namespace App\Jobs;

// use zgldh\QiniuStorage\QiniuStorage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QiNiuJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $src;
    protected $localSrc;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($src,$localSrc)
    {
        //
        $this->src      = $src;
        $this->localSrc = $localSrc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 初始化七牛云类
        // $disk = QiniuStorage::disk('qiniu');
        // 文件是否存在
        // if(!$disk->exists($this->localSrc)){
            // 获取图片二进制内容
            // $contents   = $this->check($this->src);
            // if($contents){
                // 上传文件
                // $disk->put($this->localSrc,$contents);
            // }
        // }
    }

    //抓取网址
    function check($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取网址
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Baiduspider/3.0; +http://www.baidu.com/search/spider.html)");//伪造百度蜘蛛头部
        $ip = '220.181.7.121';
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));//伪造百度蜘蛛IP
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//
        curl_setopt($ch, CURLOPT_NOBODY, false); //抓取网页信息
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //支持301跳转
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30); //网页等待时间
        $data = curl_exec($ch);
        $code = curl_getinfo($ch);
        curl_close($ch);
        if($code['http_code'] == 200){
            return $data;
        }else{
            return false;
        }
    }
}
