<?php
//路由路径
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

//图片路径
function hostStr($str)
{
    return env('IMG_URL_SHOT').$str;
}

// 判断是手机访问还是PC访问
function view_name($name, $array = [], $static = false)
{
    if ($static)
    {
        $key    = 'get_html_static_'.$name;
        $res    = Cache::get($key);
        if ($res)
        {
            return $res;
        } else {
            $expiredAt = now()->addMinutes(30);
            // 获取渲染后的视图内容
            $string = view('web3.'.$name, $array)->__toString();
            // 使用PHP内置方法 file_put_contents()生成静态页面
            Cache::put($key, $string, $expiredAt);
            return $string;
        }
    } else {
        return view('web3.'.$name, $array);
    }
}
// 切换模板
function include_name($name)
{
    return 'web3.'.$name;
}
// 获取第一张图片
function get_img_first($content)
{
    //App\Jobs\QiNiuJobs::dispatch();
    $pattern    = "/<[img|IMG].*?lay-src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern, $content, $matchContent);
    if(isset($matchContent[1][0])){
        $temp   = $matchContent[1][0];
    }else{
        $temp   = env('IMG_URL').'files/loading.gif';//在相应位置放置一张命名为no-image的jpg图片
    }
    return $temp;
}

// 字符串截取
function str_limit($text, $length)
{
    if(mb_strlen($text, 'UTF-8') > $length)
    {
        return mb_substr($text,0,$length,'UTF-8').'……';
    }
    return $text;
}
// 生成静态页面
function viewCreateIndex()
{
    $str    = view_name('welcome');
    Storage::disk('view')->put('views/index.html', $str);
    return true;
}
function viewCreateShow($id, $url, $str)
{
    Storage::disk('view')->put('views/'.$url, $str);
    return true;
}

// 计数达到30次访问数，自动更新首页
function indexRefresh()
{
    $key    = 'show_num';
    $res    = Cache::get($key);
    $expiredAt = now()->addMinutes(120);
    if ($res)
    {
        $num    = $res['num']+1;
        Cache::put($key, [
            'num'   => $num,
        ], $expiredAt);
        if ($num >= 30)
        {
            Cache::put($key, [
                'num'   => 0,
            ], $expiredAt);
            $str    = viewCreateIndex();
        }
    }   else {
        Cache::put($key, [
            'num'   => 0,
        ], $expiredAt);
    }
}
// 获取系统配置信息
function getSys($name)
{
    $key    = 'get_sys_'.$name;
    $res    = Cache::get($key);
    if ($res)
    {
        $str    = $res;
    } else {
        $syssetup    = DB::table('sys_setups')->where('id', 1)->select($name.' as webname')->first();
        $expiredAt = now()->addMinutes(120);
        Cache::put($key, $syssetup->webname);
        $str    = $syssetup->webname;
    }   
    
    return $str;
}

// 获取系统栏目
function getMenu()
{
    $key    = 'get_menu';
    $res    = Cache::get($key);
    if ($res)
    {
        $str    = $res;
    } else {
        $str    = DB::table('columns')->where('state', 1)->orderBy('order', 'desc')->get();
        $expiredAt = now()->addHours(3);
        Cache::put($key, $str);
    }   
    
    return $str;
}

function getMenuId($id)
{
    $key    = 'get_menu_'.$id;
    $res    = Cache::get($key);
    if ($res)
    {
        $str    = $res;
    } else {
        $str    = DB::table('columns')->where('state', 1)->where('id', $id)->first();
        $expiredAt = now()->addHours(3);
        Cache::put($key, $str);
    }   
    return $str;
}

// 24小时热文
function article_limit($id = 0)
{
    $key    = 'get_article_limit'.$id;
    $res    = Cache::get($key);
    if ($res)
    {
        return $res;
    } else {
        if ($id == 0)
        {
            $str   = DB::table('articles')->where('state', 1)->orderBy('views', 'desc')->take(20)->get();
        } else {
            $str   = DB::table('articles')->where('column_id', $id)->where('state', 1)->orderBy('views', 'desc')->take(20)->get();
        }
        
        if ($str)
        {
            $str->map(function ($v) {
                //不在产生新查询
                $v->title          = $v->seo_title ? $v->seo_title : $v->title;
                $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
                $v->description    = $v->seo_description ? $v->seo_description : $v->description;
                $v->content        = $v->seo_content ? $v->seo_content : $v->content;
                return $v;
            });
            $expiredAt = now()->addHours(3);
            Cache::put($key, $str, $expiredAt);
            return $str;
        } else {
            return null;
        }
        
    }
}

