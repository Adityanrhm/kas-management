<div>
    <table class="min-w-full border bg-blue-600">
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">
                        {{ is_array($column) ? $column['label'] : ucwords(str_replace(['.', '_'], [' ', ' '], $column)) }}
                    </th>
                @endforeach

            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr>
                    @foreach ($columns as $column)
                        @php
                            $key = is_array($column) ? $column['field'] : $column;
                        @endphp
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ data_get($record, $key) ?? '-' }}
                        </td>
                    @endforeach

                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="p-4 text-center text-gray-400">
                        No data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
