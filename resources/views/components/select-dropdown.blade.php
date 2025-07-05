@props(['name', 'options' => [], 'selected' => null])

<select name="{{ $name }}" id="{{ $name }}"
    {{ $attributes->merge([
        'class' => implode(' ', [
            'block w-full rounded-lg',
            'dark:border-[rgba(255,255,255,0.25)]',
            'bg-black text-white',
            'focus:border-[rgba(255,255,255,0.25)]',
            'focus:ring-[rgba(255,255,255,0.25)]',
            'shadow-sm text-sm',
        ]),
    ]) }}>

    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @selected($selected == $value)>
            {{ $text }}
        </option>
    @endforeach
</select>
