@extends(include_name('layouts.app'))

@section('title', $column->title.'-'.getSys('webname'))
@section('keywords', $column->keywords )
@section('description', $column->description )

@section('content')
<div class="blank"></div>

<div class="inner container">
    <main class="main">
        <div class="content">
            <div class="breadcrumb"> <span> 当前位置：<a href="{{ url('/') }}">首页</a> &gt; <a href="{{ url($column->name) }}">{{ $column->title }}</a> &gt; </span> </div>
            @if(isset($articles))
                @foreach($articles as $v)
                    <section class="section wow fadeIn">
                        <div class="thumbnail">
                            <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">
                                <img  class="load" src="https://img.622n.com/files/loading.gif" lay-src="{{ $v->image }}" alt="{{ $v->title }}"/>
                            </a>
                        </div>
                        <h2>
                            <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">{{ $v->title }}</a>
                        </h2>
                        <div class="postmeta">
                            <span>
                                <i class="icon-calendar"></i>
                                <time> {{ $v->updated_at }} </time>
                            </span>
                            <span>
                                <i class="icon-eye"></i> {{ $v->views }}
                            </span>
                        </div>
                        <div class="excerpt">
                            <p>  {{ str_limit($v->description, 200) }} </p>
                        </div>
                    </section>
                @endforeach
            @endif
            <div class="pagess">
                <ul>
                    {{ $articles->links('vendor.pagination.default', ['data' => $articles]) }}
                </ul>
            </div>
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
    <script>prettyPrint();</script>
@endsection
