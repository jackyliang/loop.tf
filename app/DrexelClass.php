<?php namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Instruction Type Constants
 * These are the instruction-type strings used by TMS to categorize
 * each type of class. The four main ones are below.
 * Last modified: July 14 2015
 */
define('LECTURE', 'Lecture');
define('LAB', 'Lab');
define('RECITATION', 'Recitation/Discussion');
define('LECTURE_AND_LAB', 'Lecture & Lab');


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
     * @return mixed       A list of labs of the class
     */
    public function scopeLabsByClass($query, $subjectCode, $courseNo) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ->where('course_no', 'like', $courseNo)
            ->where('instr_type', 'like', LAB)
            ;
    }

    /**
     * Get all recitations of a class
     * @param $query
     * @param $subjectCode Course subject code i.e. "PHYS"
     * @param $courseNo    Course # i.e. "101" or "%" for everything
     * @return mixed       A list of recitations of the class
     */
    public function scopeRecitationsByClass($query, $subjectCode, $courseNo) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ->where('course_no', 'like', $courseNo)
            ->where('instr_type', 'like', RECITATION)
            ;
    }

    /**
     * Get all "lecture & labs" of a class
     * @param $query
     * @param $subjectCode Course subject code i.e. "PHYS"
     * @param $courseNo    Course # i.e. "101" or "%" for everything
     * @return mixed       A list of "lecture & labs" of the class
     */
    public function scopeLectureAndLabByClass($query, $subjectCode, $courseNo) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ->where('course_no', 'like', $courseNo)
            ->where('instr_type', 'like', LECTURE_AND_LAB)
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

    /**
     * Search for lab sectures
     * @param $query
     * @return mixed All of a classes' lab section
     */
    public function scopeLabs($query) {
        return $query
            ->where('instr_type', 'like', LAB)
            ;
    }
}