// 热门推荐
function article_views($id = 0)
{
    $key    = 'get_article_views'.$id;
    $res    = Cache::get($key);
    if ($res)
    {
        return $res;
    } else {
        if ($id == 0)
        {
            $str   = DB::table('articles')->where('state', 1)->orderBy('views', 'desc')->take(30)->get();
        } else {
            $str   = DB::table('articles')->where('column_id', $id)->where('state', 1)->orderBy('views', 'desc')->take(30)->get();
        }
        
        if ($str)
        {
            $str->map(function ($v) {
                //不在产生新查询
                $v->title          = $v->seo_title ? $v->seo_title : $v->title;
                $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
                $v->description    = $v->seo_description ? $v->seo_description : $v->description;
                $v->content        = $v->seo_content ? $v->seo_content : $v->content;
                return $v;
            });
            $expiredAt = now()->addHours(1);
            Cache::put($key, $str, $expiredAt);
            return $str;
        } else {
            return null;
        }
        
    }
}


// 获取最新发布文章
function article_news()
{
    $key    = 'get_article_news';
    $res    = Cache::get($key);
    if ($res)
    {
        return $res;
    } else {
        $str   = DB::table('articles')->where('state', 1)->orderBy('id', 'desc')->take(15)->get();
        $str->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? $v->seo_title : $v->title;
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        if ($str)
        {
            $expiredAt = now()->addHours(3);
            Cache::put($key, $str, $expiredAt);
            return $str;
        } else {
            return null;
        }
    }  
}

// 首页 推荐 推荐 15
function article_best()
{
    $articles   = DB::table('articles')->where([
        ['state', '=', '1'],
        ['is_best', '=', '1'],
    ])->orderBy('views', 'desc')->take(15)->get();
    if($articles){
        return $articles;
    }else{
        return null;
    }
}

// 首页 幻灯片 付费 10
function article_pay()
{
    
    $key    = 'get_article_pay';
    $res    = Cache::get($key);
    if ($res)
    {
        return $res;
    } else {
        $str   = DB::table('articles')->where([
            ['state', '=', '1'],
            ['is_pay', '=', '1'],
        ])->orderBy('views', 'desc')->take(10)->get();
        $str->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? $v->seo_title : $v->title;
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        if ($str)
        {
            $expiredAt = now()->addHours(3);
            Cache::put($key, $str, $expiredAt);
            return $str;
        } else {
            return null;
        }
        
    }   
    
}

// 首页 右侧 置顶+付费+推荐 2
function article_top()
{
    $key    = 'get_article_top';
    $res    = Cache::get($key);
    if ($res)
    {
        return $res;
    } else {
        $str   = DB::table('articles')->where([
            ['state', '=', '1'],
            ['is_top', '=', '1'],
        ])->orderBy('views', 'desc')->take(10)->get();
        $str->map(function ($v) {
            //不在产生新查询
            $v->title          = $v->seo_title ? $v->seo_title : $v->title;
            $v->keywords       = $v->seo_keywords ? $v->seo_keywords : $v->keywords;
            $v->description    = $v->seo_description ? $v->seo_description : $v->description;
            $v->content        = $v->seo_content ? $v->seo_content : $v->content;
            return $v;
        });
        if ($str)
        {
            $expiredAt = now()->addMinutes(3);
            Cache::put($key, $str, $expiredAt);
            return $str;
        } else {
            return null;
        }
        
    }   
}

