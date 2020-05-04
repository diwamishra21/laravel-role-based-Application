@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-lg-12">
     <h2 class="h2">Upcoming Exam</h2>   
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
     <h2 class="h2">&nbsp;</h2>   
    </div>
</div>
<div class="row examTable">
<div class="col-md-12">
<div class="card">
<div class="card-body">
<table class="table table-responsive-sm table-striped">
<thead>
<tr>
<th>Subject</th>
<th>Date registered</th>
<th>Status</th>
<th width="150">Action</th>
</tr>
</thead>
<tbody>
<tr>
<td>Mathematics</td>
<td>2020/01/01</td>
<td><span class="badge badge-success">Active</span></td>
<td><button class="btn btn-block btn-success" type="button">Start Exam</button></td>
</tr>
<tr>
<td>Physics</td>
<td>2020/02/01</td>
<td><span class="badge badge-secondary">In-active</span></td>
<td></td>
</tr>
<tr>
<td>Chemistry</td>
<td>2020/02/01</td>
<td><span class="badge badge-secondary">In-active</span></td>
<td></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.mass_destroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection