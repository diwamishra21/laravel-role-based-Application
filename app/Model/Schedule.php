<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $timestamps = false;
    protected $table = 'schedule';
    protected $fillable = [
        'schedule',
    ];


    // schedule list
    public static function schedule_list()
    {
        $results = Schedule::from("schedule as t1")
            ->select("t1.*", "t2.title")
            ->join("subjects AS t2", "t1.subject_id", "=", "t2.id")
            ->Where('t1.end_time', '>=', date("Y-m-d H:i:s"))
            ->get();
        return $results;
    }

    //scheduleListStudent
    public static function scheduleListStudent($user_id)
    {
        $results = Schedule::from("schedule as t1")
            ->select("t1.*", "t2.title")
            ->join("subjects AS t2", "t1.subject_id", "=", "t2.id")
            ->Where('t1.end_time', '>=', date("Y-m-d H:i:s"))
            ->whereNOTIn('t1.id',function($query){
                $query->select('schedule_id')->from('student_exam_registration');
             })
            ->get();
        return $results;
    }


    //scheduleDataByID
    public static function scheduleDataByID($id)
    {
        $results = Schedule::from("schedule as t1")
            ->select("t1.*")
            ->Where('t1.id', '=', $id)
            ->first();
        return $results;
    }
    
    

}
