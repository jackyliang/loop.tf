<?php
namespace App\Services\Schedulizer;
require_once('Course.php');

/**
 * This class is in charge of generating the schedules based on an input of
 * classes
 * Class Generate
 * @package App\Services\Schedulizer
 */
class Generate {
    public function __construct() {

    }

    /**
     * Generates all possible combinations of different classes
     * @param $course_1
     * @param $course_combos
     * @param $limit
     * @param $zones
     * @return array
     */
    public function multiply($course_1, $course_combos, $limit, $zones) {
        $combined = array();
        $new_combos = array();
        $count = 0;
        #if 2-D array course_combos is empty fill it up with the
        #array course_1 making each element an array of its own
        if (empty($course_combos)) {
            for ($i = 0; $i < count($course_1); $i = $i + 1) {
                if ($this->compareDays($limit, $course_1[$i]->days) == false)
                    if ($this->checkTimezoneOverlap($course_1[$i], $zones) == false)
                        array_push($new_combos, array($course_1[$i]));
            }
            $count = 1;
        } else {
            for ($i = 0; $i < count($course_combos); $i = $i + 1) {
                for ($j = 0; $j < count($course_1); $j = $j + 1) {
                    #If there is no overlap between elements in the array
                    #and the new element push it into the array
                    if ($this->overlap($course_combos[$i], $course_1[$j]) == false) {
                        if ($this->compareDays($limit, $course_1[$j]->days) == false) {
                            if ($this->checkTimezoneOverlap($course_1[$j], $zones) == false) {
                                array_push($new_combos, $course_combos[$i]);
                                array_push($new_combos[$count], $course_1[$j]);
                                $count = $count + 1;
                            }
                        }
                    }
                }
            }
        }
        if ($count != 0) {
            return $new_combos;
        }
        else {
            return $course_combos;
        }
    }

    /**
     * Check whether classes fall into a particular timezone
     * @param $course
     * @param $zone
     * @return bool
     */
    public function checkTimezoneOverlap($course, $zone) {
        if ($course->times == "") {
            return false;
        }
        $start1 = $this->convert(explode(" - ", $course->times)[0]);
        $end1 = $this->convert(explode(" - ", $course->times)[1]);
        // Documentation for the time zones
        // M - morning
        // A - afternoon
        // N - night
        if ($zone == "M") {
            $start2 = 1200;
            $end2 = 2400;
            return $this->timeOverlap($start1, $end1, $start2, $end2);
        } elseif ($zone == "AN") {
            $start2 = 800;
            $end2 = 1150;
            return $this->timeOverlap($start1, $end1, $start2, $end2);
        } elseif ($zone == "N") {
            $start2 = 800;
            $end2 = 1750;
            return $this->timeOverlap($start1, $end1, $start2, $end2);
        } elseif ($zone == "MN") {
            $start2 = 1200;
            $end2 = 1750;
            return $this->timeOverlap($start1, $end1, $start2, $end2);
        } elseif ($zone == "MA") {
            $start2 = 1800;
            $end2 = 2400;
            return $this->timeOverlap($start1, $end1, $start2, $end2);
        } elseif ($zone == "A") {
            $start2 = 800;
            $end2 = 1150;
            $start3 = 1800;
            $end3 = 2400;
            if ($this->timeOverlap($start1, $end1, $start2, $end2) == false) {
                if (($this->timeOverlap($start1, $end1, $start3, $end3) == false)) {
                    return false;
                }
                else {
                    return true;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Converts time to military time
     * @param $time12hour
     * @return int
     */
    public function convert($time12hour) {
        $tail = substr($time12hour, -2);
        $time12hour = substr($time12hour, 0, count($time12hour) - 3);
        $minutes = intval(explode(":", $time12hour)[1]);
        $hour = 100 * intval(explode(":", $time12hour)[0]);
        if (($tail == "am" && $hour != 1200) || ($tail == "pm" && $hour == 1200))
            $time = $hour + $minutes;
        else
            $time = $hour + $minutes + 1200;
        return $time;
    }

    /**
     * Compares days to see if there are any overlapping days
     * @param $str1
     * @param $str2
     * @return bool
     */
    public function compareDays($str1, $str2) {
        if ($str1 == "TBD" || $str2 == "TBD") {
            return false;
        }
        $len1 = strlen($str1);
        $len2 = strlen($str2);
        for ($i = 0; $i < $len1; $i = $i + 1) {
            for ($j = 0; $j < $len2; $j = $j + 1) {
                if ($str1[$i] == $str2[$j]) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checks if the times in military time overlaps
     * @param $start1
     * @param $end1
     * @param $start2
     * @param $end2
     * @return bool
     */
    public function timeOverlap($start1, $end1, $start2, $end2) {
        if ($start1 == $start2 || $end1 == $end2)
            return true;
        elseif (($start1 < $start2 && $start2 < $end1) || ($start1 < $end2
                && $end2 < $end1)
        )
            return true;
        elseif (($start2 < $start1 && $start1 < $end2) || ($start2 < $end1
                && $end1 < $end2)
        )
            return true;
        elseif (($start1 < $start2 && $end2 < $end1) || ($start2 < $start1
                && $end1 < $end2)
        )
            return true;
        else
            return false;
    }

    /**
     * Checks if an array of classes, and the new class that is about to be
     * added in overlap at all
     * @param $courses
     * @param $course_temp
     * @return bool
     */
    public function overlap($courses, $course_temp) {
        for ($i = 0; $i < count($courses); $i = $i + 1) {
            if ($this->overlapCourses($courses[$i], $course_temp) == true) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if two courses overlap
     * @param $course1
     * @param $course2
     * @return bool
     */
    public function overlapCourses($course1, $course2) {
        if ($this->compareDays($course1->days, $course2->days) == false)
            return false;
        else {
            $start1 = $this->convert(explode(" - ", $course1->times)[0]);
            $start2 = $this->convert(explode(" - ", $course2->times)[0]);
            $end1 = $this->convert(explode(" - ", $course1->times)[1]);
            $end2 = $this->convert(explode(" - ", $course2->times)[1]);
            return $this->timeOverlap($start1, $end1, $start2, $end2);
        }
    }
}
