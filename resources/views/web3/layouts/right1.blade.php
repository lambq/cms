<aside class="sidebar bar1">
    <section class="widget theme-widget wow fadeInUp">
        <div class="section-title">
            <h3>热门文章</h3>
        </div>
        <ul>
            @foreach(article_limit() as $v)
                <li>
                    <div class="thumbnail">
                        <a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank">
                            <img src="{{ $v->image }}"/>
                        </a>
                    </div>
                    <p><a href="{{ url('/show/'.$v->id.'.html') }}" title="{{ $v->title }}" target="_blank"> {{ $v->title }} </a></p>
                </li>
            @endforeach
        </ul>
    </section>
</aside>