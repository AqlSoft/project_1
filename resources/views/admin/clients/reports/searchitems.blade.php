@php
    $clients_counter = 0;
@endphp
<div class="accordion" id="accordionExample">
    @foreach ($clients as $client => $data)
        <div class="accordion-item" id="client_{{ $client }}">
            <h2 class="accordion-header  border-secondary">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse_{{ $client }}" aria-expanded="false"
                    aria-controls="collapse_{{ $client }}">
                    {{ ++$clients_counter }} - {{ $clientsNames[$client] }}
                    <span id="itemQty_{{ $client }}" style="position: absolute; left: 4em">Sum</span>
                </button>
            </h2>

            <div id="collapse_{{ $client }}" class="accordion-collapse collapse"
                data-bs-parent="#accordionExample">
                <div class="accordion-body" style="overflow-x: scroll;">
                    <div class="d-flex" style="overflow-wrap: nowrap;">
                        @php
                            $inputs = 0;
                            $outputs = 0;
                            $items_counter = 0;
                        @endphp
                        <div class="col col-auto d-grid gap-0 p-0"
                            style="border-top: 2px solid #333; border-bottom: 2px solid #333; border-left: 1px solid #333;">
                            <div class="py-1 px-3 bg-secondary text-light">اسم الصنف</div>
                            <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">حجم الكرتون
                            </div>
                            <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">اجمالى المدخلات
                            </div>
                            <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">اجمالى المخرجات
                            </div>
                            <div class="py-1 px-3">اجمالى الكمية</div>
                        </div>
                        @foreach ($data as $key => $info)
                            <div class="col col-auto d-grid gap-0 p-0"
                                style="border-top: 2px solid #333; border-bottom: 2px solid #333; border-left: 1px solid #333;">
                                <div class="py-1 px-1 text-center bg-secondary text-ligh"
                                    style="border-bottom: 1px solid #ccc">
                                    {{ $storeItems[$info->item_id] }}</div>
                                <div class="py-1 px-1 text-center" style="border-bottom: 1px solid #ccc">
                                    {{ $info->box_size == '' ? 'unknown' : $storeBoxes[$info->box_size] }}
                                </div>
                                <div class="py-1 px-1 text-center" style="border-bottom: 1px solid #ccc">
                                    {{ $info->totalInputs }}</div>
                                <div class="py-1 px-1 text-center" style="border-bottom: 1px solid #ccc">
                                    {{ $info->totalOutputs }}</div>
                                <div class="py-1 px-1 text-center">
                                    {{ $info->totalInputs - $info->totalOutputs }}</div> @php ++$items_counter @endphp
                            </div>
                            @php
                                $inputs += $info->totalInputs;
                                $outputs += $info->totalOutputs;
                            @endphp
                        @endforeach
                        <div class="col col-auto d-grid gap-0 p-0"
                            style="border-top: 2px solid #333; border-bottom: 2px solid #333;">
                            <div class="py-1 px-3 bg-secondary text-light">الاجمالى</div>
                            <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">
                                {{ $items_counter }}</div>
                            <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">
                                {{ $inputs }}</div>
                            <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">
                                {{ $outputs }}</div>
                            <div data-id="itemQty_{{ $client }}" class="client-total-qty py-1 px-3"
                                data-close="client_{{ $client }}">
                                {{ $inputs - $outputs }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
