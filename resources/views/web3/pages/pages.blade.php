@extends(include_name('layouts.app'))

@section('title', $page->name.'-'.getSys('webname') )
@section('keywords', getSys('webname') )
@section('description', getSys('webname') )

@section('content')
    <div class="wrap" >
        <div class="main" style="width:100%;">
            <div class="article">
                <div class="map"><span> 当前位置：首页 > {{ $page->name }}</span> </div>
                <div class="title">
                    <h1> {{ $page->name }} </h1>
                </div>
                <div class="article_content"> {!! $page->content !!} </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
@endsection
