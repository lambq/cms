<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticlesController extends Controller
{
    protected $art;
    
    public function __construct(Article $art)
    {
        $this->art     = $art;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function map1()
    {
        $articles   = $this->art->where('users_id', 2)->get();
        foreach ($articles as $v)
        {
            echo $v->title.'===https://82rn.com/show/'.$v->id.'.html<br/>';
        }
    }
    
    public function map($id)
    {
        $articles   = $this->art->where('users_id', $id)->get();
        foreach ($articles as $v)
        {
            echo '82rn.com/show/'.$v->id.'.html<br/>';
        }
    }
    
    public function top()
    {

        $articles   = $this->art->where('state', 1)->orderBy('views', 'desc')->paginate(10);
        $articles->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? $v->seo_title : $v->title;
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        // 获取渲染后的视图内容
        // 使用PHP内置方法 file_put_contents()生成静态页面
        return view_name('article.top', compact('articles'));
        
    }
    
    public function update()
    {
        $articles   = $this->art->where('state', 1)->orderBy('id', 'desc')->paginate(10);
        $articles->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? $v->seo_title : $v->title;
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        return view_name('article.update', compact('articles'));
    }
    
    public function list()
    {
        $col        = route_class();
        $column     = Column::where('name', $col)->first();
        $articles   = $this->art->where('column_id', $column->id)->where('state', 1)->orderBy('id', 'desc')->paginate(10);
        $articles->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? $v->seo_title : $v->title;
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        return view_name('article.list', compact('column','articles'));
    }

    public function show($id)
    {
        if (!$id)
        {
            return abort(404);
        }
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
        // ziyuan($id);
        // indexRefresh();
        return view_name('article.show', compact('column','article','prev','next','title','keywords','description','content'));
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
}
