<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\DrexelClass;
use DB;
use Input;
use Response;

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

        return view('schedulizer.results', compact('classesByLabelAndType', 'term', 'classCount'));
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
