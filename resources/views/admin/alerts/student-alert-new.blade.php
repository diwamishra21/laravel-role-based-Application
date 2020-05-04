@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    
</div>
<div class="card">
    <div class="card-header">
        Proctor Alert New
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                    <th></th>
                    <th>Alert Type</th>
                    <th>Subject</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($datalist as $key => $schedule)
                        <tr data-entry-id="{{ $schedule->id }}">
                            <td>
                               
                            </td>
                            <td>
                                {{ $schedule->type ?? '' }}
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
                                {{ $schedule->description ?? '' }}
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