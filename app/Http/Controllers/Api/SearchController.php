<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    protected $art;
    protected $data;

    public function __construct(Article $art)
    {
        $this->art     = $art;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name   = $request->get('name');
        if (!$name)
        {
            return abort(404);
        }
        $count  = DB::table('articles')->count();
        $num    = ceil($count/10);
        $data['count']   = $count;
        $skip   = 0 * 10;
        $articles   = DB::table('articles')->select(['id', 'title', 'seo_title', 'image', 'description', 'seo_description', 'column_id', 'updated_at'])
            ->orWhere('title', 'like', "%$name%")
            ->orWhere('seo_title', 'like', "%$name%")
            ->where(['state'=>1])->orderBy('id', 'asc')->skip(0)->take(30)->get();
        if (!$articles)
        {
            return abort(404); 
        } else {
            $articles->map(function ($v) {
                //不在产生新查询
                $v->title          = $v->seo_title ? $v->seo_title : $v->title;
                $v->description    = $v->seo_description ? $v->seo_description : $v->description;
                return $v;
            });
            return response()->json($articles, 200);
        }
    }
}
