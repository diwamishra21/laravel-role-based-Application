@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">

<div class="col-lg-12">
<a class="btn btn-primary" href="{{url('')}}/admin/scheduled-exam">Back</a>
    </div>
</div>
<div class="card">
    <div class="card-header" style="font-size: 17px;font-weight: bold;">
    Edit Schedule
    </div>

    <div class="card-body">
        <form action="{{url('')}}/admin/update-schedule" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Subject* &nbsp;&nbsp;&nbsp;</label>
                <select  name="subject_id" required>
                    <option value="">Select</option>
                    @foreach($subjectlist as $subject)
                    <option value="{{$subject->id}}"
                    @if($subject->id == $scheduleData->subject_id)
                    {{'selected="selected"'}}
                    @endif >{{$subject->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Start Time*</label>
                <input type="datetime-local" id="starttime" name="starttime" required>
            </div>

            <div class="form-group">
                <label for="name">End Time*&nbsp;</label>
                <input type="datetime-local" id="endtime" name="endtime" required>
            </div>

            <div>
                <input type="hidden" name="id" value="{{$scheduleData->id}}"/>
                <input class="btn btn-danger" type="submit" value="Update Schedule">
            </div>
        </form>
    </div>
</div>
@endsection