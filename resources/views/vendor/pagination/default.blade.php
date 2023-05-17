@if ($paginator->hasPages())
        {{-- Previous Page Link --}}
        @if (PaginateRoute::hasPreviousPage())
            <li><a href="{{ PaginateRoute::previousPageUrl() }}" class="layui-laypage-prev">上一页</a></li>
        @else
            <li><a class="layui-laypage-prev layui-disabled">首页</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li>
                    {{ $element }}
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="thisclass">
                            {{ $page }}
                        </li>
                    @else
                        <li><a href="{{ PaginateRoute::pageUrl($page) }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if (PaginateRoute::hasNextPage($data))
            <li><a href="{{ PaginateRoute::nextPageUrl($data) }}" class="layui-laypage-next">下一页</a></li>
        @else
            <li><a class="layui-laypage-next layui-disabled">末页</a></li>
        @endif
@endif
