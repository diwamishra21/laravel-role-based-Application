@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    
</div>
<div class="card">
    <div class="card-header">
        Past Exams
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                    <th></th>
                    <th>Subject</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Student Feedback</th>
                    <th>Proctor Remarks</th>
                    <th>Reviewer Remarks</th>
                    <th width="150">Result</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($datalist as $key => $schedule)
                        <tr data-entry-id="{{ $schedule->id }}">
                            <td>
                               
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
                                {{ $schedule->student_feedback ?? '' }}
                            </td>
                            <td>
                                {{ $schedule->proctor_remarks ?? '' }}
                                <?php if($schedule->proctor_action == 1){ ?>
                                    <button class="btn btn-success" type="button"><i class="fas fa-check-circle"></i></button>
                                <?php } elseif($schedule->proctor_action == 2){?>
                                    <button class="btn btn-warning" type="button"><i class="fas fa-info-circle"></i></button>
                                <?php }elseif($schedule->proctor_action == 3){?>
                                    <button class="btn btn-danger" type="button"><i class="fas fa-times-circle"></i></button>
                               <?php } ?>
                            </td>
                            <td>
                                {{ $schedule->reviewer_remarks ?? '' }}
                                <?php if($schedule->reviewer_action == 1){ ?>
                                    <button class="btn btn-success" type="button"><i class="fas fa-check-circle"></i></button></td>
                                <?php } elseif($schedule->reviewer_action == 2){?>
                                    <button class="btn btn-warning" type="button"><i class="fas fa-info-circle"></i></button></td>
                                <?php }elseif($schedule->reviewer_action == 3){?>
                                    <button class="btn btn-danger" type="button"><i class="fas fa-times-circle"></i></button>
                               <?php } ?>
                            </td>
                            
                            <td>
                            <?php if($schedule->reviewer_action == 1){ ?>
                                    <button class="btn btn-success" type="button">Approved <i class="fas fa-check-circle"></i></button></td>
                                <?php } elseif($schedule->reviewer_action == 2){?>
                                    <button class="btn btn-warning" type="button"><i class="fas fa-info-circle"></i></button></td>
                                <?php }elseif($schedule->reviewer_action == 3){?>
                                    <button class="btn btn-danger" type="button">Rejected <i class="fas fa-times-circle"></i></button>
                                <?php }else{?>
                                    Pending
                               <?php } ?>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
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