@props(['collection'])

@if ($collection->hasPages())
    <div class="mt-8">
        {{ $collection->onEachSide(1)->links() }}
    </div>
@endif
