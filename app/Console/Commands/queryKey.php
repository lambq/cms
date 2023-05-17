<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class queryKey extends Command
{
    protected $keyarray;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queryKey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'queryKey';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->token        = 'Bearer BYHu0uS9lb094EbjvX8A80WTrmQaUMks5G3FEe4kEUTC0wDrQ3U3zLPvbuaepppe';
        $this->articleQuery = [
            'headers'   => [
                'Authorization' => $this->token,
            ],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $count  = DB::table('articles')->count();
        $num    = ceil($count/10);
        $this->line($num.'=='.$count);
        for($i=330;$i<=$num;$i++)
        {
            $articles   = DB::table('articles')->skip($i*10)->take(10)->get();
            foreach ($articles as $v)
            {
                $keywords       = $this->sendPost($v->title);
                $seo_keywords   = $this->sendPost($v->seo_title);
                DB::table('articles')->where('id', $v->id)->update([
                    'keywords'      => $keywords,
                    'seo_keywords'  => $seo_keywords,
                ]);
                $this->line($v->id);
            }
        }
    }
    
    public function sendPost($title)
    {
        $url        = 'http://121.62.21.105:801/api/v1/keyword?title='.$title;
        $client     = new Client();
        $response   = $client->request('GET', $url, $this->articleQuery);
        $code   = $response->getStatusCode();
        if ($code == 200)
        {
            return $this->keyword(json_decode($response->getBody(), true));
        } else {
            return false;
        }
    }
    
    function keyword($array)
    {
        if (!count($array))
        {
            return null;
        }
        
        $data   = [];
        foreach ($array as $v)
        {
            foreach ($array as $k)
            {
                if(!strpos($k, $v) !== false){ 
                    $data[] = $v;
                }
            }
        }
        return implode(',', $data);
    }
}