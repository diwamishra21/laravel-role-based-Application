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
use App\Model\Alerts;

class AlertsController extends Controller
{
    /**
     * Display a listing of Exams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }
        return view('admin.exams.index');
    }


    /**
     * Display proctorAlertNew.
     *
     * @return \Illuminate\Http\Response
     */
    public function proctorAlertNew()
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }

        $datalist = Alerts::proctorAlertNewData();
        return view('admin.alerts.proctor-alert-new', compact('datalist'));
    }




    /**
     * Display attend exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function proctorAlertHistory()
    {
        if (! Gate::allows('invigilation_manage','reviewer')) {
            return abort(401);
        }

        $datalist = Alerts::proctorAlertHistoryData();
        return view('admin.alerts.proctor-alert-history', compact('datalist'));
    }


    
    /**
     * Display proctorAlertNew.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentAlertNew()
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }
        $user = Auth::user();
        $user_id = $user->id;

        $datalist = Alerts::studentAlertNewData($user_id);
        return view('admin.alerts.student-alert-new', compact('datalist'));
    }




    /**
     * Display attend exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentAlertHistory()
    {
        if (! Gate::allows('attend_exam')) {
            return abort(401);
        }
        $user = Auth::user();
        $user_id = $user->id;

        $datalist = Alerts::studentAlertHistoryData($user_id);
        return view('admin.alerts.student-alert-history', compact('datalist'));
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
