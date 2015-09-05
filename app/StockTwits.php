<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTwits extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    // Get the max stock ID for a specified symbol
    public function scopeMax($query, $symbol) {
        return $query->where(
            'symbol',
            $symbol
        )->max('stock_id');
    }
}
