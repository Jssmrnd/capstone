{{-- <div>
    <x
    <x-filament-panels::form wire:submit="create">
        {{ $this->form }}
    </x-filament-panels::form>
    <x-filament-actions::modals />
</div> --}}



<div class="bg-white text-white shadow-md">
    <form wire:submit="create">
        {{ $this->form }}
        <button type="submit">Submit Applicaton</button>
    </form>
</div>