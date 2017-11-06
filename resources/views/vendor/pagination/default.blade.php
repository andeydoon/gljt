@if ($paginator->hasPages())
    <div class="pageControl clearfix">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{--<li class="disabled"><span>&laquo;</span></li>--}}
        @else
            <a href="{{ $paginator->previousPageUrl() }}" title="上一页" class="CyPagesPrev">上一页</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <em>{{ $element }}</em>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="CyPagesCur">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" title="下一页" class="CyPagesNext">下一页</a>
        @else
            {{--<li class="disabled"><span>&raquo;</span></li>--}}
        @endif
    </div>
@endif
