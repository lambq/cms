<?php

namespace App\Jobs;

use QL\QueryList;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;

class DigArticleJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $punct;
    protected $url;
    protected $col;
    public function __construct($url, $col, $action)
    {
        $this->punct    = new WhitespaceAndPunctuationTokenizer();
        $this->url      = $url;
        $this->col      = $col;
        $this->action   = $action;
        if($this->action == 'dzyule'){
            return $this->dzyule($this->url, $this->col);
        }
        if($this->action == 'ylxinwen'){
            return $this->ylxinwen($this->url, $this->col);
        }
        if($this->action == 'mimito'){
            return $this->mimito($this->url, $this->col);
        }
    }
    public function handle()
    {

    }
    public function dzyule()
    {
        $data    = $this->check($this->url);
        $ql	= QueryList::rules([
            //采集规则
            'title'         => ['.new_con h1','text'],
            'description'   => ['meta[name=description]','content'],
            'content'       => ['.new_con .text','html'],
        ]);
        $data = $ql->html($data)->query()->getData(function ($item) {
            //利用回调函数下载文章中的图片并替换图片路径为本地路径
            //使用本例请确保当前目录下有image文件夹，并有写入权限
            $item['title']          = $item['title'];
            $item['keywords']       = $this->getKeywords($item['content'],$item['title']);
            $item['content']        = $item['content'];
            $item['copy_from']      = '本站原创';
            $content = QueryList::html($item['content']);
            $content->find('img')->map(function($img){
                $src = $img->attr('src');
                $localSrc = 'article/images/'.md5($src).'.jpg';
                $img->removeAttr('style');
                $img->removeAttr('alt');
                $img->removeAttr('_src');
                $img->addClass('load');
                $img->attr('lay-src', env('IMG_URL').$localSrc);
                $img->attr('src', env('IMG_URL').'files/loading.gif');
                QiNiuJobs::dispatch($src,$localSrc);
            });
            $value  = str_replace('href="http://news.dzyule.com/"','href="'.env('APP_URL').'/"',$content->find('')->html());
            $value  = str_replace('大众娱乐', env('APP_NAME'), $value);
            $item['image']          = get_img_first($value);
            $item['content']    = $value;
            return $item;
        });
        $ql->destruct();
        $array	= $data->all();
        if(count($array)){
            $article    = DB::table('articles')->where('title', $array['title'])->first();
            if($article){
                return true;
            }else{
                $id = DB::table('articles')->insertGetId([
                    'column_id'     => $this->col,
                    'title'         => $array['title'],
                    'image'         => $array['image'],
                    'copy_from'     => $array['copy_from'],
                    'keywords'      => $array['keywords'],
                    'description'   => $array['description'],
                    'content'       => $array['content'],
                    'state'         => 1,
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ]);
                if($id){
                    //$this->ziyuan($id);
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
    public function ylxinwen()
    {
        $data    = $this->check($this->url);
        $ql	= QueryList::rules([
            //采集规则
            'title'         => ['.son .left h2','text'],
            'keywords'		=> ['meta[name=keywords]','content'],
            'description'   => ['meta[name=description]','content'],
            'content'       => ['.son .left .details','html'],
        ]);
        $data = $ql->html($data)->query()->getData(function ($item) {
            //利用回调函数下载文章中的图片并替换图片路径为本地路径
            //使用本例请确保当前目录下有image文件夹，并有写入权限
            $item['copy_from']      = '本站原创';
            $content = QueryList::html($item['content']);
            $content->find('img')->map(function($img){
                $srcs = $img->attr('src');
                $src = 'http://www.ylxinwen.com'.$srcs;
                $localSrc = 'article/images/'.md5($src).'.jpg';
                $img->removeAttr('alt');
                $img->removeAttr('src');
                $img->addClass('load');
                $img->attr('lay-src', env('IMG_URL').$localSrc);
                $img->attr('src', env('IMG_URL').'files/loading.gif');
                QiNiuJobs::dispatch($src,$localSrc);
            });
            $value  = str_replace('href="http://www.ylxinwen.com/"','href="'.env('APP_URL').'/"',$content->find('')->html());
            $value  = str_replace('娱乐新闻网', env('APP_NAME'), $value);
            $item['image']          = get_img_first($value);
            $item['content']    = $value;
            return $item;
        });
        $ql->destruct();
        $array	= $data->all();
        if(count($array)){
            $article    = DB::table('articles')->where('title', $array['title'])->first();
            if($article){
                return true;
            }else{
                $id = DB::table('articles')->insertGetId([
                    'column_id'     => $this->col,
                    'title'         => $array['title'],
                    'image'         => $array['image'],
                    'copy_from'     => $array['copy_from'],
                    'keywords'      => $array['keywords'],
                    'description'   => $array['description'],
                    'content'       => $array['content'],
                    'state'         => 1,
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ]);
                if($id){
                    //$this->ziyuan($id);
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
    public function mimito()
    {
        $data   = $this->check($this->url);
        $data   = preg_replace("'<script[^>]*?>.*?</script>'si", '', $data);
        $ql	= QueryList::rules([
            //采集规则
            'title'         => ['.main .left2 .content h1','text'],
            'description'   => ['meta[name=description]','content'],
            'content'       => ['.main .left2 .content .content_01','html'],
        ]);
        $data = $ql->html($data)->query()->getData(function ($item) {
            //利用回调函数下载文章中的图片并替换图片路径为本地路径
            //使用本例请确保当前目录下有image文件夹，并有写入权限
            $item['title']          = $item['title'];
            $item['keywords']       = $this->getKeywords($item['content'],$item['title']);
            $item['content']        = $item['content'];
            $item['copy_from']      = '互联网原创';
            $content = QueryList::html($item['content']);
            $content->find('img')->map(function($img){
                $src = $img->attr('src');
                $localSrc = 'article/images/'.md5($src).'.jpg';
                $img->removeAttr('onload');
                $img->removeAttr('src');
                $img->addClass('load');
                $img->attr('lay-src', env('IMG_URL').$localSrc);
                $img->attr('src', env('IMg_URL_FILE'));
                $src = 'http://www.mimito.com.cn'.$src;
                QiNiuJobs::dispatch($src,$localSrc);
            });
            $value  = str_replace('href="http://www.mimito.com.cn/"','href="'.env('APP_URL').'/"',$content->find('')->html());
            $value  = str_replace('女人街', env('APP_NAME'), $value);
            $item['image']          = get_img_first($value);
            $item['content']    = $value;
            return $item;
        });
        $ql->destruct();
        $array	= $data->all();
        if(count($array)){
            $article    = DB::table('articles')->where('title', $array['title'])->first();
            if($article){
                return true;
            }else{
                $id = DB::table('articles')->insertGetId([
                    'column_id'     => $this->col,
                    'title'         => $array['title'],
                    'image'         => $array['image'],
                    'copy_from'     => $array['copy_from'],
                    'keywords'      => $array['keywords'],
                    'description'   => $array['description'],
                    'content'       => $array['content'],
                    'state'         => 1,
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ]);
                if($id){
                    //$this->ziyuan($id);
                    return true;
                }else{
                    return false;
                }
            }
        }else{
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
        if($code['http_code'] == 200){
            $encode = mb_detect_encoding($data, ["ASCII","UTF-8","GB2312","GBK","BIG5"]);
            if($encode != 'UTF-8'){
                if($encode == 'EUC-CN' || $encode == 'CP936'){
                    $data = @mb_convert_encoding($data, 'UTF-8', 'CP936');
//                    print_r($data);die;
                    $data = str_replace('<meta http-equiv="Content-Type" content="text/html; charset=gbk" />','<meta charset="utf-8">',$data);
                    $data = str_replace('<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />','<meta charset="utf-8">',$data);
                }else{
                    $data = @mb_convert_encoding($data, 'UTF-8', 'GB2312');
                    $data = str_replace('<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />','<meta charset="utf-8">',$data);
                }
            }
            return $data;
        }else{
            return false;
        }
    }
    //
    function ziyuan($id)
    {
        $urls = array(
            env('APP_URL').'/artinfo-'.$id.'.html',
        );
        $api = env('BAIDUZHANZHANG');
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        return $result;
    }

    function getKeywords($keywords,$title)
    {
        $keywords       = strip_tags($keywords);
        $punct          = $this->punct->tokenize($keywords);
        $array          = $this->arrayMaxMin($punct,$title);
        return $array;
    }

    function arrayMaxMin(array $content,string $title)
    {
        $array  = [];
        foreach ($content as $v)
        {
            if(mb_strlen($v) > 4 && mb_strlen($v) < 6 && !is_numeric($v) && $v != 'https'){
                $array[]    = $v;
            }
        }
        if (count($array))
        {
            $array = array_slice($array,0,5);
            return implode(",",$array);
        } else {
            return $title;
        }
    }
}
