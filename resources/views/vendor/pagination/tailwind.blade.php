@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6">
        <ul class="inline-flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-full cursor-not-allowed">&laquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-4 py-2 bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-cyan-50 hover:text-cyan-700 transition transform hover:scale-105">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-4 py-2 bg-white border border-gray-300 rounded-full text-gray-500 cursor-default">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-4 py-2 bg-cyan-100 text-cyan-700 rounded-full shadow-sm transform transition">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-4 py-2 bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-cyan-50 hover:text-cyan-700 transition transform hover:scale-105">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-4 py-2 bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-cyan-50 hover:text-cyan-700 transition transform hover:scale-105">
                        &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-full cursor-not-allowed">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
