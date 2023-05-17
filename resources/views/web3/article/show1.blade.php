@extends(include_name('layouts.app'))

@section('title', $title.getSys('webname'))
@section('keywords', $keywords.getSys('keywords') )
@section('description', $description.getSys('description') )

@section('content')
    <div class="blank"></div>
    <div class="inner container">
        <main class="main">
            <div class="content">
                <div class="breadcrumb">
                    <span> 当前位置：<a href="{{ url('/') }}">首页</a> &gt; <a href="{{ url($column->name) }}">{{ $column->title }}</a> <em class="st">&gt;</em> 正文 </span>
                </div>
                <article class="post">
                    <h1 class="post-title">
                        {{ $title }}
                    </h1>
                    <div class="postmeta">
                        <span>
                            <i class="icon-calendar"></i>
                            <time>{{ $article->updated_at }}</time>
                        </span>
                        <span>
                            <i class="icon-eye"></i>
                            {{ $article->views }}
                        </span>
                    </div>

                    <div class="entry">
                        @if($extend)
                            @foreach($extend as $v)
                                @if ($v['type'] == 'p')
                                    <p>{{ $v['content'] }}</p>
                                @endif
                                
                                @if ($v['type'] == 'img')
                                    <img src="https://img.622n.com/files/loading.gif" lay-src="{{ $v['content'] }}" class="load" style="display: inline;">
                                @endif
                                
                                @if ($v['type'] == 'title')
                                    <h3>{{ $v['content'] }}</h3>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="tags">
                        <i class="icon-tags"></i>
                        @foreach(explode(',',$keywords) as $v)
                            <a href="{{ url('search') }}/{{ $v }}" title="{{ $v }}" target="_blank">{{ $v }}</a>
                        @endforeach
                    </div>
                    <div class="postnavi">
                        <div class="prev">
                            @if($prev)
                                上一篇：
                                <a href="{{ url('/show/'.$prev->id.'.html') }}" class="prev-next-a" title="{{ $prev->title }}">
                                    {{ str_limit($prev->title,15) }}
                                </a>
                            @else
                                上一篇：
                                没有更多文章了……
                            @endif
                        </div>
                        <div class="next">
                            @if($next)
                                下一篇：
                                <a href="{{ url('/show/'.$next->id.'.html') }}" class="prev-next-a" title="{{ $next->title }}">
                                    {{ str_limit($next->title,15) }}
                                </a>
                            @else
                                下一篇：
                                没有更多文章了……
                            @endif
                        </div>
                    </div>
                    <section class="related-post">
                        <h3><i class="icon-list-alt"></i> 您可能还会对下面的文章感兴趣：</h3>
                        <ul>
                        </ul>
                    </section>
                    <section class="related-pic">
                        <h3><i class="icon-file-image"></i> 相关文章</h3>
                        <ul>
                            @foreach(article_views($column->id) as $v)
                                <li>
                                    <div class="thumbnail">
                                        <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">
                                            <img class="load" src="https://img.622n.com/files/loading.gif" lay-src="{{ $v->image }}"/>
                                        </a>
                                    </div>
                                    <p><a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">{{ $v->title }}</a></p>
                                </li>
                            @endforeach
                        </ul>
                    </section>


                </article>
            </div>
        </main>
        @include(include_name('layouts.right'))
    </div>
    <div class="fixed-widget">
        <ul>
            <li><i class="icon-up-open"></i></li>
        </ul>
    </div>
@endsection


@section('script')

@endsection