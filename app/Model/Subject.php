<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;
    protected $table = 'subjects';
    protected $fillable = [
        'subjects',
    ];


    // subject list
    public static function subject_list()
    {
        $results = Schedule::from("subjects as t1")
            ->select("t1.id", "t1.title")
            ->Where('t1.status', '=', 1)
            ->get();
        return $results;
    }

}
