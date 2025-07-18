<style>
    @layer components {

        input:-webkit-autofill,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #0D0D0D inset !important;
            -webkit-text-fill-color: rgb(255, 255, 255) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            border-radius: 0.5rem !important;
            transition: background-color 5000s ease-in-out 0s;
            caret-color: white;
        }
    }
</style>

@props(['disabled' => false])

<input @disabled($disabled) spellcheck="false"
    {{ $attributes->merge([
        'class' =>
            'block w-full rounded-lg pl-10 shadow-sm text-sm ' .
            'border-[rgba(255,255,255,0.25)] dark:border-[rgba(255,255,255,0.25)] ' .
            'dark:bg-white/5 dark:text-gray-300 ' .
            'dark:focus:border-[rgba(255,255,255,0.25)] dark:focus:border-[rgba(255,255,255,0.25)] ' .
            'dark:focus:ring-[rgba(255,255,255,0.25)]',
    ]) }}>
