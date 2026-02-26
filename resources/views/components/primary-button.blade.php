<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full h-12 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/20 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
