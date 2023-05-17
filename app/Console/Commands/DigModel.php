<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class DigModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dig:model {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dig:model all|update';
    
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
        $this->token        = 'Bearer BYHu0uS9lb094EbjvX8';
        $this->articleQuery = [
            'headers'   => [
                'Authorization' => $this->token,
            ],
            'query'     => [
                'category'  => '83,84,85,94',
                'page'      => 1,
            ]
        ];
        $this->key          = 'model_'.date('Y-m-d', time());
        $this->expiredAt    = now()->addMinutes(1680);
        $this->yesterday    = 'model_'.date("Y-m-d",strtotime("-1 day"));
        $this->randNum      = 105;
        $this->totalNum     = 0;
    }
    
    function category($num)
    {
        switch ($num)
        {
            case 83:
                return 1;
            case 84:
                return 4;
            case 85:
                return 3;
            case 94:
                return 2;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
        $this->article('http://121.62.21.105:801/api/v1/article');
    }
    
    function article($url)
    {
        if ($this->totalNum >= $this->randNum)
        {
            Cache::put($this->key, $this->articleQuery['query']['page'], $this->expiredAt);
            $this->line('今天文章已更新('.$this->totalNum.')篇');die();
        }
        $this->line('文章更新到('.$this->totalNum.')篇文章，总共（'.$this->randNum.'）篇');
        $this->line('执行第（'.$url.'?page='.$this->articleQuery['query']['page'].')页');
        Cache::put($this->key, $this->articleQuery['query']['page'], $this->expiredAt);
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
            ziyuan_array($urls);
        }
        if($array['links']['next'])
        {
            $this->articleQuery['query']['page']    = $this->articleQuery['query']['page'] + 1;
            $this->article($array['meta']['path']);
        } else {
            Cache::put($this->key, $this->articleQuery['query']['page'], $this->expiredAt);
            $this->line('文章数据已经更新完毕！');
        }
    }
    function saveArticle($array)
    {
        $this->totalNum +=1; //计数器
        $article = DB::table('articles')->where('title', $array['title'])->first();
        if($article)
        {
            DB::table('articles')->where('id', $article->id)->update([
                'column_id'         => $this->category($array['column_id']),
                'title'             => $array['title'],
                'seo_title'         => $array['seo_title'],
                'copy_from'         => $array['copy_from'],
                'keywords'          => $array['keywords'],
                'seo_keywords'      => $array['seo_keywords'],
                'image'             => $array['img'],
                'description'       => $array['description'],
                'seo_description'   => $array['seo_description'],
                'content'           => $array['content'],
                'seo_content'       => $array['seo_content'],
                'state'             => 1,
                'created_at'        => $array['created_at'],
                'updated_at'        => $array['updated_at'],
                'created_at'    => date('Y-m-d H:i:s',time()),
                'updated_at'    => date('Y-m-d H:i:s',time()),
            ]);
            return env('APP_URL').'/show/'.$article->id.'.html';
        } else {
            $id = DB::table('articles')->insertGetId([
                'column_id'         => $this->category($array['column_id']),
                'title'             => $array['title'],
                'seo_title'         => $array['seo_title'],
                'copy_from'         => $array['copy_from'],
                'keywords'          => $array['keywords'],
                'seo_keywords'      => $array['seo_keywords'],
                'image'             => $array['img'],
                'description'       => $array['description'],
                'seo_description'   => $array['seo_description'],
                'content'           => $array['content'],
                'seo_content'       => $array['seo_content'],
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
    
    public function getFollow($follow)
    {
        foreach ($follow as $v){
            yield $v;
        }
    }
}
