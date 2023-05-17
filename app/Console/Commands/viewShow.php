<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class viewShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $site;
    protected $menu;
    protected $signature = 'viewShow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'viewShow index|menu|list|top|update all|last --id=1';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->site     = 'http://www.3cc0.com/index.php/';
        $this->menu     = getMenu();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = base_path();
        echo $path;
    }
    
    public function index()
    {
        $str    = $this->stre($this->site);
        Storage::disk('view')->put('index.html', $str);
        $this->line('生成首页成功！');
    }
    
    public function menu()
    {
        foreach ($this->menu as $v)
        {
            $str    = $this->stre($this->site.'/'.$v->name);
            Storage::disk('view')->put($v->name.'/index.html', $str);
            $this->line($v->name.'栏目首页成功！');
        }
        
        $str    = $this->stre($this->site.'top');
        Storage::disk('view')->put('top/index.html', $str);
        $this->line('top栏目首页成功！');
        
        $str    = $this->stre($this->site.'update');
        Storage::disk('view')->put('update/index.html', $str);
        $this->line('update栏目首页成功！');
    }
    
    public function top()
    {
        $name       = 'top';
        $articles   = Article::where('state', 1)->orderBy('views', 'desc')->paginate(10)->toArray();
        $num        = $articles['last_page'];
        for($i=2;$i<=$num;$i++)
        {
            $str    = $this->stre($this->site.'/'.$name.'/page/'.$i);
            Storage::disk('view')->put($name.'/page/'.$i.'.html', $str);
            $this->line($name.'===栏目==='.$i.'页成功！');
        }
    }
    
    public function update()
    {
        $name       = 'update';
        $articles   = Article::where('state', 1)->orderBy('views', 'desc')->paginate(10)->toArray();
        $num        = $articles['last_page'];
        for($i=2;$i<=$num;$i++)
        {
            $str    = $this->stre($this->site.'/'.$name.'/page/'.$i);
            Storage::disk('view')->put($name.'/page/'.$i.'.html', $str);
            $this->line($name.'===栏目==='.$i.'页成功！');
        }
    }
    
    function list()
    {
        $ids            = $this->option('id');
        if (array_key_exists('0', $ids))
        {
            $class   = $this->argument('class');
            if ($class == 'last')
            {
                $this->store($ids[0]);
            } else {
                $this->create($ids[0], 'one');
            }
        } else {
            $json           = json_decode($this->menu->toJson(), true);
            $this->table(['id', 'parent_id', 'title', 'name', 'keywords', 'description', 'order', 'state'], $json);
            $id     = $this->ask('请输入需要生成的栏目ID');
            if ($id)
            {
                $this->create($id, 'zero');
            } else {
                $this->error('为什么不选择？');
            }
        }
    }
    
    public function store($id)
    {
        $this->line($id.'===栏目===已经选择！');
        $menu       = getMenuId($id);
        $articles   = Article::where('column_id', $menu->id)->where('state', 1)->orderBy('id', 'desc')->paginate(10)->toArray();
        $num        = $articles['last_page'];
        $this->line('此栏目===总计（'.$num.')页倒数检测');
        for($i=$num;$i>=2;$i--)
        {
            $exists = Storage::disk('view')->exists($menu->name.'/page/'.$i.'.html');
            if ($exists)
            {
                return true;
            } else {
                $str    = $this->stre($this->site.'/'.$menu->name.'/page/'.$i);
                Storage::disk('view')->put($menu->name.'/page/'.$i.'.html', $str);
                $this->line($menu->name.'===栏目==='.$i.'页成功！');
            }
        }
    }
    
    function create($id, $class)
    {
        $this->line($id.'===栏目===已经选择！');
        $menu       = getMenuId($id);
        $articles   = Article::where('column_id', $menu->id)->where('state', 1)->orderBy('id', 'desc')->paginate(10)->toArray();
        $num        = $articles['last_page'];
        $this->line('此栏目===总计（'.$num.')页');
        for($i=2;$i<=$num;$i++)
        {
            $str    = $this->stre($this->site.'/'.$menu->name.'/page/'.$i);
            Storage::disk('view')->put($menu->name.'/page/'.$i.'.html', $str);
            $this->line($menu->name.'===栏目==='.$i.'页成功！');
        }
    }
    
    function stre($url)
    {
        $str    = $this->check($url);
        $str  = str_replace('index.php/', '', $str);
        $str  = str_replace('/index.php', '', $str);
        return $str;
    }
    //抓取网址
    function check($url){
        
        $client = new Client();

        try {
            $res = $client->request('GET', $url);
            if ($res->getstatuscode() == 200)
            {
                $body = $res->getBody();
                $content = $body->getContents();
                return $content;
            } else {
                return false;
            }
        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }
}
