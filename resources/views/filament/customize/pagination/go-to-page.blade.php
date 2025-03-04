<div style="width: 60px;" x-data="{page: '{{ $page }}'}">
    <form @submit.prevent="() => {
    var queryParams = new URLSearchParams(window.location.search || '');
    queryParams.set('page', page);
    Livewire.navigate(window.location.pathname + '?' + queryParams.toString());
    }" >
        <x-filament::input.wrapper>
            <x-filament::input
                x-model.number="page"
                placeholder="GoToPage"
            ></x-filament::input>
        </x-filament::input.wrapper>
    </form>
</div>
