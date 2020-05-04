<?php
Route::redirect('/', 'admin/home');

Auth::routes(['register' => false]);

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::delete('permissions_mass_destroy', 'Admin\PermissionsController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', 'Admin\RolesController');
    Route::delete('roles_mass_destroy', 'Admin\RolesController@massDestroy')->name('roles.mass_destroy');
    Route::resource('users', 'Admin\UsersController');
    Route::delete('users_mass_destroy', 'Admin\UsersController@massDestroy')->name('users.mass_destroy');


    //for students
    Route::get('/student-exam-upcoming', 'Admin\StudentsController@studentExamUpcoming')->name('admin.students.student-exam-upcoming');
    Route::get('/student-exam-history', 'Admin\StudentsController@studentExamHistory')->name('admin.students.student-exam-history');
    Route::get('/student-alert-new', 'Admin\AlertsController@studentAlertNew')->name('admin.alerts.student-alert-new');
    Route::get('/student-alert-history', 'Admin\AlertsController@studentAlertHistory')->name('admin.alerts.student-alert-history');
    Route::get('/register-exam', 'Admin\StudentsController@registerExam')->name('admin.students.register_exam');
    //register-student-exam
    Route::group(['prefix'=>'register-student-exam'],function(){ 
        Route::get('/{id}',[
            'as' =>'admin.register_student_exam',
            'uses'=>'Admin\StudentsController@registerStudentExam'
        ]);
    });
    Route::group(['prefix'=>'delete-student-scheduled-exam'],function(){ 
        Route::get('/{id}',[
            'as' =>'admin.delete-student-scheduled-exam',
            'uses'=>'Admin\StudentsController@deleteStudentScheduledExam'
        ]);
    });
    Route::post('/create-exam-details', 'Admin\StudentsController@createExaDetails')->name('admin.students.create-exam-details');
    //
    
    
    //exam related routes for proctor and reviewer
    Route::get('/live-exam', 'Admin\ProctorsController@liveExam')->name('admin.students.live_exam');
    Route::get('/scheduled-exam', 'Admin\ProctorsController@scheduledExam')->name('admin.proctors.scheduled_exam');
    Route::get('/to-be-sign-off', 'Admin\ProctorsController@toBeSignOff')->name('admin.proctors.to_be_sign_off');
    Route::get('/signed-off', 'Admin\ProctorsController@signedOff')->name('admin.proctors.signed_off');
    Route::get('/create-schedule', 'Admin\ProctorsController@createSchedule')->name('admin.proctors.create_schedule');
    Route::post('/create-schedule', 'Admin\ProctorsController@createSchedule')->name('admin.proctors.create_schedule');
    # editasset Page
    Route::group(['prefix'=>'edit-scheduled-exam'],function(){ 
        Route::get('/{id}',[
            'as' =>'admin.edit_schedule',
            'uses'=>'Admin\ProctorsController@editScheduledExam'
        ]);
    });
    Route::group(['prefix'=>'delete-scheduled-exam'],function(){ 
        Route::get('/{id}',[
            'as' =>'admin.delete_schedule',
            'uses'=>'Admin\ProctorsController@deleteScheduledExam'
        ]);
    });
    Route::post('/update-schedule', 'Admin\ProctorsController@updateSchedule')->name('admin.proctors.update_schedule');

			
    

    // alert related routes for proctor and reviewer
    Route::get('/proctor-alert-new', 'Admin\AlertsController@proctorAlertNew')->name('admin.alerts.proctor-alert-new');
    Route::get('/proctor-alert-history', 'Admin\AlertsController@proctorAlertHistory')->name('admin.alerts.proctor-alert-history');
    
    
    
});