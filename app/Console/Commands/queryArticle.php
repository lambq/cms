<?php

namespace App\Console\Commands;

use App\Jobs\DigImg;
use Carbon\Carbon;
use QL\QueryList;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class queryArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queryArticle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'queryArticle';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $art = DB::table('articles')->where('id', 72945)->first();
        $content = QueryList::html($art->seo_content);
        $content->find('img')->map(function($img){
            $src        = $img->attr('lay-src');
            $tionSrc    = str_replace('https://29cz.com/', '', $src);
            $localSrc   = str_replace('https://29cz.com/', 'https://img.622n.com/', $src);
            $this->image($localSrc, $tionSrc);
        });
    }
    
    public function image($src, $localSrc)
    {

        //文件是否存在
        $disk = Storage::disk('public');
        if (!$disk->exists($localSrc))
        {
            $contents   = $this->check($src);
            if($contents)
            {
                $disk->put($localSrc, $contents); //上传文件
                // Storage::disk('upyun')->write($this->loacl, $contents);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    //抓取网址
    function check($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取网址
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Baiduspider/3.0; +http://www.baidu.com/search/spider.html)");//伪造百度蜘蛛头部
        $ip = '220.181.7.121';
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));//伪造百度蜘蛛IP
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//
//        curl_setopt($ch, CURLOPT_HEADER, true); //抓取服务器信息
        curl_setopt($ch, CURLOPT_NOBODY, false); //抓取网页信息
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //支持301跳转
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30); //网页等待时间
        $data = curl_exec($ch);
        $code = curl_getinfo($ch);
        curl_close($ch);
        if($code['http_code'] == 200 || $code['http_code'] == 304){
            return $data;
        }else{
            return false;
        }
    }
}