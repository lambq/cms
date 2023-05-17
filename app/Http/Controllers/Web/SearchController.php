<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    //
    public function index($name)
    {
        $num          = mb_strlen($name);
        if ($num >= 11)
        {
            $str    = mb_substr($name, 0 , 10);
            return redirect('/search/'.$str);
        }
        if($name) {
            $article  = Article::select(['id', 'title', 'image', 'description', 'column_id', 'updated_at'])
            ->orWhere('title', 'like', "%$name%")
            ->orWhere('seo_title', 'like', "%$name%")
            ->where(['state'=>1])
            ->paginate(10);
            return view_name('search', compact('article', 'name'));
        } else {
            return abort(404);
        }
    
        
    }
}
