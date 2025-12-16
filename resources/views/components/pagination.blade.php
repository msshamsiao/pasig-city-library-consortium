@props(['items', 'perPageOptions' => [10, 20, 50, 100]])

<div class="bg-white px-4 py-3 border-t border-gray-200">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
        <!-- Left: Per page selector -->
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-700">Show:</span>
            <select 
                id="perPage" 
                name="perPage"
                onchange="window.location.href = updateQueryStringParameter(window.location.href, 'perPage', this.value)"
                class="border-gray-300 rounded-md text-sm py-1 px-2 focus:ring-blue-500 focus:border-blue-500"
            >
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}" {{ request('perPage', 10) == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            <span class="text-sm text-gray-700">entries</span>
        </div>

        <!-- Center: Showing info -->
        <div class="text-sm text-gray-700">
            Showing <span class="font-semibold text-gray-900">{{ $items->firstItem() ?? 0 }}</span> to <span class="font-semibold text-gray-900">{{ $items->lastItem() ?? 0 }}</span> of <span class="font-semibold text-gray-900">{{ $items->total() }}</span> results
        </div>

        <!-- Right: Pagination links -->
        <div>
            {{ $items->onEachSide(1)->links() }}
        </div>
    </div>
</div>

<script>
    function updateQueryStringParameter(uri, key, value) {
        const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        const separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }
</script>
