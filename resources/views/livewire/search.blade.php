<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <input wire:model="search" type="search" placeholder="Search a unit by name...">
    <h1>Search Results:</h1>
 
    <ul>
        @foreach($unit_models as $unit_model)
            <li>{{ $unit_model->model_name }}</li>
        @endforeach
    </ul>
</div>
