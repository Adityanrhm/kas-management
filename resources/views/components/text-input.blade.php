<style>
    @layer components {
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px #0f172a inset !important;
            -webkit-text-fill-color: #d1d5db !important;
        }

        input:-webkit-autofill:focus {
            -webkit-box-shadow:
                0 0 0 1000px #0f172a inset,
                0 0 0 2px #4f46e5 !important;
            border: none !important;
        }

    }
</style>

@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'block w-full rounded-lg pl-10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:ring-indigo-600 shadow-sm']) }}>
