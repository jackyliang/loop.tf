<?php
namespace App\Services\Schedulizer;

/**
 * This class represents a class object which contains a name, day, time, and
 * CRN
 * Class Course
 * @package App\Services\Schedulizer
 */
class Course {

    public $name;
    public $days;
    public $times;
    public $crn;
    public $campus;
    public $enrollment;

    public function __construct($name, $days, $times, $crn, $campus, $full) {
        $this->name = $name;
        $this->days = $days;
        $this->times = $times;
        $this->crn = $crn;
        $this->campus = $campus;
        $this->enrollment = $full;
    }
}