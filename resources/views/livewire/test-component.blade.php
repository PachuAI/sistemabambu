<div>
    <h1>Test Livewire Component</h1>
    <p>Si ves este mensaje, Livewire está funcionando correctamente.</p>
    <button wire:click="$set('test', 'clicked')" class="btn btn-primary">Test Button</button>
    @if(isset($test))
        <p>Button clicked: {{ $test }}</p>
    @endif
</div>
