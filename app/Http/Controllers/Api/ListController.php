<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;

class ListController extends Controller
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
        $array  = [];
        $id     = $request->get('id') ? (int)$request->get('id'): 1;
        $page   = $request->get('page') ? (int)$request->get('page') : 1;
        $count  = DB::table('articles')->where('column_id', $id)->where('state', 1)->count();
        $num    = ceil($count/10);
        $articles   = $this->art->where('column_id', $id)->where('state', 1)->orderBy('id', 'desc')->skip($page*10)->take(10)->get();
        $articles->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? $v->seo_title : $v->title;
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        $array['total']     = $count;
        $array['page']      = 10;
        $array['columnId']  = $id;
        
        foreach ($articles as $v)
        {
            $img    = getImgs($v->content);
            $num    = count($img);
                
            switch ($num) {
                case 0:
                    
                    $array['data'][]    = [
                        'id'        => $v->id,
                        'theme'     => 'default',
                        'content'   => [
                            'title'         => $v->title,
                            'infoSource'    => '唯美资讯',
                            'commentsNum'   => $v->views,
                        ]
                    ];
                    break;
                case 1:
                    
                    $array['data'][]    = [
                        'id'        => $v->id,
                        'theme'     => 'default',
                        'content'   => [
                            'title'         => $v->title,
                            'infoSource'    => '唯美资讯',
                            'commentsNum'   => $v->views,
                            'images'        => $img
                        ]
                    ];
                    break;
                case 2:
                    
                    $array['data'][]    = [
                        'id'        => $v->id,
                        'theme'     => 'large-image',
                        'content'   => [
                            
                            'title'         => $v->title,
                            'infoSource'    => '唯美资讯',
                            'commentsNum'   => $v->views,
                            'images'        => $img
                        ]
                    ];
                    
                    break;
                default:
                    $array['data'][]    = [
                        'id'        => $v->id,
                        'theme'     => 'multiple-images',
                        'content'   => [
                            'title'         => $v->title,
                            'infoSource'    => '唯美资讯',
                            'commentsNum'   => $v->views,
                            'images'        => array_slice($img, 0, 4)
                        ]
                    ];
            }
        }
        return response()->json($array, 200);
    }
}
