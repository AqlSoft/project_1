<div class="mt-3">
    <h4> محتويات الطبلية:</h4>
    @foreach ($entries as $item)
        <p class="mt-1 mb-0 py-1 px-3 border row">
            <span class="col col-1">{{ $item->quantity }}</span>
            <span class="col col-2">{{ $item->boxName }}</span> <span class="col col-auto">{{ $item->itemName }}</span>
        </p>
    @endforeach
</div>
