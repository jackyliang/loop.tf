<?php
namespace App\Services\StockTwits;
/**
 * Parses the StockTwits ticker API
 */

class ParseStocks {

    // The StockTwits ticker API URL
    private $url;

    // Used to store the JSON/string data
    private $data;

    /**
     * Generate the URL
     * @param $ticker The ticker you want, i.e. AAPL
     * @param $id     The starting index, i.e. 41000000
     */
    public function __construct($ticker, $id) {
        // The StockTwits ticker API URL
        $this->url = 'https://api.stocktwits.com/api/2/streams/symbol/' . $ticker . '.json?id=' . $id;

    }

    /**
     * Get content and save it
     */
    public function load() {
        //read the json file contents
        $jsondata = file_get_contents($this->url);

        //convert json object to php associative array
        $this->data = json_decode($jsondata, true);
    }

    public function parseMessages() {
    }

    public function getData(){
        return $this->data['messages'];
    }

    public function getURL(){
        return $this->url;
    }
}