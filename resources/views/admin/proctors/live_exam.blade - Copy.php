@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-lg-12">
     <h2 class="h2">Current Exam</h2>   
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
<th>Student</th>
<th>Student ID</th>
<th>Subject</th>
<th>Date / Time</th>
<th>Alert(s)</th>
<th>Preview</th>
<th width="150">Action</th>
</tr>
</thead>
<tbody>
<tr>
<td>Andrea Tuz</td>
<td>8675309</td>
<td>Mathematics</td>
<td>April-7-2020 / 11:00 AM</td>
<td>
  <button class="btn btn-danger" type="button" data-popover-content="#unique-id" data-toggle="popover" data-placement="bottom"><i class="fas fa-exclamation-triangle"></i> 5</button>
  <div class="alert-id" style="display:none;">
    <div class="popover-body">
      <b>Head Movement</b>: 2<br>
	  <b>Eye Movement</b>: 2<br>
	  <b>Object Detection</b>: 1
    </div>
  </div></td>
<td><a href="#"><i class="fas fa-play-circle"></i></a></td>
<td><button class="btn btn-danger" type="button"><i class="fas fa-times-circle"></i></button> | <button class="btn btn-success" type="button"><i class="fas fa-check-circle"></i></button></td>
</tr>
<tr>
<td>Andrea Tuz</td>
<td>8675309</td>
<td>Mathematics</td>
<td>April-7-2020 / 11:00 AM</td>
<td>
  <button class="btn btn-danger" type="button" data-popover-content="#unique-id" data-toggle="popover" data-placement="bottom"><i class="fas fa-exclamation-triangle"></i> 3</button>
  <div class="alert-id" style="display:none;">
    <div class="popover-body">
      <b>Head Movement</b>: 1<br>
	  <b>Eye Movement</b>: 1<br>
	  <b>Object Detection</b>: 1
    </div>
  </div></td>
<td><a href="#"><i class="fas fa-play-circle"></i></a></td>
<td><button class="btn btn-danger" type="button"><i class="fas fa-times-circle"></i></button> | <button class="btn btn-success" type="button"><i class="fas fa-check-circle"></i></button></td>
</tr>

<tr>
<td>Andrea Tuz</td>
<td>8675309</td>
<td>Mathematics</td>
<td>April-7-2020 / 11:00 AM</td>
<td>
  <button class="btn btn-danger" type="button" data-popover-content="#unique-id" data-toggle="popover" data-placement="bottom"><i class="fas fa-exclamation-triangle"></i> 2</button>
  <div class="alert-id" style="display:none;">
    <div class="popover-body">
      <b>Head Movement</b>: 2
    </div>
  </div></td>
<td><a href="#"><i class="fas fa-play-circle"></i></a></td>
<td><button class="btn btn-danger" type="button"><i class="fas fa-times-circle"></i></button> | <button class="btn btn-success" type="button"><i class="fas fa-check-circle"></i></button></td>
</tr>

<tr>
<td>Andrea Tuz</td>
<td>8675309</td>
<td>Mathematics</td>
<td>April-7-2020 / 11:00 AM</td>
<td>
  <button class="btn btn-danger" type="button" data-popover-content="#unique-id" data-toggle="popover" data-placement="bottom"><i class="fas fa-exclamation-triangle"></i> 4</button>
  <div class="alert-id" style="display:none;">
    <div class="popover-body">
      <b>Head Movement</b>: 1<br>
	  <b>Eye Movement</b>: 2<br>
	  <b>Object Detection</b>: 1
    </div>
  </div></td>
<td><a href="#"><i class="fas fa-play-circle"></i></a></td>
<td><button class="btn btn-danger" type="button"><i class="fas fa-times-circle"></i></button> | <button class="btn btn-success" type="button"><i class="fas fa-check-circle"></i></button></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<div style="position: absolute; top: 70px; right: 20px;">

    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
      <div class="toast-header">
	<i class="fas fa-exclamation-triangle mr-2"></i>

        <strong class="mr-2">Andrea Tuz</strong>
        <small>1 mins ago</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
      </div>
      <div class="toast-body">
        Head movement detected
      </div>
    </div>
    
    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
      <div class="toast-header">

        <i class="fas fa-exclamation-triangle mr-2"></i>

        <strong class="mr-2">Andrea Tuz	</strong>
        <small>1 mins ago</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
      </div>
      <div class="toast-body">
        Eye movement detected
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