<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use Auth;
use DB;
use App\Model\StudentExamReg;
use App\Model\Schedule;
use App\Model\ExamDetails;


class StudentsController extends Controller
{
    /**
     * Display a listing of Exams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }

        //$roles = Role::all('student');

        //return view('admin.exams.index', compact('roles'));
        return view('admin.exams.index');
    }


    /**
     * Display scheduled Exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerExam()
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }
        $user = Auth::user();
        $user_id = $user->id;
        $datalist = Schedule::scheduleListStudent($user_id);
        //print($datalist);die;
        return view('admin.students.register-exam', compact('datalist'));
        //return view('admin.proctors.live_exam');
    }

    //registerStudentExam
    public function registerStudentExam($id)
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }
        $user = Auth::user();
        $user_id = $user->id;

        $scheduleData = Schedule::scheduleDataByID($id);
        $schedule_id = $scheduleData['id'];
        $subject_id = $scheduleData['subject_id'];

        $StudentExamRegObj =  new StudentExamReg();
        $StudentExamRegObj->student_id  = $user_id;
        $StudentExamRegObj->subject_id  = $subject_id;
        $StudentExamRegObj->schedule_id  = $schedule_id;
        $StudentExamRegObj->created = date('Y-m-d H:i:s');
        $StudentExamRegObj->modified = date('Y-m-d H:i:s');
        $StudentExamRegObj->save();

        return redirect('admin/student-exam-upcoming')->with("success_message","You have been registered successfully");
    }

    //deleteScheduledExam
    public function deleteStudentScheduledExam($id)
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }
        DB::table('student_exam_registration')->delete($id);

        return redirect('admin/student-exam-upcoming')->with("alert_message","Registration has been deleted successfully");
    }


    /**
     * Display attend exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function attendExam()
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }

        //$roles = Role::all('student');

        //return view('admin.exams.index', compact('roles'));
        return view('admin.students.attend-exam');
    }




    /**
     * Display attend exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentExamUpcoming()
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }
        $user = Auth::user();
        $user_id = $user->id;

        $datalist = StudentExamReg::studentExamUpcomingData($user_id);
        
        return view('admin.students.student-exam-upcoming', compact('datalist'));
    }

    /**
     * Display attend exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function createExaDetails(Request $request)
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }
        if ($request->isMethod('post')) {
            $examDetailsObj =  new ExamDetails();
            $examDetailsObj->subject_id  = request('subject_id');
            $examDetailsObj->schedule_id  = request('schedule_id');
            $examDetailsObj->student_id  = request('student_id');
            $examDetailsObj->student_feedback  = request('student_feedback');
            $examDetailsObj->created = date('Y-m-d H:i:s');
            $examDetailsObj->modified = date('Y-m-d H:i:s');
            $examDetailsObj->save();

            //$datalist = Schedule::schedule_list();
            //return view('admin.proctors.scheduled_exam', compact('datalist'));
            return redirect('admin/student-exam-upcoming')->with("success_message","Exam feedback has been submitted successfully");
        }
    }


    /**
     * Display attend exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentExamHistory()
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }

        $user = Auth::user();
        $user_id = $user->id;

        $datalist = StudentExamReg::studentExamHistoryData($user_id);
        
        return view('admin.students.student-exam-history', compact('datalist'));
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
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $role = Role::create($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->givePermissionTo($permissions);

        return redirect()->route('admin.roles.index');
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
