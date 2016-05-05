<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';

    protected $fillable = ['category'];

  //protected $guarded = ['id'];


    /**
     * One sub category, belongs to a Main Category ( Or Parent Category ).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent() {
        return $this->belongsTo('App\Category', 'parent_id');
    }


    /**
     * A Parent Category has many sub categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany('App\Category', 'parent_id');
    }


    /**
     * One Category can have many Products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product() {
        return $this->hasMany('App\Product', 'id');
    }


    /**
     * Delete all sub categories when Main (Parent) category is deleted.
     */
    public static function boot() {
        // Reference the parent::boot() class.
        parent::boot();

       // Delete the parent and all of its children on delete.
        //static::deleted(function($category) {
        //    $category->parent()->delete();
        //    $category->children()->delete();
        //});

        Category::deleting(function($category) {
            foreach($category->children as $subcategory){
                $subcategory->delete();
            }
        });
    }


}