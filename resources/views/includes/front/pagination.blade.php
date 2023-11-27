@if($item->total() > 9)
    <!-- Start custom-pagination -->
    <div class="custom-pagination d-flex align-items-center justify-content-md-end justify-content-center">
        <!-- Start nav -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item {{ ($item->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $item->url($item->currentPage()-1) }}">@lang("alnkel.pagination-previous")</a>
                </li>
                @for($i = 1;$i <= $item->total();$i++)
                    <li class="page-item {{ $i === $item->currentPage() ? 'active' : ''}}">
                        <a class="page-link" href="{{ $item->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ ($item->currentPage() == $item->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $item->url($item->currentPage()+1) }}">@lang("alnkel.pagination-next")</a>
                </li>
            </ul>
        </nav>
        <!-- End nav -->
    </div>
    <!-- End custom-pagination -->
@endif