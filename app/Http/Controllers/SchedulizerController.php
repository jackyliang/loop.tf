<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
        $term = \Input::get('term');

        $results = array();


        $queries = DB::table('classes')
            ->where('course_title', 'like', '%' . $term . '%')
            ->orWhere(
                DB::raw("subject_code || ' ' ||  course_no"),
                'like',
                '%' . $term . '%'
            )
            ->orWhere('instructor', 'like', '%' . $term . '%')
            ->take(5)->get();

        foreach($queries as $query)
        {
            $results[] = [
                'id' => $query->crn,
                'value' => $query->subject_code . '-' . $query->course_no . ' ' . $query->course_title ];
        }
        // return Response::json($results);
        return view(
            'schedulizer.search',
            compact(
                'results'
            ));
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
