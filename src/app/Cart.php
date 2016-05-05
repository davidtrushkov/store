<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    /**
     * @var string
     */
    protected $table = 'carts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'qty', 'total',
    ];


    /**
     * A Product belongs to a Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Products() {
        return $this->belongsTo('App\Product', 'product_id');
    }


    /**
     * A Cart belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User() {
        return $this->belongsTo('App\User', 'user_id');
    }

}