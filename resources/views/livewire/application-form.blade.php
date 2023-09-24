{{-- <div>
    <x
    <x-filament-panels::form wire:submit="create">
        {{ $this->form }}
    </x-filament-panels::form>
    <x-filament-actions::modals />
</div> --}}

<x-filament-panels::form wire:submit="create">
    {{ $this->form }}
</x-filament-panels::form>