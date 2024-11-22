<div class="accordion accordion-flush" id="clientsList">
	@foreach ($clients as $client)
		<option value="{{ $client->id }}">{{ $client->a_name }}</option>
	@endforeach
	{{-- <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-{{ $item->id }}" aria-expanded="false"
                aria-controls="flush-collapse-{{ $item->id }}">
                <a href="{{ route('clients.view', [$item->id]) }}">{{ $item->a_name }} </a>
            </button>
        </h2>
        <div id="flush-collapse-{{ $item->id }}" class="accordion-collapse collapse"
            data-bs-parent="#clientsList">
            <div class="accordion-body">
                <div class="button-group">
                    @if (!empty($item->contracts))
                        @foreach ($item->contracts as $contract)
                            <div
                                class="btn btn-sm py-1 mx-2 btn-outline-{{ $contract->status == 1 ? 'primary' : 'secondary' }}">
                                {{ $contract->s_number }}
                            </div>
                            <button class="showContractStats me-2 btn btn-sm btn-light"
                                data-token="{{ csrf_token() }}" data-id="{{ $contract->id }}"
                                data-href="{{ route('get.contract.stats', [$contract->id]) }}"><i
                                    class="fa fa-list"></i></button>
                        @endforeach
                    @else
                        <div class="btn btn-block btn-outline-warning">لا يوجد عقود لهذا العميل</div>
                    @endif
                </div>

            </div>
        </div>
    </div> --}}

</div>
<div class="text-right">
	<h4></h4>

</div>
