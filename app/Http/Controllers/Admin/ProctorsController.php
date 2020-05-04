<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use App\Model\ExamDetails;
use App\Model\Schedule;
use App\Model\Subject;
use DB;

class ProctorsController extends Controller
{
    /**
     * Display a listing of Exams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('invigilation_manage')) {
            return abort(401);
        }

        //$roles = Role::all('student');

        //return view('admin.exams.index', compact('roles'));
        return view('admin.exams.index');
    }


    /**
     * Display attedn exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function liveExam()
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }

        $datalist = ExamDetails::liveExamData();
        //print(date("Y-m-d H:i:s"));die;
        return view('admin.proctors.live_exam', compact('datalist'));
    }

    /**
     * Display scheduled Exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function scheduledExam()
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }

        $datalist = Schedule::schedule_list();
        //print($datalist);die;
        return view('admin.proctors.scheduled_exam', compact('datalist'));
        //return view('admin.proctors.live_exam');
    }
    

    /**
     * Display to be sign off.
     *
     * @return \Illuminate\Http\Response
     */
    public function toBeSignOff()
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }

        $datalist = ExamDetails::toBeSignOffListData();
        //print($datalist);die;
        return view('admin.proctors.to_be_sign_off', compact('datalist'));
    }
    

    /**
     * Display signed off.
     *
     * @return \Illuminate\Http\Response
     */
    public function signedOff()
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }

        $datalist = ExamDetails::signedOffListData();
        //print($datalist);die;
        return view('admin.proctors.signed_off', compact('datalist'));
        //return view('admin.proctors.live_exam');
    }

    /**
     * Display create exam form.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSchedule(Request $request)
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }
        if ($request->isMethod('post')) {
            $scheduleObj =  new Schedule();
            $scheduleObj->subject_id  = request('subject_id');
            $scheduleObj->start_time = date('Y-m-d H:i:s', strtotime(request('starttime')));
            $scheduleObj->end_time = date('Y-m-d H:i:s', strtotime(request('endtime')));
            $scheduleObj->created = date('Y-m-d H:i:s');
            $scheduleObj->modified = date('Y-m-d H:i:s');
            $scheduleObj->save();

            //$datalist = Schedule::schedule_list();
            //return view('admin.proctors.scheduled_exam', compact('datalist'));
            return redirect('admin/scheduled-exam')->with("success_message","Schedule has been created successfully");
    
        }else{
        $subjectlist = Subject::subject_list();
        return view('admin.proctors.create_schedule',  compact('subjectlist'));
        }
    }

    //editScheduledExam
    public function editScheduledExam($id)
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }
        $scheduleData = Schedule::scheduleDataByID($id);
        $subjectlist = Subject::subject_list();
        return view('admin.proctors.edit_schedule',  compact('subjectlist', 'scheduleData'));
    }


    /**
     * update exam form.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSchedule(Request $request)
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }
        if ($request->isMethod('post')) {
            $id	= request('id');
            DB::table('schedule')
                ->where('id', $id)
                ->update([
                    'subject_id' => request('subject_id'),
                    'start_time' => date('Y-m-d H:i:s', strtotime(request('starttime'))),
                    'end_time' => date('Y-m-d H:i:s', strtotime(request('endtime'))),
                    'modified' => date("Y-m-d H:i:s")
                    ]);
        }
        return redirect('admin/scheduled-exam')->with("success_message","Schedule has been updated successfully");

    }



    //deleteScheduledExam
    public function deleteScheduledExam($id)
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }
        DB::table('schedule')->delete($id);

        return redirect('admin/scheduled-exam')->with("alert_message","Schedule has been deleted successfully");
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $permissions = Permission::get()->pluck('name', 'name');

        return view('admin.roles.create', compact('permissions'));
    }

   


    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $permissions = Permission::get()->pluck('name', 'name');

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $role->update($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }


    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $role->delete();

        return redirect()->route('admin.roles.index');
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Role::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}
