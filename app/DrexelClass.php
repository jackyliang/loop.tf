<?php namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Instruction Type Constants
 * These are the instruction-type strings used by TMS to categorize
 * each type of class. The five main ones are below.
 * Last modified: July 16 2015
 */
define('LECTURE', 'Lecture');
define('LAB', 'Lab');
define('RECITATION', 'Recitation/Discussion');
define('LECTURE_AND_LAB', 'Lecture & Lab');
define('LECTURE_AND_REC', 'Lecture & Recitation');


class DrexelClass extends Model {

	 /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'classes';

    /**
     * Search for course title or subject name
     * @param $query
     * @param $searchTerm Course Title or Subject Name i.e. "ECEC 355" or
     *                    "Digital Logic"
     * @return mixed
     */
    public function scopeSearch($query, $searchTerm) {
        return $query->where(function($query) use ($searchTerm) {
            $query
                ->where('course_title', 'like', '%' . $searchTerm . '%')
                ->orWhere(
                    DB::raw("subject_code || ' ' ||  course_no"),
                    'like',
                    '%' . $searchTerm . '%'
                )
                ->orWhere('instructor', 'like', '%' . $searchTerm . '%');
        });
    }

    /**
     * Search for lab sections
     * @param $query
     * @return mixed All of a classes' lab section
     */
    public function scopeLabs($query) {
        return $query
            ->where('instr_type', 'like', LAB)
            ;
    }

    /**
     * Search for lecture sections
     * @param $query
     * @return mixed All of a classes' lecture section
     */
    public function scopeLectures($query) {
        return $query
            ->where('instr_type', 'like', LECTURE)
            ;
    }

    /**
     * Search for recitation sections
     * @param $query
     * @return mixed All of a classes' recitations section
     */
    public function scopeRecitations($query) {
        return $query
            ->where('instr_type', 'like', RECITATION)
            ;
    }

    /**
     * Search for lab and lecture sections
     * @param $query
     * @return mixed All of a classes' lecture and lab section
     */
    public function scopeLectureAndLab($query) {
        return $query
            ->where('instr_type', 'like', LECTURE_AND_LAB)
            ;
    }

    /**
     * Search for lab and recitation sections
     * @param $query
     * @return mixed All of a classes' lecture and recitation section
     */
    public function scopeLectureAndRec($query) {
        return $query
            ->where('instr_type', 'like', LECTURE_AND_REC)
            ;
    }
}
