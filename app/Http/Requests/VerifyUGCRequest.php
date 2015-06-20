<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class VerifyUGCRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'our_team_link' => 'required|url|regex:/^http:\/\/www\.ugcleague\.com\/team_page\.cfm\?clan_id=\d+$/',
            'their_team_link' => 'required|url|regex:/^http:\/\/www\.ugcleague\.com\/team_page\.cfm\?clan_id=\d+$/',
            'status_text' => 'required'
		];
	}

}
