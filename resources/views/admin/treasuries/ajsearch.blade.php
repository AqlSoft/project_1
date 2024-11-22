
<table id="data" class="table table-striped table-bordered" style="width:100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Name</th>
      <th>Type</th>
      <th>Cashier</th>
      <th>Manage</th>
    </tr>
  </thead>
  <tbody>
  @php $i = 1 @endphp
  @if(isset($treasuries)&&!empty($treasuries)) @foreach ($treasuries as $treasury)
    <tr>
      <td>{{ $i }}</td>
      <td>{{ $treasury->name }}</td>
      <td>{{ $treasury->is_master == 1 ? 'Master' : 'Branche' }}</td>
      <td>{{ $admins[$treasury->cashier] }}</td>
      <td>
        <button class="btn btn-sm btn-success"><a href="/admin/treasuries/view/{{ $treasury->id }}"><span class="btn-title">View Treasury {{ $treasury->name }}</span><i class="fa fa-eye text-light"></i></a></button>
        <button class="btn btn-sm btn-primary"><a href="/admin/treasuries/edit/{{ $treasury->id }}"><span class="btn-title">Edit Treasury {{ $treasury->name }}</span><i class="fa fa-edit text-light"></i></a></button>
        <button class="btn btn-sm btn-danger"><a href="/admin/treasuries/delete/{{ $treasury->id }}"><span class="btn-title">Delete Treasury {{ $treasury->name }}</span><i class="fa fa-trash text-light"></i></a></button>
      </td>
    </tr>
    @php $i++ @endphp
  @endforeach @endif
  </tbody>
</table>
<div id="links">
  {{ $treasuries->links() }}
</div>