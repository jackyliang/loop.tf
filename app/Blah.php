<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

define('LECTURE', 'Lecture');
define('LAB', 'Lab');


class Blah extends Model {

	 /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'classes';

    /**
     * Search scope query
     *
     * @param string
     * @return QueryBuilder
     */
    public function scopeSearch($query, $searchTerm) {
        return $query
            ->where('course_title', 'like', "%" . $searchTerm . "%")
            // ->where('subject_code', 'like', "%" . $searchTerm . "%")
            // ->where('course_no', 'like', "%" . $searchTerm . "%")
            ;
    }

    /**
     * Get all classes by their subject code
     * @param $query
     * @param $searchTerm A subject code like "ECEC"
     * @return mixed
     */
    public function scopeSubjectCode($query, $subjectCode) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ;
    }

    /**
     * Get all lectures of a class
     *
     * @param $query
     * @param $subjectCode Course subject code i.e. "PHYS"
     * @param $courseNo    Course # i.e. "101" or "%" for everything
     * @return mixed       A list of lectures of the class
     */
    public function scopeSearchLecturesByClass($query, $subjectCode, $courseNo) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ->where('course_no', 'like', $courseNo)
            ->whereIn('instr_type', 'like', LECTURE)
            ;
    }

    /**
     * Get all labs of a class
     *
     * @param $query
     * @param $subjectCode Course subject code i.e. "PHYS"
     * @param $courseNo    Course # i.e. "101" or "%" for everything
     * @return mixed       A list of lectures of the class
     */
    public function scopeSearchLabsByClass($query, $subjectCode, $courseNo) {
        return $query
            ->where('subject_code', 'like', $subjectCode)
            ->where('course_no', 'like', $courseNo)
            ->whereIn('instr_type', 'like', LAB)
            ;
    }
}
