<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class Dig0auu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dig:0auu {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dig:0auu all|update';
    
    protected $client;
    protected $token;
    protected $articleQuery;
    protected $siteQuery;
    protected $key;
    protected $expiredAt;
    protected $yesterday;
    protected $totalNum;
    protected $randNum;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->token        = 'Bearer '.env('token');
        $this->articleQuery = [
            'query'     => [
                'page'      => 1,
            ]
        ];
        $this->key          = '0auu_'.date('Y-m-d', time());
        $this->expiredAt    = now()->addMinutes(1680);
        $this->yesterday    = '0auu_'.date("Y-m-d",strtotime("-1 day"));
        $this->randNum      = 100;
        $this->totalNum     = 0;
        $dayNum             = Cache::get('dayNum');
        $this->dayNum       = $dayNum ? $dayNum : 0;
    }
    
    function category($num)
    {
        switch ($num)
        {
            case 18:
                return 1;
            case 19:
                return 2;
            case 20:
                return 4;
            case 21:
                return 3;
            case 29:
                return 4;
            case 34:
                return 3;
            case 32:
                return 4;
            case 31:
                return 2;
            case 39:
                return 5;
            case 40:
                return 5;
            case 48:
                return 7;
                break;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->dayNum >= 1500)
        {
            $this->line('今天文章已更新（'.$this->dayNum.'）完毕！');die();
        }
        $today      = Cache::get($this->key);
        $yesterday  = Cache::get($this->yesterday);
        $page   = $today ? $today : $yesterday;
        $page   = $page ? $page : 1;
        $this->articleQuery['query']['page']    = $page;
        $action   = $this->argument('action');
        if ($action == 'update'){
            $this->articleQuery['query']['mode']    = 'update';
            $this->siteQuery['query']['mode']       = 'update';
        }
        $this->article('http://hh.0auu.com/api/v1/article');
    }
    
    function article($url)
    {
        if ($this->totalNum >= $this->randNum)
        {
            Cache::put($this->key, $this->articleQuery['query']['page'], $this->expiredAt);
            Cache::put('dayNum', $this->dayNum, $this->expiredAt);
            $this->line('今天文章已更新('.$this->totalNum.')篇');die();
        }
        $this->line('文章更新到('.$this->totalNum.')篇文章，总共（'.$this->randNum.'）篇');
        $this->line('执行第（'.$url.'?page='.$this->articleQuery['query']['page'].')页');
        $response   = $this->sendPost('article', $url);
        // $response   = $this->getFollow($this->sendPost('article', $url));
        // print_r($response);die();
        if ($response)
        {
            $this->makeArticle($response);
        } else {
            $this->line('此页面获取失败！');
        }
    }
    function makeArticle($array)
    {
        if ($array['data'])
        {
            $urls   = [];
            $data   = $this->getFollow($array['data']);
            foreach ($data as $v)
            {
               $urls[]  = $this->saveArticle($v);
            }
            $this->ziyuan($urls);
        }
        if($array['links']['next'])
        {
            $this->articleQuery['query']['page']    = $this->articleQuery['query']['page'] + 1;
            $this->article($array['meta']['path']);
        } else {
            Cache::put($this->key, $this->articleQuery['query']['page'], $this->expiredAt);
            Cache::put('dayNum', $this->dayNum, $this->expiredAt);
            $this->line('文章数据已经更新完毕！');
        }
    }
    function saveArticle($array)
    {
        $this->totalNum +=1; //计数器
        $this->dayNum   +=1; //计数器
        $article = DB::table('articles')->where('title', $array['title'])->first();
        // print_r($array);
        if($article)
        {
            DB::table('articles')->where('id', $article->id)->update([
                'users_id'          => 1,
                'column_id'         => 5,
                'title'             => $array['title'],
                'copy_from'         => '网络',
                'keywords'          => $array['keywords'],
                'image'             => $array['image'],
                'description'       => $array['description'],
                'content'           => str_replace('\\"', '"', $array['content']),
                'state'             => 1,
                'created_at'        => date('Y-m-d H:i:s',time()),
                'updated_at'        => date('Y-m-d H:i:s',time()),
            ]);
            return env('APP_URL').'/show/'.$article->id.'.html';
        } else {
            $id = DB::table('articles')->insertGetId([
                'users_id'          => 1,
                'column_id'         => 5,
                'title'             => $array['title'],
                'copy_from'         => '网络',
                'keywords'          => $array['keywords'],
                'image'             => $array['image'],
                'description'       => $array['description'],
                'content'           => str_replace('\\"', '"', $array['content']),
                'state'             => 1,
                'created_at'    => date('Y-m-d H:i:s',time()),
                'updated_at'    => date('Y-m-d H:i:s',time()),
            ]);
            if($id){
                return env('APP_URL').'/show/'.$id.'.html';
            }else{
                return false;
            }   
        }
    }
    
    public function sendPost($class, $url)
    {
        $client     = new Client();
        
        if ($class == 'site')
        {
            $array  = $this->siteQuery;
        }
        if ($class == 'article')
        {
            $array  = $this->articleQuery;
        }
        $response   = $client->request('GET', $url, $array);
        $code   = $response->getStatusCode();
        if ($code == 200)
        {
            return json_decode($response->getBody(), true);
        } else {
            return false;
        }
    }
    
    function ziyuan($urls)
    {
        $urls       = array_filter($urls);
        // print_r($urls);
        $api        = env('BAIDUZHANZHANG');
        $ch         = curl_init();
        $options    =  array(
            CURLOPT_URL             => $api,
            CURLOPT_POST            => true,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POSTFIELDS      => implode("\n", $urls),
            CURLOPT_HTTPHEADER      => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result     = curl_exec($ch);
        return $result;
    }
    
    public function getFollow($follow)
    {
        foreach ($follow as $v){
            yield $v;
        }
    }
}
