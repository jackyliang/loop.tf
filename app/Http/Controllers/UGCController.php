<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\Verify\Verify;

ini_set('display_errors', 'On');

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

        $popoverTitle = "<center>UGC Roster Verifier</center>";
        $popoverText = "
This simple tools allows anyone to <i>conveniently verify every individual on the
server</i> as long as you have both team's UGC profile URL and the Valve server
status outputs. <br><br>
Prior to each match, there are uncertainties as to the players whom you play
against are really the individuals they claim they are.<br><br>

The old fashioned way of verifying whether the opposing team's roster is to
exhaustively and manually checking each player's name against the team's UGC
profile page. <br><br>
This app saves 90% of your time prior to the match for 100% roster verification accuracy.

<br><br>(Warning: these statistics may be complete bullshit)
";

		return view(
            'verify.verify',
            compact(
                'ourTeamURL',
                'theirTeamURL',
                'sampleStatus',
                'popoverTitle',
                'popoverText'
        ));
	}

    /**
     * Display the results of UGC verification
     * @param Requests\VerifyUGCRequest $request
     * @return \Illuminate\View\View
     */
    public function verify(Requests\VerifyUGCRequest $request)
    {
        $ourTeamURL = $request->input('our_team_link');
        $theirTeamURL = $request->input('their_team_link');
        $status = $request->input('status_text');

        $verify = new Verify($ourTeamURL, $theirTeamURL, $status);

        $ourRosterName = $verify->getOurRosterName();
        $ourRosterSize = $verify->getOurRosterSize();
        $ourRosterURL = $verify->getOurRosterURL();
        $ourTeamProfile = $verify->getOurTeamProfile();

        $theirRosterName = $verify->getTheirRosterName();
        $theirRosterSize = $verify->getTheirRosterSize();
        $theirRosterURL = $verify->getTheirRosterURL();
        $theirTeamProfile = $verify->getTheirTeamProfile();

        $unrostered = $verify->getUnrosteredProfile();
        $unrosteredNumber = $verify->getUnrosteredSize();

        return view(
            'verify.verify_results',
            compact(
                'ourRosterName',
                'ourRosterSize',
                'ourRosterURL',
                'ourTeamProfile',
                'theirRosterName',
                'theirRosterSize',
                'theirRosterURL',
                'theirTeamProfile',
                'unrostered',
                'unrosteredNumber'
            )
        );
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
