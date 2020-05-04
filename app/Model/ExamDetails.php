<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class ExamDetails extends Model
{
    public $timestamps = false;
    protected $table = 'exam_details';
    protected $fillable = [
        'exam_details',
    ];

    //liveExamData
    public static function liveExamData()
    {   
        $results = ExamDetails::from("exam_details as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            //->Where('t1.live_status', '=', 1)
            ->Where('t2.start_time', '<=', date("Y-m-d H:i:s"))
            ->Where('t2.end_time', '>=', date("Y-m-d H:i:s"))
            ->get();
        return $results;
    }

    // toBeSignOffList, not including live data
    public static function toBeSignOffListData()
    {   
        $results = ExamDetails::from("exam_details as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->Where('t1.sign_off_status', '=', 0)
            ->Where('t2.end_time', '<=', date("Y-m-d H:i:s"))
            ->get();
        return $results;
    }


    // Signed Off List
    public static function signedOffListData()
    {   
        $results = ExamDetails::from("exam_details as t1")
            ->select("t1.*", "t2.start_time","t2.end_time","t3.name","t4.title")
            ->join("schedule AS t2", "t1.schedule_id", "=", "t2.id")
            ->join("users AS t3", "t1.student_id", "=", "t3.id")
            ->join("subjects AS t4", "t1.subject_id", "=", "t4.id")
            ->Where('t1.sign_off_status', '=', 1)
            ->orderBy('t1.modified', 'desc')
            ->get();
        return $results;
    }

    

}
