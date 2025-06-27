<div
    class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-2xl shadow-xl shadow-indigo-500/10 p-6 backdrop-blur-md">
    <div class="flex justify-between items-center mb-6">
        {{ $slot }}
        <div class="flex gap-3">
            <div class="relative">
                <input type="text" placeholder="Search..."
                    class="bg-slate-700/60 text-white placeholder-slate-400 px-4 py-2 pl-10 rounded-xl border border-slate-600 focus:outline-none focus:border-indigo-500 shadow-inner shadow-black/20">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <button type="button"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium
                   bg-black hover:bg-black text-white">
                <i class="fa-solid fa-plus text-xs"></i>
                Data Baru
            </button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="bg-slate-800/80 backdrop-blur-md text-slate-300 uppercase text-xs tracking-widest border-b border-slate-700 shadow-inner shadow-black/20">
                    <th class="text-left py-3 px-4">Photo</th>
                    <th class="text-left py-3 px-4">NIS</th>
                    <th class="text-left py-3 px-4">Nama</th>
                    <th class="text-left py-3 px-4">Email</th>
                    <th class="text-left py-3 px-4">Role</th>
                    <th class="text-left py-3 px-4">Action</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @forelse ($records as $record)
                    <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition duration-200">
                        @foreach ($columns as $column)
                            @php $key = is_array($column) ? $column['field'] : $column; @endphp
                            <td class="py-4 px-4 text-slate-300">
                                {{ data_get($record, $key) ?? '-' }}
                            </td>
                        @endforeach
                        <td class="py-4 px-4">
                            <button class="text-slate-400 hover:text-red-500 transition duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" class="p-4 text-center text-slate-500 italic">
                            No data found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
