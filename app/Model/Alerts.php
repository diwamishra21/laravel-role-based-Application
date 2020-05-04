<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
    public $timestamps = false;
    protected $table = 'alerts';
    protected $fillable = [
        'alerts',
    ];

    //proctorAlertNewData
    public static function proctorAlertNewData()
    {   
        $results = Alerts::from("alerts as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title", "t5.type")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->join("alert_type AS t5", "t1.alert_type", "=", "t5.id")
            ->Where('t1.viewed_by_proctor', '=', 0)
            ->Where('t1.status', '=', 1)
            ->get();
        return $results;
    }

    // proctorAlertHistoryData
    public static function proctorAlertHistoryData()
    {   
        $results = Alerts::from("alerts as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title", "t5.type")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->join("alert_type AS t5", "t1.alert_type", "=", "t5.id")
            ->Where('t1.status', '=', 1)
            ->Where('t1.viewed_by_proctor', '=', 1)
            ->get();
        return $results;
    }

    //studentAlertNewData
    public static function studentAlertNewData($user_id)
    {   
        $results = Alerts::from("alerts as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title", "t5.type")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->join("alert_type AS t5", "t1.alert_type", "=", "t5.id")
            ->Where('t1.viewed_by_student', '=', 0)
            ->Where('t1.status', '=', 1)
            ->Where('t1.student_id', '=', $user_id)
            ->get();
        return $results;
    }

    // studentAlertHistoryData
    public static function studentAlertHistoryData($user_id)
    {   
        $results = Alerts::from("alerts as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title", "t5.type")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->join("alert_type AS t5", "t1.alert_type", "=", "t5.id")
            ->Where('t1.status', '=', 1)
            ->Where('t1.viewed_by_student', '=', 1)
            ->Where('t1.student_id', '=', $user_id)
            ->get();
        return $results;
    }

    

}
