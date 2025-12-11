@php
    use Illuminate\Pagination\AbstractPaginator;
@endphp

@if ($products instanceof AbstractPaginator && $products->lastPage() > 1)
    <nav aria-label="Custom pagination" class="mt-5">
        <ul class="pagination justify-content-center pagination-rounded shadow-sm">

            {{-- Previous Page Link --}}
            @if ($pagination->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-pill px-3">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-pill px-3" href="{{ $pagination->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Page Number Links --}}
            @for ($i = 1; $i <= $pagination->lastPage(); $i++)
                @if ($i == $pagination->currentPage())
                    <li class="page-item active">
                        <span class="page-link bg-primary border-0 text-white rounded-pill px-3">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-pill px-3" href="{{ $pagination->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($pagination->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-pill px-3" href="{{ $pagination->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link rounded-pill px-3">&raquo;</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
