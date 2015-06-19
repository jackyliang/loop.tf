<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Verify;

use Illuminate\Http\Request;

class UGCController extends Controller {

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
        $ourTeamURL = 'http://www.ugcleague.com/team_page.cfm?clan_id=8838';
        $theirTeamURL = 'http://www.ugcleague.com/team_page.cfm?clan_id=9831';
        $sampleStatus = 'Type `status` into your console and paste it here';

		return view('verify.verify', compact('ourTeamURL', 'theirTeamURL', 'sampleStatus'));
	}

    public function verify(Requests\VerifyUGCRequest $request)
    {
        $ourTeamURL = $request->input('our_team_link');
        $theirTeamURL = $request->input('their_team_link');

        $verify = new Verify($ourTeamURL, $theirTeamURL);
        $ourTeamList = $verify->getOurTeam();

        return $ourTeamList;
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
