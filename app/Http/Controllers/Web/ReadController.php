<?php

namespace App\Http\Controllers\Web;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Article $article)
    {
        $user       = $request->get('user');
        if ($user)
        {
            $articles   = $article->where('users_id', '=', $user)->get();
        } else {
            $articles   = $article->where('users_id', '!=', $user)->get();
        }
        
        foreach ($articles as $v)
        {
            echo 'https://www.29cz.com/show/'.$v->id.'.html<br/>';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = DB::table('articles')->where('title', $request->get('title'))->first();
        if($article)
        {
            echo '文章已经存在';die();
        } else {
            $id = DB::table('articles')->insertGetId([
                'users_id'          => 13,
                'column_id'         => 5,
                'title'             => $request->get('title'),
                'copy_from'         => '网络采集',
                'keywords'          => $request->get('keywords'),
                'image'             => get_img_first_src($request->get('content')),
                'description'       => $request->get('description'),
                'content'           => $request->get('content'),
                'views'             => 5000,
                'state'             => 1,
                'created_at'    => date('Y-m-d H:i:s',time()),
                'updated_at'    => date('Y-m-d H:i:s',time()),
            ]);
            if($id){
                $urls   = 'https://www.29cz.com/show/'.$id.'.html';
                $this->ziyuan($id);
                echo '文章发布成功,链接为：'.$urls;die();
            }else{
                echo '文章发布失败！';die();
            }   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    function ziyuan($id)
    {
        $urls = array(
            env('APP_URL').'/show/'.$id.'.html',
        );
        $api = env('BAIDUZHANZHANG');
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
}
