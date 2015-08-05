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

    public function add(Request $request) {
        // Get all requests
        $data = $request->all();

        // Fields are required
        $validator = Validator::make($data, [
            'class' => 'required'
        ]);

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false
            ));
        }

        // TODO: check if item already exists in session, otherwise, throw
        // success: false, and a message

        Session::push('test', $data);

        $data = Session::get('test');

        return Response::json(array(
            'success' => true,
            'data'   => $data
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

        echo json_encode(Session::get('test'));

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
