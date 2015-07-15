<?php namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

define('LECTURE', 'Lecture');
define('LAB', 'Lab');


class DrexelClass extends Model {

	 /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'classes';

    /**
     * Get all lectures of a class
     * @param $query
     * @param $subjectCode Course subject code i.e. "PHYS"
     * @param $courseNo    Course # i.e. "101" or "%" for everything
     * @return mixed       A list of lectures of the class
     */
    public function scopeLecturesByClass($query, $subjectCode, $courseNo) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ->where('course_no', 'like', $courseNo)
            ->where('instr_type', 'like', LECTURE)
            ;
    }

    /**
     * Get all labs of a class
     * @param $query
     * @param $subjectCode Course subject code i.e. "PHYS"
     * @param $courseNo    Course # i.e. "101" or "%" for everything
     * @return mixed       A list of lectures of the class
     */
    public function scopeLabsByClass($query, $subjectCode, $courseNo) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ->where('course_no', 'like', $courseNo)
            ->where('instr_type', 'like', LAB)
            ;
    }

    /**
     * Search for course title or subject name
     * @param $query
     * @param $searchTerm Course Title or Subject Name i.e. "ECEC 355" or
     *                    "Digital Logic"
     * @return mixed
     */
    public function scopeSearch($query, $searchTerm) {
        return $query
            ->where('course_title', 'like', '%' . $searchTerm . '%')
            ->orWhere(DB::raw("subject_code || ' ' ||  course_no"),
                'like',
                '%' . $searchTerm . '%'
            )
            ->orWhere('instructor', 'like', '%' . $searchTerm . '%')
            ;
    }
}
