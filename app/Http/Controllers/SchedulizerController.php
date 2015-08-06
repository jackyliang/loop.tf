<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\DrexelClass;
use App\DrexelClassURL;
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

        // Remove the item [if exists]
        if(Session::has('class')) {
            foreach(Session::get('class') as $class) {
                if($data['class'] === $class) {
                    // TODO: This removes all items in cart.
                    Session::forget('class', $data['class']);
                    return Response::json(array(
                            'success' => true,
                            'code' => 1,
                            'message' => $data['class'] . ' removed from cart'
                        )
                    );
                }
            }
        }

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

        echo json_encode(Session::get('class'));

        $classesByLabelAndType = [];
        foreach ($classes as $class) {
            // Remove extraneous HTML markup from DB
            $class['pre_reqs'] = str_replace('</span><span>', '', $class['pre_reqs']);

            // Header is the something like "ECE 201 Digital Logic"
            $label = $class['subject_code'] . " " . $class['course_no'] . " " . $class['course_title'];

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
