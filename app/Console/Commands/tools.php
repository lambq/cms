<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;


class tools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'tools imgs|tags|cache';

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
        $action = $this->argument('action');
        if ($action == 'imgs') 
        {
            $this->imgs();
        }
        if ($action == 'tags') 
        {
            $this->tags();
        }
        if ($action == 'cache') 
        {
            $this->cache();
        }
        if ($action == 'keyword') 
        {
            $this->keyword();
        }
    }
    
    public function keyword()
    {
        $articles   = DB::table('articles')->where('seo_keywords', '=', '')->get();
        foreach ($articles as $v)
        {
            $res            = $this->sendPost($v->title);
            $seo_keywords   = $res['keyword'];
            
            // $image	    = get_img_first_src($v->content);
            DB::table('articles')->where('id', $v->id)->update([
                'seo_keywords'  => $seo_keywords,
            ]);
            ziyuan($v->id);
            $this->line($v->id);
        }
    }
    public function cache()
    {
        $key    = 'show_id_*';
        $res    = Cache::get($key);
        foreach($res as $v)
        {
            print_r($v);
        }
        
    }
    
    public function imgs()
    {

        $articles   = DB::table('articles')->where('users_id', 11)->get();
        foreach ($articles as $v)
        {
            $image	    = get_img_first_src($v->content);
            DB::table('articles')->where('id', $v->id)->update([
                'image'     => $image
            ]);
            ziyuan($v->id);
            $this->line($v->id);
        }
    }
    
    public function tags()
    {
        $art = DB::table('articles')->where('id', '>=', '35956')->get();
        foreach ($art as $v)
        {
            
            $str    = str_replace('\\"', '"', $v->content);
            DB::table('articles')->where('id', $v->id)->update([
                'content'     => $str
            ]);
            $this->line($v->id);
            
        }
        // $count  = DB::table('articles')->count();
        // $num    = ceil($count/100);
        // $this->line($num.'=='.$count);
        // for($i=0;$i<$num;$i++)
        // {
        //     $art = DB::table('articles')->skip($i*100)->take(100)->get();
        //     foreach ($art as $v)
        //     {
        //         $this->normalizeTag(explode(',', $v->keywords));
        //         $this->line($v->id);
        //     }
        //     $this->line($i);
        // }
    }

    public function normalizeTag(array $tags)
    {
        return collect($tags)->map(function ($tag) {
            $newTag   = DB::table('tags')->where('name', $tag)->first();
            if($newTag) {
                return $newTag->id;
            }else {
                DB::table('tags')->insert([
                    'name'          => $tag,
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ]);
                return true;
            }
        })->toArray();
    }
    
    public function sendPost($title)
    {
        $array = [
            'headers'   => [
                'Authorization' => 'Bearer BYHu0uS9lb094EbjvX8A80WTrmQaUMks5G3FEe4kEUTC0wDrQ3U3zLPvbuaepppe',
            ],
            'query'     => [
                'title'  => $title,
            ]
        ];
        $client     = new Client();
        $response   = $client->request('GET', 'http://121.62.21.105:801/api/v1/keyword', $array);
        $code   = $response->getStatusCode();
        if ($code == 200)
        {
            return json_decode($response->getBody(), true);
        } else {
            return false;
        }
    }
}
