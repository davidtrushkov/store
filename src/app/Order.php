<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * @var string
     */
    protected $table = 'orders';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'address_2',
        'city',
        'state',
        'zip',
        'total',
        'full_name',
    ];


    /**
     * An Order can have many products
     *
     * @return $this
     */
    public function orderItems() {
        return $this->belongsToMany('App\Product')->withPivot('qty', 'price', 'reduced_price', 'total', 'total_reduced');
    }

}