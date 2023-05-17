<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class DigSiteTxt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature    = 'dig:sitetxt';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description  = 'dig:sitetxt';
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
        $pages      = 40000;
	    $count  = DB::table('articles')->count();
	    $num    = ceil($count/$pages);
	    $this->line('articles=='.$num.'=='.$count);
	    
	    for($i=0; $i<$num; $i++)
        {
            $list   = DB::table('articles')->select('id')->where('state', 1)->orderBy('id', 'asc')->skip($i*$pages)->take($pages)->get();
    		$this->view($list,$i);
    		$this->line($i.'==articles');
        }    
    }
    
    function view($str,$num)
    {
        $array = '';
        foreach ($str as $v)
        {
            $array .= 'https://www.3cc0.com/show/'.$v->id.'.html'."\r\n";
        }
        Storage::disk('view')->put('views/sitetxt/'.$num.'.txt', $array);
    }
}