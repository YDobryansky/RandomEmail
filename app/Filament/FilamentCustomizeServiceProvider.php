<?php
/**
 * Create: Vladimir
 */

namespace App\Filament;

use App\Filament\Livewire\Table\GoToPage;
use Filament\Forms\Components\DateTimePicker;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\View;
use Livewire\Livewire;

class FilamentCustomizeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        DateTimePicker::$defaultDateTimeDisplayFormat = 'Y-m-d H:i';
        DateTimePicker::$defaultDateTimeWithSecondsDisplayFormat = 'Y-m-d H:i:s';
        DateTimePicker::$defaultDateDisplayFormat = 'Y-m-d';

        Livewire::component('go-to-page', GoToPage::class);

        FilamentView::registerRenderHook(
            \Filament\Tables\View\TablesRenderHook::TOOLBAR_START,
            fn(): string => new HtmlString(Blade::render('<div wire:loading>
    <x-filament::loading-indicator class="h-5 w-5"/>
</div>'))
        );

        FilamentView::registerRenderHook(
            \Filament\Tables\View\TablesRenderHook::TOOLBAR_START,
            fn() => new HtmlString(Blade::render('@livewire("go-to-page")')),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::SCRIPTS_AFTER,
            fn(): string => new HtmlString('
        <script>document.addEventListener("scroll-to-top", () => window.scrollTo(0, 0))</script>
            '),
        );
    }
}
