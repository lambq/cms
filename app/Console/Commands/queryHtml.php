<?php

namespace App\Console\Commands;

use HtmlSerializer;
use App\Jobs\DigImg;
use Carbon\Carbon;
use QL\QueryList;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class queryHtml extends Command
{
    protected $keyarray;
    protected $data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queryHtml {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'queryHtml';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->keyarray = [
                '本文约',
                '文章内容',
                '相关阅读',
                '《》',
                '相干浏览',
                '面击拜访',
                '七君',
                '文去自',
                '参考材料',
                '大家皆是产物司理',
                '扫码',
                'Reference',
                'https',
                'http',
                '本文链接',
                '本文题目',
                '本题目',
                '参考文献',
                '常识星球截图',
                '编纂',
                '滥觞大众号',
                '本文由',
                '大众号',
                '本文本',
                '来源公众号',
                '文章出处',
                '参考链接',
                '本文来自'
            ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        
        
        if ($action == 'list') 
        {
            $this->list();
        }
        if ($action == 'show') 
        {
            $this->show();
        }
        
    }
    
    function list()
    {
        $count  = DB::table('articles')->count();
        $num    = ceil($count/100);
        $this->line($num.'=='.$count);
        for($i=0;$i<$num;$i++)
        {
            $articles   = DB::table('articles')->skip($i*100)->take(100)->get();
            foreach ($articles as $v)
            {
                $str        = $this->html($v->seo_content);
                DB::table('articles')->where('id', $v->id)->update([
                    'seo_content'   => $str,
                    'extend'        => null,
                ]);
                $this->line($v->id);
            }
        }
    }
    
    function show()
    {
        $id         = 27092;
        $article = DB::table('articles')->where('id', $id)->first();
        $this->toArray($article->seo_content, $id);
    }
    function toArray($content, $id)
    {
        $html       = new HtmlSerializer\Html($content);
        print_r($html->toArray());die();
        $this->arrayListMap($html->toArray(), '');
        print_r($this->data);die();
        DB::table('articles')->where('id', $id)->update([
            'extend' => json_encode($this->data),
        ]);
        return $this->data;
    }
    
    public function arrayListMap($array, $str)
    {
        foreach ($array as $v) 
        {
            if(array_key_exists('children', $v))
            {
                $this->arrayListMap($v['children'], $v['node']);
            } else {
                $v['name']      = $str ? $str : 'img';
                // $this->data[]   = $v;
                $this->arrayListMate($v);
            }
        }
    }
    public function arrayListMate($v)
    {
        // $this->data[]   = $v;
        switch ($v['name']) {
            case 'blockquote':
                $this->quote($v);
                break;
            case 'img':
                $this->img($v);
                break;
            case 'p':
                $this->p($v);
                break;
            case 'h1':
                $this->h($v);
                break;
            case 'h2':
                $this->h($v);
                break;
            case 'h3':
                $this->h($v);
                break;
            case 'h4':
                $this->h($v);
                break;
            case 'h5':
                $this->h($v);
                break;
            case 'li':
                $this->li($v);
                break;
            default:
                $this->switchDefault($v);
                break;
        }
    }
    public function arrayListMake($v)
    {
        switch ($v['node']) {
            case 'blockquote':
                if (array_key_exists('text', $v))
                {
                    $str    = $this->trimall($v['text']);
                    if ($str)
                    {
                        $this->data[] = [
                            'type'      => 'quote',
                            'content'   => $v['text']
                        ];
                    }
                }
                break;
            case 'img':
                if (array_key_exists('attributes', $v))
                {
                    if (array_key_exists('lay-src', $v['attributes']))
                    {
                        $this->data[] = [
                            'type'      => 'img',
                            'content'   => $v['attributes']['lay-src']
                        ];
                    } else {
                        $this->info('img==lay-src==');die();
                    }
                }
                break;
            case 'p':
                if (array_key_exists('text', $v))
                {
                    $str    = $this->trimall($v['text']);
                    if ($str)
                    {
                        $this->data[] = [
                            'type'      => 'p',
                            'content'   => $v['text'],
                        ];
                    }
                }
                break;
            default:
                // $this->switchDefault($v);
                break;
        }
    }
    function li($v)
    {
        if (array_key_exists('text', $v))
        {
            $str    = $this->trimall($v['text']);
            if ($str)
            {
                $this->data[] = [
                    'type'      => 'p',
                    'content'   => $v['text'],
                ];
            }
        } else {
            $this->arrayListMake($v);
        }
    }
    function quote($v)
    {
        if (array_key_exists('text', $v))
        {
            $str    = $this->trimall($v['text']);
            if ($str)
            {
                $this->data[] = [
                    'type'      => 'quote',
                    'content'   => $v['text']
                ];
            }
        } else {
            $this->arrayListMake($v);
        }
    }
    function img($v)
    {
        if (array_key_exists('attributes', $v))
        {
            if (array_key_exists('lay-src', $v['attributes']))
            {
                $this->data[] = [
                    'type'      => 'img',
                    'content'   => $v['attributes']['lay-src']
                ];
            }
        } else {
            $this->arrayListMake($v);
        }
    }
    function p($v)
    {
        if (array_key_exists('text', $v))
        {
            $str    = $this->trimall($v['text']);
            if ($str)
            {
                $this->data[] = [
                    'type'      => 'p',
                    'content'   => $v['text'],
                ];
            }
        } else {
            $this->arrayListMake($v);
        }
    }
    function h($v)
    {
        if (array_key_exists('text', $v))
        {
            $str    = $this->trimall($v['text']);
            if ($str)
            {
                $this->data[] = [
                    'type'      => 'title',
                    'content'   => $v['text']
                ];
            }
        } else {
            $this->arrayListMake($v);
        }
    }
    function switchDefault($v)
    {
        if (array_key_exists('text', $v))
        {
            $str    = $this->trimall($v['text']);
            if ($str)
            {
                $this->data[] = [
                    'type'      => 'p',
                    'content'   => $v['text']
                ];
            }
        } else {
            Log::info('switchDefault==text==');
            return false;
        }
    }
    function trimall($str)//删除空格
    {
        $num    = mb_strlen($str);
        if ($num > 2)
        {
            return true;
        } else {
            return false;
        }
    }
    
    public function html($content)
    {
        $content = QueryList::html($content);
        $content->find('iframe')->remove();
        $content->find('h3')->map(function($p){
            $text   = $p->text();
            foreach ($this->keyarray as $v)
            {
                if(strpos($text, $v) !== false){ 
                    $p->remove();
                }
            }
        });
        $content->find('ul')->map(function($p){
            $text   = $p->text();
            foreach ($this->keyarray as $v)
            {
                if(strpos($text, $v) !== false){ 
                    $p->remove();
                }
            }
        });
        $content->find('p')->map(function($p){
            $text   = $p->text();
            foreach ($this->keyarray as $v)
            {
                if(strpos($text, $v) !== false){ 
                    $p->remove();
                }
            }
        });
        $content->find('img')->map(function($img){
		    $img->removeAttr('w');
		    $img->removeAttr('h');
		    $img->removeAttr('width');
		    $img->removeAttr('height');
		    $img->removeAttr('alt');
		    $img->removeAttr('srcset');
		    $img->removeAttr('class');
            $img->removeAttr('style');
            $img->removeAttr('border');
            $img->removeAttr('vspace');
            $img->removeAttr('title');
            $img->removeAttr('imgwidth');
            $img->removeAttr('imgheight');
            $img->removeAttr('_src');
		    $img->removeAttr('data-w');
		    $img->removeAttr('data-h');
            $img->removeAttr('style');
            $img->removeAttr('data-original');
            $img->removeAttr('w');
            $img->removeAttr('h');
            $img->attr('class', 'load');
        });
        $content->find('button')->map(function($p){
            $p->remove();
        });
        $content->find('li')->map(function($p){
            $p->remove();
        });
        $content->find('ul')->map(function($p){
            $p->remove();
        });
        $content->find('donate-button')->map(function($p){
            $p->remove();
        });
        return $content->find('')->html();
    }
}