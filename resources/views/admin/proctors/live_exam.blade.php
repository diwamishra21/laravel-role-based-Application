@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    
</div>
<div class="card">
    <div class="card-header">
        Live Exams
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                    <th></th>
                    <th>Srudent Id</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Alert</th>
                    <th>Live Stream</th>
                    <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($datalist as $key => $schedule)
                        <tr data-entry-id="{{ $schedule->id }}">
                            <td>
                               
                            </td>
                            <td>
                            {{ $schedule->student_id ?? '' }}
                            </td>
                            <td>
                                {{ $schedule->name ?? '' }}
                            </td>
                            <td>
                            {{ $schedule->title ?? '' }}
                            </td>
                            <td>
                            {{ $schedule->start_time ?? '' }}
                            </td>
                            <td>
                            {{ $schedule->end_time ?? '' }}
                            </td>
                            <td>
                            <button class="btn btn-danger" type="button" data-popover-content="#unique-id" data-toggle="popover" data-placement="bottom"><i class="fas fa-exclamation-triangle"></i> <?php echo rand(1,5); ?></button>
                            <div class="alert-id" style="display:none;">
                              <div class="popover-body">
                                <b>Head Movement</b>: 1<br>
                              <b>Eye Movement</b>: 2<br>
                              <b>Object Detection</b>: 1
                              </div>
                            </div>
                            </td>
                            
                            <td>
                            <a href="#"><i class="fas fa-play-circle"></i></a>
                            </td>
                            <td>
                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fas fa-tasks"></i></button>
                            </td>
                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                              <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    
                                  </div>
                                  <div class="modal-body">
                                  
                                  <button class="btn btn-success" type="button">Send Massage</button>
                                  <button class="btn btn-warning" type="button">Send Alert</button>
                                  <button class="btn btn-danger" type="button">Send Warning</button>
                                  <br>
                                  <button class="btn btn-warning" type="button">Hold Exam</button>
                                  <button class="btn btn-warning" type="button">Terminate Exam</button>
                                  
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                                <!-- Modal content-->

                              </div>
                            </div>
                            <!-- Modal -->

                        </tr>
                    @endforeach
                </tbody>
            </table>
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