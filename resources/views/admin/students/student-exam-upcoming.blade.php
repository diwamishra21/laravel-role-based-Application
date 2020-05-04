@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12" style="font-size: 17px;font-weight: bold;">
        Upcoming exams
    </div>

    @if(Session::has('success_message'))
    <div class="alert alert-block alert-success" style="width: 50%;margin: 0 auto;margin-top: -45px;">
        <i class=" fa fa-check cool-green "></i>
        {{ nl2br(Session::get('success_message')) }}
    </div>
    @endif
    @if(Session::has('alert_message'))
    <div class="alert alert-block alert-error" style="width: 50%;margin: 0 auto;margin-top: -45px; color:red">
        <i class=" fa fa-check red "></i>
        {{ nl2br(Session::get('alert_message')) }}
    </div>
    @endif
</div>
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{url('')}}/admin/register-exam"> Register for an Exam
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th></th>
                        <th>Subject</th>
                        <th>Exam Datetime</th>
                        <th>Registered On</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datalist as $key => $schedule)
                    <?php $i=1;?>
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
                            {{ $schedule->created ?? '' }}
                        </td>
                        <td>
                            <?php if ($schedule->active_status == 1) { ?>
                                <span class="badge badge-success">Active</span>
                            <?php } else { ?>
                                <span class="badge badge-secondary">In-active</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="{{url('')}}/admin/delete-student-scheduled-exam/{{$schedule->id}}" onclick="return confirm('Are you sure?')"><button class="btn btn-danger" type="button">Delete</button></a>
                            <?php
                            if ($schedule->start_time <= date("Y-m-d H:i:s") && $schedule->end_time > date("Y-m-d H:i:s")) { ?>
                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Attend</button>
                            <?php } ?>
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
                                        <form action="{{url('')}}/admin/create-exam-details" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <hr>
                                            Student Verification process<br>
                                            <hr>
                                            Room invigilation process
                                            <hr>
                                            <br>
                                            Feedback-
                                            <textarea name="student_feedback">Provide your feedback here</textarea>
                                            <input type="hidden" name="schedule_id_{{$i}}" value="{{$schedule->schedule_id}}" />
                                            <input type="hidden" name="student_id_{{$i}}" value="{{$schedule->student_id}}" />
                                            <input type="hidden" name="subject_id_{{$i}}" value="{{$schedule->subject_id}}" />
                                            <div>
                                                <input class="btn btn-danger" type="submit" value="Submit Exam_{{$i}}">
                                            </div>
                                        </form>
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
                    <?php $i++;?>
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
    $(function() {
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
            order: [
                [1, 'desc']
            ],
            pageLength: 100,
        });
        $('.datatable-Role:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection