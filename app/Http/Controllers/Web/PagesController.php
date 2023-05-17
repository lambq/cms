<?php

namespace App\Http\Controllers\Web;

use App\Models\Article;
use App\Models\Links;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    protected $art;
    protected $links;
    
    public function __construct(Article $art, Links $links)
    {
        $this->art      = $art;
        $this->links    = $links;
    }
    
    public function pages($name)
    {
        $page       = Page::where('title', $name)->first();
        $url        = 'pages.'.$name;
        return view_name('pages.pages', compact('page'));
    }

    public function root()
    {
        $pay   = $this->art->where([
            ['state', '=', '1'],
            ['is_pay', '=', '1'],
        ])->orderBy('views', 'desc')->take(10)->get();
        
        $top   = $this->art->where([
            ['state', '=', '1'],
            ['is_top', '=', '1'],
        ])->orderBy('views', 'desc')->take(10)->get();

        $news   = $this->art->where('state', 1)->orderBy('id', 'desc')->take(15)->get();
        
        $links   = $this->links->where('state', 1)->get();
        
        $access   = $this->art->where([
        ['state', '=', '1'],
        ])->orderBy('updated_at', 'desc')->take(30)->get();
        
        return view_name('welcome', compact('pay', 'top', 'news', 'links', 'access'));
        
    }

}
