<?php

namespace App\Http\Controllers\Api;

use HtmlSerializer;
use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    protected $art;
    protected $data;
    protected $menu;
    protected $id;
    
    public function __construct(Article $art)
    {
        $this->art  = $art;
        $menu       = getMenu();
        foreach($menu as $v)
        {
            $this->menu[]   = [
                'title'     => $v->title,
                'imgSrc'    => 'https://b.bdstatic.com/searchbox/icms/searchbox/img/swan-demo-smt-grid.png'
            ];
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data   = [];
        $data['swiperList'] = article_pay();
        $data['top']        = $this->top();
        $data['news']       = $this->news();
        $data['menu']       = $this->menu;
        return response()->json($data, 200);
    }
    
    public function show($id)
    {
        if (!$id)
        {
            abort(404);
        }
        $this->id   = $id;
        $key        = 'show_id_'.$id;
        $this->art->where('id', $id)->where('state', 1)->increment('views');
        if (Cache::has($key))
        {
            $res        = Cache::get($key);
            $article    = $res['article'];
            $column     = $res['column'];
            $prev       = $res['prev'];
            $next       = $res['next'];
            $title      = $res['title'];
            $keywords   = $res['keywords'];
            $description= $res['description'];
            $content    = $res['content'];
        } else {
            $article    = $this->art->where('id', $id)->where('state', 1)->first();
            if (!$article)
            {
                return abort(404);
            }
            $column     = getMenuId($article->column_id);
            
            
            $prev = $this->getPrevArticleId($id, $article->column_id);
            $next = $this->getNextArticleId($id, $article->column_id);
            
            $title          = $article->seo_title ? $article->seo_title : $article->title;
            $keywords       = $article->seo_keywords ? $article->seo_keywords : $article->keywords;
            $description    = $article->seo_description ? $article->seo_description : $article->description;
            $content        = $article->seo_content ? $article->seo_content : $article->content;
            $expiredAt = now()->addHours(3);
            Cache::put($key, [
                'article'       => $article,
                'column'        => $column,
                'prev'          => $prev,
                'next'          => $next,
                'title'         => $title,
                'keywords'      => $keywords,
                'description'   => $description,
                'content'       => $content,
            ], $expiredAt);
            ziyuan($id);
        }
        $array      = $article->toArray();
        if ($array['extend'])
        {
            $array['title']         = $title;
            $array['keywords']      = $keywords;
            $array['description']   = $description;
            $array['extend']        = json_decode($array['extend'], true);
            return response()->json($array, 200);
        } else {
            $array['title']         = $title;
            $array['keywords']      = $keywords;
            $array['description']   = $description;
            $array['extend']        = $this->html($content, $id);
            return response()->json($array, 200);
        }
    }
    
    function html($content, $id)
    {
        $html       = new HtmlSerializer\Html($content);
        $this->arrayListMap($html->toArray(), '');
        DB::table('articles')->where('id', $id)->update([
            'extend' => json_encode($this->data),
        ]);
        return $this->data;
    }
    
    function top()
    {
        $articles   = article_top();
        $articles->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? str_limit($v->seo_title, 10) : str_limit($v->title, 10);
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        return $articles;
    }
    
    function news()
    {
        $articles   = article_news();
        $articles->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? str_limit($v->seo_title, 10) : str_limit($v->title, 10);
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        return $articles;
    }
    
    /**
     * 上一篇
     */
    protected function getPrevArticleId($id, $cate_id){
        $aid = $this->art->where('id', '<', $id)->where('state',1)->where('column_id',$cate_id)->max('id');
        return $this->art->where('id','=',$aid)->first();
    }
    /**
     * 下一篇
     */
    protected function getNextArticleId($id,$cate_id) {
        $aid = $this->art->where('id', '>', $id)->where('state',1)->where('column_id',$cate_id)->min('id');
        return $this->art->where('id','=',$aid)->first();
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
            Log::info('switchDefault==text==art==='.$this->id);
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
    
    
}
