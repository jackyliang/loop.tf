<?php
namespace App\Services\StockTwits;
use Exception;
/**
 * Parses the StockTwits ticker API
 */

class ParseStocks {

    // The StockTwits ticker API URL
    private $url;

    // Used to store the JSON/string data
    private $data;

    // The ticker used
    private $ticker;

    // The current StockTwits ID
    private $id;

    // An array of messages containing four keys of data of:
    // message, stock_id, created_at, and the ticker name
    private $message = array();

    /**
     * Generate the URL
     * @param $ticker The ticker you want, i.e. AAPL
     * @param $id     The starting index, i.e. 41000000
     */
    public function __construct($ticker, $id) {
        // The StockTwits ticker API URL
        $this->url = 'https://api.stocktwits.com/api/2/streams/symbol/' . $ticker . '.json?since=' . $id;
        $this->ticker = $ticker;
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

    // Parse each message and save them to a custom data structure
    public function parseMessages() {
        if(empty($this->data['messages'])) {
            throw new Exception('No messages found');
        }

        foreach($this->data['messages'] as $index => $item) {
            $this->message[$index]['message'] = $item['body'];
            $this->message[$index]['stock_id'] = $item['id'];
            $this->message[$index]['created_at'] = $item['created_at'];
            $this->message[$index]['ticker'] = $this->ticker;
        }
    }

    // Get max ID
    public function getMaxID() {
        return $this->message[0]['stock_id'];
    }

    public function getData() {
        return $this->message;
    }

    public function getURL() {
        return $this->url;
    }

    public function getBody(){
        return $this->body;
    }

    public function getStockID(){
        return $this->stock_id;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }
    public function getSymbol(){
        return $this->symbol;
    }
}