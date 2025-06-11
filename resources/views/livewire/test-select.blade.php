<div>
    <h2>Livewire Test</h2>

    <select wire:model="selectedOption">
        <option value="">-- Selecciona --</option>
        @foreach ($options as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
        @endforeach
    </select>

    <p>Seleccionado: {{ $selectedOption }}</p>
</div>