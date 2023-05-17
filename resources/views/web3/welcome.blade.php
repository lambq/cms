@extends(include_name('layouts.app'))

@section('title', getSys('webname') )
@section('keywords', getSys('keywords') )
@section('description', getSys('description') )

@section('content')
    <div class="blank"></div>

    <div class="inner container">
        <main class="main">
            <div class="focus wow fadeIn">
                <div class="flexslider">
                    <ul class="slides">
                        @foreach($pay as $v)
                            <li>
                                <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}">
                                    <img src="{{ $v->image }}" alt="{{ $v->title }}"/>
                                    <p class="flex-caption"> {{ $v->title }} </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <section class="top wow fadeIn">
                <h3>头条推荐</h3>
                <ul>
                    @foreach($top as $v)
                        <li>
                            <h4><a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}"> {{ $v->title }} </a></h4>
                            <p>{{ str_limit($v->description, 200) }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
            <div class="clear"></div>
            <div class="mainad wow fadeIn"> </div>
            <div class="content">
                <div class="section-title">
                    <h3>动态资讯</h3>
                </div>
                @foreach($news as $v)

                    <section class="section wow fadeIn">
                        <div class="thumbnail">
                            <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">
                                <img class="load" src="https://img.622n.com/files/loading.gif" lay-src="{{ $v->image }}" alt="{{ $v->title }}"/>
                            </a>
                        </div>
                        <h2>
                            <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">{{ $v->title }}</a>
                        </h2>
                        <div class="postmeta">
                            <span>
                                <i class="icon-calendar"></i>
                                <time>{{ $v->updated_at }}</time>
                            </span>
                            <span><i class="icon-eye"></i> {{ $v->views }}</span>
                        </div>
                        <div class="excerpt">
                            <p> {{ str_limit($v->description, 200) }} </p>
                        </div>
                    </section>

                @endforeach
            </div>
        </main>
        <aside class="sidebar">
            <section class="widget wow fadeInUp">
                <div class="section-title">
                    <h3>热门文章</h3>
                </div>
                <ul>
                    @foreach(article_limit() as $k => $v)
                        <li>
                            <i class="a{{ $k+1 }}">{{ $k+1 }}</i>
                            <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">{{ $v->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </section>
            <section class="widget wow fadeInUp">
                <div class="section-title">
                    <h3>文章访问</h3>
                </div>
                <ul>
                    @foreach($access as $k => $v)
                        <li>
                            <i class="a{{ $k+1 }}">{{ $k+1 }}</i>
                            <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">{{ $v->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </section>
        </aside>
    </div>

    <div class="inner friendlinks wow fadeIn">
        <div class="section-title"> 友情链接<span>申请要求：同属互联网资讯类网站，并内容充实，无作弊现象。</span> </div>
        <ul>
            @foreach($links as $v)
                <li>
                    <a href="{{ $v->url }}" title="{{ $v->name }}" target="_blank">
                        {{ $v->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="fixed-widget">
        <ul>
            <li><i class="icon-up-open"></i></li>
        </ul>
    </div>
@endsection

@section('script')
    <script>prettyPrint();</script>
@endsection
