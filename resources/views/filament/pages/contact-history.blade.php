<x-filament::page>
    @include('filament.customize.loading.spin')
    <h2 class="text-xl font-bold mb-4">Contact: {{ $contact }}</h2>
    <div class="space-y-2">
        @foreach($history as $item)
            <div class="border p-2">{{ is_array($item) ? json_encode($item) : $item }}</div>
        @endforeach
    </div>
</x-filament::page>
