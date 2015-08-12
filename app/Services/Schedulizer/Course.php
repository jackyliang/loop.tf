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

    public function __construct($name, $days, $times, $crn) {
        $this->name = $name;
        $this->days = $days;
        $this->times = $times;
        $this->crn = $crn;
    }

    public function print_course() {
        echo "Name:$this->name\n";
        echo "Days:$this->days\n";
        echo "Times:$this->times\n";
        echo "CRN:$this->crn\n";
        echo "------------------------------\n";
    }
}