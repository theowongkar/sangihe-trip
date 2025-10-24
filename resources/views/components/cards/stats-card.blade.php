@props(['title', 'value', 'icon' => null, 'description', 'color' => 'bg-red-500'])

<div class="flex flex-col rounded-lg shadow overflow-hidden hover:scale-103 transition">
    <div class="flex flex-1 items-center justify-between p-5 bg-white">
        <h2 class="text-sm lg:text-md">{{ $title }} <span
                class="block text-2xl font-bold">{{ $value }}</span></h2>
        <div class="flex items-center justify-center p-2 {{ $color }} text-white rounded-full">
            {!! $icon !!}
        </div>
    </div>

    <div class="{{ $color }} px-3 py-2">
        <p class="text-gray-100 text-xs lg:text-sm">{{ $description }}.</p>
    </div>
</div>
