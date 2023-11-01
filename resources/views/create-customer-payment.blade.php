{{-- <x-filament-panels::page
@class([
    'fi-resource-create-record-page',
    'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
])
>
    <x-filament-panels::form>
        {{ $this->form }}
    </x-filament-panels::form>
    <livewire:paymongo-checkout
    :actions="$this->getCachedFormActions()"
    :full-width="$this->hasFullWidthFormActions()"
    />
</x-filament-panels::page> --}}

<x-filament-panels::page
    @class([
        'fi-resource-create-record-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
    ])
>
    <x-filament-panels::form
        :wire:key="$this->getId() . '.forms.' . $this->getFormStatePath()"
        wire:submit="create"
    >
        {{ $this->form }}

    @livewire('paymongo-checkout')
    </x-filament-panels::form>
</x-filament-panels::page>