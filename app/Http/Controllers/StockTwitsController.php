<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\StockTwits\ParseStocks;
use Response;
use App\StockTwits;
use Exception;

use Illuminate\Http\Request;

class StockTwitsController extends Controller {

    public function search()
    {
        return view('schedulizer.search-spx');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function results()
	{
        $data = array();

        $symbol = 'SPX';
        $starting_id = 41888517; // Aug 8th 2015
          $ending_id = 42100000;

        $index = 0;

        try {
            while($starting_id < $ending_id) {
                if($index >= 0) {
                    break;
                }

                $AAPL = new ParseStocks(
                    $symbol,
                    $starting_id
                );
                $AAPL->load();
                $AAPL->parseMessages();
                array_push($data, $AAPL->getData());
                $starting_id = $AAPL->getMaxID();

                $index++;
            }
        } catch (Exception $e) {
            throw new Exception('You should see this: ' . $e);
        }

        return Response::json($data);
	}

    public function home() {
        return view('stocktwits.home');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
