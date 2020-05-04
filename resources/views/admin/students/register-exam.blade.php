@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
    <a class="btn btn-primary" href="{{url('')}}/admin/student-exam-upcoming"> Go Back
        </a>
    </div>
</div>
<div class="card">
<div class="card-header" style="font-size: 17px;font-weight: bold;">
        Register for an exam
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="  table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Created</th>
                    <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($datalist as $key => $schedule)
                        <tr data-entry-id="{{ $schedule->id }}">
                            <td>
                               
                            </td>
                            <td>
                                {{ $schedule->id ?? '' }}
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
                                {{ $schedule->created ?? '' }}
                            </td>
                            <td><a href="{{url('')}}/admin/register-student-exam/{{$schedule->id}}" onclick="return confirm('Are you sure?')"><button class="btn btn-success" type="button">Register</button></a>
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
  /*let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
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
  dtButtons.push(deleteButton)*/

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