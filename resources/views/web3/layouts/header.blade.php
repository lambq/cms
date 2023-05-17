<header class="header">
    <div class="inner">
        <div class="logo animated fadeInLeft"> <a href="{{ url('/') }}" title="{{ getSys('webname') }}"><img src="{{ asset('logo.png') }}" alt="{{ getSys('webname') }}"/></a> </div>
        <div class="top-other">
            <ul>
                <li><i class="icon-menu"></i></li>
                <li><i class="icon-search"></i></li>
                <div class="clear"></div>
            </ul>
        </div>
        <nav class="nav">
            <div class="menu">
                <ul>
                    <li @if(route_class() == 'root') class="current" @endif><a href="/" >首页</a> </li>
                    <li @if(route_class() == 'top') class="current" @endif><a href="{{ url('top') }}" >热门资讯</a> </li>
                    @foreach (getMenu() as $v)

                        <li class="common @if(route_class() == $v->name) current @endif">
                            <a href="{{ url($v->name) }}">{{ $v->title }}</a>
                        </li>
                    @endforeach
                    <li @if(route_class() == 'update') class="current" @endif><a href="{{ url('update') }}" >动态资讯</a> </li>
                </ul>
            </div>
        </nav>
        <div class="clear"></div>
    </div>
</header>
<div class="search-bg" >
    <div class="inner">
        <div class="search-form">
            <input type="text" class="s" name="q" id="q" value="" placeholder="输入关键词搜索..."/>
        </div>
        {{--<div class="tagscloud"> <span>快捷搜索：</span> {dede:hotwords num='8'/}  </div>--}}
    </div>
</div>
