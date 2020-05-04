<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class StudentExamReg extends Model
{
    public $timestamps = false;
    protected $table = 'student_exam_registration';
    protected $fillable = [
        'student_exam_registration',
    ];

    //studentExamUpcomingData
    public static function studentExamUpcomingData($user_id)
    {   
        $results = StudentExamReg::from("student_exam_registration as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->Where('t1.student_id', '=', $user_id)
            //->Where('t2.start_time', '>=', date("Y-m-d H:i:s"))
            ->Where('t2.end_time', '>', date("Y-m-d H:i:s"))
            ->get();
        return $results;
    }

    // studentExamHistoryData
    public static function studentExamHistoryData($user_id)
    {   
        $results = StudentExamReg::from("exam_details as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->Where('t1.student_id', '=', $user_id)
            ->get();
        return $results;
    }

    

}
