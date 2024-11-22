@extends('layouts.admin')

@section('title')
	تقارير الطبالي
@endsection

@section('pageHeading')
	أرصدة الطبالى لدى العملاء
@endsection

{{-- This view is created to pick a contract to calculate tables stats / creadit --}}
@section('content')
	<div class="container">
		<fieldset>
			<legend>
				ابحث عن عقد
			</legend>
			<div class="m-4" style="background-color: #fff; box-shadow: 0 0 8px 3px #777 inset">
				<form class="m-4 p-4" id="ContractTablesInfo" action="{{ route('get-contract-tables-count') }}" method="GET">
					@csrf

					<div class="input-group mt-3">
						<input class="form-control" id="search_by_client" type="text" name="search_by_client" placeholder="البحث باسم العميل">
						<label class="input-group-text" id="search_by_client_btn" data-search-url="{{ route('search-contracts-by-client') }}"
							data-search-token="{{ csrf_token() }}" for="search_by_client">
							<i class="fa fa-search"></i>
						</label>

						<label class="input-group-text" for="the_client">اسم العميل</label>
						<select class="form-control" id="the_client" data-url="{{ route('get-client-contracts') }}" data-token="{{ csrf_token() }}"
							name="client"></select>

						<select class="form-control" id="contracts" name="contract_id" required>

						</select>
					</div>
					<div class="input-group mt-2">
						<label class="input-group-text" for="from_date">من تاريخ:</label>
						<input class="form-control" id="from_date" type="date" name="from_date">
						<label class="input-group-text" for="to_date">إلى تاريخ:</label>
						<input class="form-control" id="to_date" type="date" name="to_date">
					</div>
					<div class="buttons">
						<button class="btn btn-sm btn-outline-primary">جلب البيانات</button>
					</div>
				</form>
			</div>
			<div class="m-4 p-4" style="background-color: #fff; box-shadow: 0 0 8px 3px #777 inset">

				<h4 class="text-right btn btn-block btn-primary" id="client_name" style="cursor: pointer">اسم العميل</h4>
				<p> <a id="contract_s_number"></a></p>

				<div class="mb-3" id="periods">

				</div>

				<table class="w-100">
					<thead>
						<tr>
							<th>حجم الطبلية</th>
							<th>المحجوزة</th>
							<th>المستخدمة</th>
							<th>المخرجة</th>
							<th>المتبقية</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>طبالي صغيرة</td>
							<td><span id="smallAssigned"></span></td>
							<td><span id="smallUsed"></span></td>
							<td><span id="smallExited"></span></td>
							<td><span id="smallOccupied"></span></td>
						</tr>
						<tr>
							<td>طبالي صغيرة</td>
							<td><span id="largeAssigned"></span></td>
							<td><span id="largeUsed"></span></td>
							<td><span id="largeExited"></span></td>
							<td><span id="largeOccupied"></span></td>
						</tr>
					</tbody>
				</table>

			</div>
		</fieldset>
	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			var clientContracts, largeTablesassigned, smallTablesassigned;
			$(document).on('keyup', '#search_by_client', function() {

				let url = $('#search_by_client_btn').attr('data-search-url');
				let token = $('#search_by_client_btn').attr('data-search-token');
				let query = $('#search_by_client').val();

				jQuery.ajax({
					url: url,
					type: 'post',
					dataType: 'html',
					data: {
						query: query,
						'_token': token,
						url: url
					},
					cash: false,
					success: function(data) {
						const clients = JSON.parse(data)


						var options
						if (clients.length == 0) {
							options = `<option hidden>لا يوجد نتائج مطابقة لبحثك</option>`
						} else {
							options = clients.map(option => {
								return `<option value="${option.id}">${option.a_name}</option>`
							})
						}
						$('#the_client').html(options);
					},
					error: function() {

					}
				});
			});

			$('#the_client').on('blur', function(e) {

				let token = $(this).attr('data-token');
				let url = $(this).attr('data-url');
				let client = $(this).val();

				console.log(token, url, $(this).val())

				jQuery.ajax({
					url: url,
					type: 'post',
					dataType: 'html',
					data: {
						client: client,
						'_token': token
					},
					cash: false,
					success: function(data) {
						const client = JSON.parse(data)
						$('#client_name').html(client.a_name)
						$('#client_name').click(() =>
							window.location.href = `/admin/clients/view/${client.id}`
						)

						const contracts = client.contracts;
						var contractsList;
						if (contracts === null) {
							contractsList = `<option hidden>من فضلك اختر عميل أولا</option>`
						} else {
							if (contracts.length <= 0) {
								contractsList = `<option hidden>لا يوجد عقود مسجلة لهذا العميل</option>`
							} else {
								clientContracts = contracts;
								const parsedStartDate = clientContracts[0].starts_in_greg
								const parsedEndDate = clientContracts[0].ends_in_greg
								$('#from_date').val(parsedStartDate)
								$('#to_date').val(parsedEndDate)

								contractsList = contracts.map(option => {
									return `<option data-start-date="${option.starts_in_greg}" data-end-date="${option.ends_in_greg}" value="${option.id}">${option.s_number}</option>`
								})
							}
						}
						$('#contracts').html(contractsList);
					},
					error: function() {
						console.log('error happened')
					}
				});
			});

			$('#contracts').on('change', function(e) {
				console.log('changed')
				console.log($(this).find(':selected').attr('data-start-date'))
				const startDate = $(this).find(':selected').attr('data-start-date')
				const endDate = $(this).find(':selected').attr('data-end-date')
				$('#from_date').val(startDate)
				$('#to_date').val(endDate)
			});


			$('#ContractTablesInfo').submit(function(event) {
				event.preventDefault(); // Prevent default form submission

				var formData = $(this).serialize(); // Serialize form data

				$.ajax({
					type: "POST",
					url: $(this).attr('action'), // Replace with your endpoint URL
					data: formData,
					success: function(response) {
						// Handle successful response
						console.log(response);

						const periods = response.periods
						const periodsList = periods.map((period) => {
							smallTablesassigned = period.items.find(item => {
								return item.item_id == 1
							}).qty
							largeTablesassigned = period.items.find(item => {
								return item.item_id == 2
							}).qty


							return `
                                <div class="input-group mb-2">
                                    <label class="input-group-text">${period.the_order}</label>
                                    <label class="input-group-text">${period.the_code}</label>
                                    <label class="input-group-text">من</label>
                                    <button class="form-control">${period.starts_in}</button>
                                    <label class="input-group-text">إلى</label>
                                    <button class="form-control">${period.ends_in}</button>
                                    <label class="input-group-text">طبالي صغيرة</label>
                                    <button class="form-control">${smallTablesassigned}</button>
                                    <label class="input-group-text">طبالى كبيرة</label>
                                    <button class="form-control">${largeTablesassigned}</button>
                                    
                                </div>`

						})
						$('#smallAssigned').html(0)
						$('#largeAssigned').html(0)
						$('#periods').html(periodsList);
						$('#smallUsed').html(response.tablesUsed.small)
						$('#largeUsed').html(response.tablesUsed.large)
						$('#smallExited').html(response.exitedTables.small)
						$('#largeExited').html(response.exitedTables.large)
						$('#smallOccupied').html(response.tablesUsed.small - response.exitedTables.small)
						$('#largeOccupied').html(response.tablesUsed.large - response.exitedTables.large)
						$('#smallAssigned').html(smallTablesassigned)
						$('#largeAssigned').html(largeTablesassigned)
						// You can display success messages, redirect the user, or perform other actions here
					},
					error: function(error) {
						// Handle errors
						console.error(error);
						// Display error messages to the user
					}
				});

			});


		});
	</script>
@endsection
