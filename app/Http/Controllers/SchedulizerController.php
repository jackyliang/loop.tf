<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\DrexelClass;
use App\DrexelClassURL;
use App\Services\Schedulizer\Generate;
use App\Services\Schedulizer\Course;
use DB;
use Input;
use Response;
use Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class SchedulizerController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    /**
     * This generates an array of time strings from 7 AM to midnight
     * @return array  A string array of time spans
     */
    public function time_span() {
        $timeIncrements = array();

        $tempMilTime = array();
        $tempStandardTime = array();

        $start = "07:00";
        $end = "24:00";

        $tStart = strtotime($start);
        $tEnd = strtotime($end);
        $tNow = $tStart;

        while($tNow <= $tEnd){
            array_push($tempMilTime, date("Hi", $tNow));
            array_push($tempStandardTime, date("h:i A",$tNow));

            $tNow = strtotime('+30 minutes',$tNow);
        }

        $timeIncrements = array_combine($tempMilTime, $tempStandardTime);

        return $timeIncrements;
    }

    public function schedule(Request $request) {
        // Generate the time span increments of 30 minutes
        $timeIncrements = $this->time_span();

        // TODO: Fix the `q` key for search queries
        $term = $request->input('q');

        return view('schedulizer.schedule', compact('timeIncrements', 'term'));
    }

    /**
     * Clear the cart
     */
    public function clear() {

        // Clear cart if there is stuff in it
        if(Session::has('class')) {
            Session::flush();
            return Response::json(array(
                    'success' => true,
                    'code' => 1,
                    'message' => 'Your cart has been cleared'
                )
            );
        }

        // Nothing in the cart
        return Response::json(array(
            'success' => true,
            'code' => 0,
            'message' => 'There is nothing in the cart to clear'
        ));
    }



    /**
     * Shows all the classes with their detailed information
     * TODO: Remove this test API
     * @return mixed
     */
    public function classes() {
        // The array of detailed course information that contains the CRN,
        // date, time, and name
        $listOfCourseInfo = array();

        // Get the selection of classes if there is stuff in it
        if(Session::has('class')) {
            $courseSelection = Session::get('class');
        } else {
            // Otherwise return this JSON
            return Response::json(array(
                    'success' => true,
                    'code' => 0,
                    'classes' => []
                )
            );
        }

        // Format the selection of classes so the class name
        // contains a header in the form of the full class name
        foreach($courseSelection as $course) {
            $class = DrexelClass::searchWithType($course)->get();

            // Assign the course name as the key to the section arrays
            $listOfCourseInfo[$course] = $class;
        }

        return Response::json(array(
                'success' => true,
                'code' => 1,
                'classes' => $listOfCourseInfo
            )
        );
    }

    /**
     * API to generate the classes based on what's in the session
     * Takes in put params of:
     * 'limit' - day of the week limits such as 'MWF'
     * 'tz'    - don't show classes within this time zone such as 'N'
     * @return mixed
     */
    public function generate(Request $request) {
        // Get all requests
        $data = $request->all();

        // Validate the inputs
        $validator = Validator::make($data, [
            'limit' => 'max:5|regex:/^[\pL\s]+$/u', // Alphabet only. Max 5 items
            'tz' => 'max:2|regex:/^[\pL\s]+$/u' // Alphabet only. Max 2 items
        ]);

        // Throw message if not validated
        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'code' => -1,
                'quantity' => 0,
                'classes' => [],
                'message' => 'Stop trying to test my API'
            ));
        }

        // Limit results to particular days
        // i.e. MWF for Monday Wednesday Friday
        $limit = '';
        if (Input::has('limit'))
        {
            $limit = Input::get('limit');
        }

        // Choose what timezones to have classes in ex (MA = Mornings and Afternoons)
        // If it doesn't matter leave it blank
        $zones = '';
        if (Input::has('tz'))
        {
            $zones = Input::get('tz');
        }

        // The array of detailed course information that contains the CRN,
        // date, time, and name
        $listOfCourseInfo = array();

        // Get the selection of classes if there is stuff in it
        if(Session::has('class')) {
            $courseSelection = Session::get('class');
        } else {
            // Otherwise return this JSON
            return Response::json(array(
                    'success' => true,
                    'code' => 0,
                    'quantity' => 0,
                    'classes' => [],
                    'message' => 'There are no classes in your cart'
                )
            );
        }

        // Format the selection of classes so the class name
        // contains a header in the form of the full class name
        foreach($courseSelection as $course) {
            $class = DrexelClass::searchWithType($course)->get();

            // Assign the course name as the key to the section arrays
            $listOfCourseInfo[$course] = $class;
        }

        // A list of classes is the total distribution of classes including
        // all its instruction types
        $list = array();
        foreach($listOfCourseInfo as $key => $courses) {
            // One section can contain multiple classes of the same instruction
            // type.
            $section = array();
            foreach($courses as $course) {
                // Create a new class with the name, day, time, and CRN
                $oneCourse = new Course($key, $course['day'], $course['time'], $course['crn']);

                // Push the class to the sections array
                array_push($section, $oneCourse);
            }
            array_push($list, $section);
        }

        #initialize the array which will contain arrays of possible class
        #combinations
        $listOfSchedules = array();

        $generate = new Generate();

        // Permutate and generate the classes
        for ($i = 0; $i < count($list); $i++) {
            $listOfSchedules = $generate->multiply($list[$i], $listOfSchedules, $limit, $zones);
        }

        // Number of schedules generated
        $numOfSchedules = count($listOfSchedules);

        return Response::json(array(
                'success' => true,
                'code' => 1,
                'quantity' => $numOfSchedules,
                'classes' => $listOfSchedules,
                'message' => $numOfSchedules . ($numOfSchedules === 1 ? ' schedule was generated' : ' schedules were generated')
            )
        );
    }

    /**
     * Get class content
     * Contains success code, quantity, and the classes array
     * @param Request $request
     * @return mixed
     */
    public function cart() {
        $count = count(Session::get('class'));

        // Get the number of classes
        if(Session::has('class')) {
            return Response::json(array(
                    'success' => true,
                    'quantity' => $count,
                    'classes' => Session::get('class'),
                    'message' => 'You have a total of ' . $count . ' classes!'
                )
            );
        }

        // Nothing in the cart
        return Response::json(array(
            'success' => true,
            'quantity' => 0,
            'classes' => array(),
            'message' => 'You have added no classes!'
        ));
    }

    /**
     * The remove class API
     * Code Definitions:
     * -1   A require key of 'class' in the request is missing.
     *  0   Class not found in the cart
     *  1   Successfully removed from cart
     * @param Request $request
     * @return mixed
     */
    public function remove(Request $request) {
        // Get all requests
        $data = $request->all();

        // Fields are required
        $validator = Validator::make($data, [
            'class' => 'required'
        ]);

        // Ensures there's an input
        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'code' => -1,
                'message' => 'Something went wrong and it shouldn\'t happen.'
            ));
        }

        // Remove the item from cart
        // 1. Check if `class` session key exists
        // 2. If so, get it, and loop through it
        // 3. If that particular index's element (a string) matches the input
        // string (from an AJAX request), unset it, and put the new unsetted
        // array back to the session
        if(Session::has('class')) {
            $classes = Session::get('class');
            foreach($classes as $index => $class) {
                if($data['class'] === $class) {
                    unset($classes[$index]);
                    // Re-index the array (pretty important)
                    $newClass = array_values($classes);
                    Session::put('class', $newClass);

                    return Response::json(array(
                            'success' => true,
                            'code' => 1,
                            'message' => $data['class'] . ' removed from cart'
                        )
                    );
                }
            }
        }

        // Item wasn't in the cart
        return Response::json(array(
            'success' => false,
            'code' => 0,
            'message' => $data['class'] . ' is not in the cart.'
        ));
    }

    /**
     * The add class API.
     * Code Definitions:
     * -1   A required key of 'class' in the request is missing
     *  0   Class already in the cart
     *  1   Successfully added to cart
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request) {
        // Get all requests
        $data = $request->all();

        // Fields are required
        $validator = Validator::make($data, [
            'class' => 'required'
        ]);

        // Ensures there's an input
        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'code' => -1,
                'message' => 'Something went wrong and it shouldn\'t happen.'
            ));
        }

        // Ensures no duplicate entries in the session
        if(Session::has('class')) {
            foreach(Session::get('class') as $class) {
                if($data['class'] === $class) {
                    return Response::json(array(
                            'success' => false,
                            'code' => 0,
                            'message' => $data['class'] . ' already in the cart'
                        )
                    );
                }
            }
        }

        // Push the class to the session
        Session::push('class', $data['class']);

        return Response::json(array(
            'success' => true,
            'code' => 1,
            'message'   => $data['class'] . ' successfully added to cart'
        ));
    }

    /**
     * Display the search page view
     * @return \Illuminate\View\View
     */
    public function search() {
        return view('schedulizer.search');
    }

	/**
	 * Gets all the subject code + course # + course titles for the
     * autocomplete engine in a JSON format
	 *
	 * @return Response
	 */
	public function autocomplete()
	{
        $results = array();

        $queries = DrexelClass::allCourseNo();

        foreach($queries as $query)
        {
            $results[] = [
                'value' => $query->subject_code . ' ' .
                           $query->course_no . ' ' .
                           $query->course_title . ' '
                ];
        }

        return Response::json($results);
	}

    /**
     * Determine the time elapsed string
     * Source: http://stackoverflow.com/a/18602474/1913389
     * @param $datetime  Any valid DateTime format
     * @param bool $full To use full string or not
     * @return string
     */
    public function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    /**
     * Display class search results
     * @return mixed
     */
    public function results(Requests\VerifySchedulizerSearch $request) {
        $term = $request->input('q');

        $classes = DrexelClass::search($term)
            ->orderBy('instr_type')
            ->orderBy('course_no')
            ->limit('100')
            ->get();

        // Set default last updated string
        $lastUpdated = "0 minutes ago";

        // If the classes array returns results,
        // then set the natural time string
        if(count($classes) >= 1) {
            // Get the first CRN's timestamp from the classes_url model
            $lastUpdatedRaw = DrexelClassURL::timestampOfCRN($classes[0]['crn'])->get();
            $lastUpdated = $lastUpdatedRaw[0]['timestamp'];

            // Get the natural elapsed date time string
            $lastUpdated = self::time_elapsed_string($lastUpdated, true);
        }

        $classesByLabelAndType = [];
        foreach ($classes as $class) {
            // Remove extraneous HTML markup from DB
            $class['pre_reqs'] = str_replace('</span><span>', '', $class['pre_reqs']);

            // Header is the something like "ECE 201 Digital Logic"
            $label = $class['subject_code'] . " " . $class['course_no'] . " " . $class['course_title'];

            // The term "CLOSED" is confusing, since Drexel's meaning for it
            // is actually just the class is full
            if($class['enroll'] === 'CLOSED') {
                $class['enroll'] = 'FULL';
            }

            // Sort by instruction type under main header
            $classesByLabelAndType[$label][$class['instr_type']][] = $class;
        }

        $classCount = count($classes);

        return view('schedulizer.results', compact('classesByLabelAndType', 'term', 'classCount', 'lastUpdated'));
    }

    public function home()
    {
        return view('pages.home_sched');
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
