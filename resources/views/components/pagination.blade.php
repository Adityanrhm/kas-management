<div class="flex justify-between items-center text-white mt-4 mx-2" x-show="!loading">

    <div class="text-white text-sm mt-2">
        Menampilkan ke
        <span x-text="pagination.from ?? 0"></span> -
        <span x-text="pagination.to ?? 0"></span> data dari
        <span x-text="pagination.total ?? 0"></span> data {{ $label ?? 'item' }}.
    </div>

    <div>
        <button x-on:click="changePage(pagination.prev_page_url)"
            class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 disabled:opacity-30"
            :disabled="!pagination.prev_page_url">Previous</button>

        <div class="inline-flex space-x-1">

            {{-- Halaman yang terlihat --}}
            <template x-for="page in visiblePages" :key="page">
                <button x-on:click="changePage(`{{ $attributes->get('route') }}?page=${page}&q=${query}`)"
                    class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 glow-white-hover"
                    :class="{ 'bg-white/10 text-white font-bold': page === pagination.current_page }"
                    x-text="page"></button>
            </template>

            {{-- Total button page tersedia --}}
            <template x-if="visiblePages[visiblePages.length - 1] < pagination.last_page">
                <div class="inline-flex items-center space-x-1">
                    <template x-if="visiblePages[visiblePages.length - 1] < pagination.last_page - 1">
                        <span class="px-2 text-sm">...</span>
                    </template>
                    <button
                        x-on:click="changePage(`{{ $attributes->get('route') }}?page=${pagination.last_page}&q=${query}`)"
                        class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 glow-white-hover"
                        :class="{
                            'bg-white/10 text-white font-bold': pagination.last_page === pagination.current_page
                        }"
                        x-text="pagination.last_page"></button>
                </div>
            </template>

        </div>

        <button x-on:click="changePage(pagination.next_page_url)"
            class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 disabled:opacity-30"
            :disabled="!pagination.next_page_url">Next</button>
    </div>
</div>
