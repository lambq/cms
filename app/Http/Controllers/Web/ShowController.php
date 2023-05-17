<?php

namespace App\Http\Controllers\Web;

use HtmlSerializer;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{
    protected $art;
    protected $data;
    protected $id;
    
    public function __construct(Article $art)
    {
        $this->art     = $art;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        if (!$id)
        {
            return abort(404);
        }
        $this->id   = $id;
        $key    = 'show_id_'.$id;
        if (Cache::has($key))
        {
            $this->art->where('id', $id)->where('state', 1)->increment('views');
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
            $extend        = json_decode($array['extend'], true);
        } else {
            $extend        = $this->html($content, $id);
        }
        return view_name('article.show1', compact('column','article','prev','next','title','keywords','description','content','extend'));
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
    
    function html($content, $id)
    {
        $html       = new HtmlSerializer\Html($content);
        $this->arrayListMap($html->toArray(), '');
        $this->art->where('id', $id)->update([
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
