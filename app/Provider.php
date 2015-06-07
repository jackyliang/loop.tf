<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {

    /**
     * No timestamps for a provider
     * @var bool
     */
	public $timestamps = false;

    /**
     * Fillable fields for a provider
     * @var array
     */
    protected $fillable = [
        'name',
        'copyright_email'
    ];

}
