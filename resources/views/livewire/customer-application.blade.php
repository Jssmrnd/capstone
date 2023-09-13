<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <button type="submit">
            Submit
        </button>
    </form>
    <button wire:click="increment">
        Submit
    </button>
    <h1>{{ $n }}</h1>
</div>