// 文章栏目名称
function article_column($id)
{
    $column   = DB::table('columns')->where('id', $id)->first();
    if($column){
        $articles   = DB::table('articles')->where([
            ['state', '=', '1'],
            ['column_id', '=', $id]
        ])->orderBy('id', 'desc')->skip(2)->take(8)->get();
        $list       = DB::table('articles')->where([
            ['state', '=', '1'],
            ['column_id', '=', $id]
        ])->orderBy('id', 'desc')->skip(0)->take(2)->get();
        return [
            'column'    => $column,
            'articles'  => $articles,
            'list'      => $list,
        ];
    }else{
        return env('APP_NAME');
    }
}

// 获取文章栏目名称
function article_column_name($id)
{
    $articles   = DB::table('columns')->where('id', $id)->first();
    if($articles){
        return $articles->title;
    }else{
        return env('APP_NAME');
    }
}

// 获取文章栏目链接url
function article_column_url($id)
{
    $articles   = DB::table('columns')->where('id', $id)->first();
    if($articles){
        return $articles->name;
    }else{
        return env('APP_NAME');
    }
}

// 获取热门关键词
function tag_hot()
{
    $tags   = DB::table('tags')->orderBy('views', 'desc')->take(8)->get();
    if($tags){
        return $tags;
    }else{
        return false;
    }
}

// 获取当月热门关键词
function tag_hot_month()
{
    $month_last = date('Y-m-d', strtotime("-1 month"));
    $tags   = DB::table('tags')->whereDate('created_at', '>',$month_last)->orderBy('views', 'desc')->take(8)->get();
    if($tags){
        return $tags;
    }else{
        return false;
    }
}

function links()
{
    $key    = 'get_links';
    $res    = Cache::get($key);
    if ($res)
    {
        return $res;
    } else {
        $str   = DB::table('links')->where('state', 1)->get();
        if ($str)
        {
            $expiredAt = now()->addHours(1);
            Cache::put($key, $str, $expiredAt);
            return $str;
        } else {
            return null;
        }
        
    }
}

// 首页 幻灯片 付费 10
function article_access()
{
    $key    = 'get_push_baidu';
    $res    = Cache::get($key);
    if ($res)
    {
        return $res;
    } else {
        $articles   = DB::table('articles')->where([
        ['state', '=', '1'],
        ])->orderBy('updated_at', 'desc')->take(30)->get();
        if($articles){
            
            foreach ($articles as $v) {
                // code...
                ziyuan($v->id);
            }
            $expiredAt = now()->addMinutes(5);
            Cache::put($key, $articles, $expiredAt);
            return $articles;
        }else{
            return null;
        }
    }
    
}

// url 分页数
function page_current($name)
{
    $url    = $_SERVER['REQUEST_URI'];
    if ($name == 'search')
    {
        if (strpos($url, 'page'))
        {
            $array = explode('/', $url);
            return $array[4];
        } else {
            return 0;
        }
    }
    
    if ($name == 'top')
    {
        if (strpos($url, 'page'))
        {
            $array = explode('/', $url);
            return $array[3];
        } else {
            return 0;
        }
    }
    
}

// 获取文章里面第一张图片
function get_img_first_src($content)
{
    //App\Jobs\QiNiuJobs::dispatch();
    $pattern    = "/<[img|IMG].*?lay-src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.jpeg]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern, $content, $matchContent);
    if(isset($matchContent[1][0])){
        $temp   = $matchContent[1][0];
    }else{
        $temp   = hostStr('files/loading.gif');//在相应位置放置一张命名为no-image的jpg图片
    }
    return $temp;
}

function getImgs($content, $order='ALL')
{
    $pattern ="/<img .*?lay-src=[\'|\"](.*?(?:[\.jpg|\.png|\.jpeg]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern,$content,$match);
    if(isset($match[1])&&!empty($match[1])){
        if($order==='ALL'){
            return $match[1];
        }
        if(is_numeric($order)&& isset($match[1][$order])){
            return $match[1][$order];
        }
    }
    return [];
}
function ziyuan($id)
{
    $urls = array(
        'https://www.3cc0.com/show/'.$id.'.html',
    );
    $api = 'http://data.zz.baidu.com/urls?site=https://www.3cc0.com&token=N5rV5a2PKadmuyc1';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $urls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}

function ziyuan_array($urls)
{
    $api = 'http://data.zz.baidu.com/urls?site=https://www.3cc0.com&token=N5rV5a2PKadmuyc1';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $urls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}