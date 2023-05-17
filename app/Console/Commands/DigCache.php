<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class DigCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature    = 'dig:cache {action}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description  = '清理缓存';
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
        if ($action == 'art') 
        {
            $this->art();
        }
        if ($action == 'tags') 
        {
            $this->tags();
        }
        if ($action == 'cache') 
        {
            $this->cache();
        }
        if ($action == 'down') 
        {
            $this->down();
        }
    }
    
    function art()
    {
        $count  = DB::table('articles')->count();
        $num    = ceil($count/100);
        $this->line($num.'=='.$count);
        for($i=0;$i<$num;$i++)
        {
            $articles   = DB::table('articles')->select('id')->skip($i*100)->take(100)->get();
            foreach ($articles as $v)
            {
                $key    = 'show_id_'.$v->id;
                if (Cache::has($key)) {
                    Cache::forget($key);
                }
                $this->line($v->id);
            }
        }
    }
}