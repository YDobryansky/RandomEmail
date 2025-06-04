<x-filament::page>
    <form wire:submit.prevent="connect" class="space-y-4">
        <select wire:model="gatewayId" class="filament-forms-select w-full">
            <option value="">Select Gateway</option>
            @foreach($gateways as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        <x-filament::button type="submit">Connect</x-filament::button>
        @include('filament.customize.loading.spin')
    </form>

    @if($contacts)
        <div class="mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Email</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($contacts as $contact)
                        <tr>
                            <td class="px-4 py-2">
                                <a href="{{ \App\Filament\Pages\ContactHistory::getUrl(['contactId' => $contact['id'] ?? $loop->index, 'gatewayId' => $gatewayId]) }}">
                                    {{ $contact['email'] ?? $contact['id'] ?? '' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-2" colspan="1">No contacts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</x-filament::page>
