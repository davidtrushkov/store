<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']], function () {

    /** Get the Home Page **/
    Route::get('/', 'PagesController@index');

    /** Display Products by category Route **/
    Route::get('category/{id}','PagesController@displayProducts');

    /** Display Products by Brand Route **/
    Route::get('brand/{id}','PagesController@displayProductsByBrand');

    /** Route to post search results **/
    Route::post('/queries', [
        'uses' => '\App\Http\Controllers\QueryController@search',
        'as'   => 'queries.search',
    ]);

    /** Route to Products show page **/
    Route::get('product/{product_name}', [
        'uses' => '\App\Http\Controllers\ProductsController@show',
        'as'   => 'show.product',
    ]);

    /************************************** Order By Routes for Products By Category ***********************************/

    /** Route to sort products by price lowest */
    Route::get('category/{id}/price/lowest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsPriceLowest',
        'as'   => 'category.lowest',
    ]);

    /**Route to sort products by price highest */
    Route::get('category/{id}/price/highest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsPriceHighest',
        'as'   => 'category.highest',
    ]);


    /** Route to sort products by alphabetical A-Z */
    Route::get('category/{id}/alpha/highest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsAlphaHighest',
        'as'   => 'category.alpha.highest',
    ]);

    /**Route to sort products by alphabetical  Z-A */
    Route::get('category/{id}/alpha/lowest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsAlphaLowest',
        'as'   => 'category.alpha.lowest',
    ]);

    /**Route to sort products by alphabetical  Z-A */
    Route::get('category/{id}/newest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsNewest',
        'as'   => 'category.newest',
    ]);


    /************************************** Order By Routes for Products By Brand ***********************************/

    /** Route to sort products by price lowest */
    Route::get('brand/{id}/price/lowest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsPriceLowestBrand',
        'as'   => 'brand.lowest',
    ]);

    /**Route to sort products by price highest */
    Route::get('brand/{id}/price/highest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsPriceHighestBrand',
        'as'   => 'brand.highest',
    ]);


    /** Route to sort products by alphabetical A-Z */
    Route::get('brand/{id}/alpha/highest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsAlphaHighestBrand',
        'as'   => 'brand.alpha.highest',
    ]);

    /**Route to sort products by alphabetical  Z-A */
    Route::get('brand/{id}/alpha/lowest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsAlphaLowestBrand',
        'as'   => 'brand.alpha.lowest',
    ]);

    /**Route to sort products by alphabetical  Z-A */
    Route::get('brand/{id}/newest', [
        'uses' => '\App\Http\Controllers\OrderByController@productsNewestBrand',
        'as'   => 'brand.newest',
    ]);


    /**************************************** Login & Registration Routes *********************************************/

    /** Return view for registration confirm token page ***/
    Route::get('register/confirm/{token}', 'AuthController@confirmEmail');

    Route::get('/register', [
        'uses' => '\App\Http\Controllers\AuthController@getRegister',
        'as'   => 'auth.register',
        'middleware' => ['guest']
    ]);

    Route::post('/register', [
        'uses' => '\App\Http\Controllers\AuthController@postRegister',
        'as'   => 'auth.register',
    ]);

    Route::get('/login', [
        'uses' => '\App\Http\Controllers\AuthController@getLogin',
        'as'   => 'auth.login',
        'middleware' => ['guest']
    ]);

    Route::post('/login', [
        'uses' => '\App\Http\Controllers\AuthController@postLogin',
        'as'   => 'auth.login',
        'middleware' => ['guest'],
    ]);

    Route::get('/logout', [
        'uses' => '\App\Http\Controllers\AuthController@logout',
        'as'   => 'auth.logout'
    ]);

    /**************************
     * Password Reset Routes
     *************************/
    Route::get('/password/email', '\App\Http\Controllers\PasswordController@getEmail');
    Route::post('/password/email', '\App\Http\Controllers\PasswordController@postEmail');
    Route::get('/password/reset/{token}', '\App\Http\Controllers\PasswordController@getReset');
    Route::post('/password/reset', '\App\Http\Controllers\PasswordController@postReset');


    /**************************************** Cart Routes *********************************************/
    
    
    /** Get the view for Cart Page **/
    Route::get('/cart', array(
        'before' => 'auth.basic',
        'as'     => 'cart',
        'uses'   => 'CartController@showCart'
    ));

    /** Add items in the cart **/
    Route::post('/cart/add', array(
        'before' => 'auth.basic',
        'uses'   => 'CartController@addCart'
    ));

    /** Update items in the cart **/
    Route::post('/cart/update', [
        'uses' => 'CartController@update'
    ]);

    /** Delete items in the cart **/
    Route::get('/cart/delete/{id}', array(
        'before' => 'auth.basic',
        'as'     => 'delete_book_from_cart',
        'uses'   => 'CartController@delete'
    ));


    /**************************************** Order Routes *********************************************/


    /** Get thew checkout view **/
    Route::get('/checkout', [
        'uses' => '\App\Http\Controllers\OrderController@index',
        'as'   => 'checkout',
        'middleware' => ['auth'],
    ]);


    /** Post an Order **/
    Route::post('/order',
        array(
            'before' => 'auth.basic',
            'as'     => 'order',
            'uses'   => 'OrderController@postOrder'
        ));


    /******************************************* User Profile Routes below ************************************************/


    /** Resource route for Profile **/
    Route::resource('profile', 'ProfileController');
    
});



Route::group(["middleware" => 'admin'], function(){

    /** Show the Admin Dashboard **/
   Route::get('admin/dashboard', [
       'uses' => '\App\Http\Controllers\AdminController@index',
       'as'   => 'admin.pages.index',
       'middleware' => ['auth'],
   ]);

    /** Show the Admin Categories **/
    Route::get('admin/categories', [
        'uses' => '\App\Http\Controllers\CategoriesController@showCategories',
        'as'   => 'admin.category.show',
        'middleware' => ['auth'],
    ]);

    /** Show the Admin Add Categories Page **/
    Route::get('admin/categories/add', [
        'uses' => '\App\Http\Controllers\CategoriesController@addCategories',
        'as'   => 'admin.category.add',
        'middleware' => ['auth'],
    ]);

    /** Post the Category Route **/
    Route::post('admin/categories/add', [
        'uses' => '\App\Http\Controllers\CategoriesController@addPostCategories',
        'as'   => 'admin.category.post',
        'middleware' => ['auth'],
    ]);

    /** Show the Admin Edit Categories Page **/
    Route::get('admin/categories/edit/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@editCategories',
        'as'   => 'admin.category.edit',
        'middleware' => ['auth'],
    ]);

    /** Show the Admin Update Categories Page **/
    Route::post('admin/categories/update/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@updateCategories',
        'as'   => 'admin.category.update',
        'middleware' => ['auth'],
    ]);

    /** Delete a category **/
    Route::delete('admin/categories/delete/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@deleteCategories',
        'as'   => 'admin.category.delete',
        'middleware' => ['auth'],
    ]);


    /****************************************Sub-Category Routes below ***********************************************/


    /** Show the Admin Add Sub-Categories Page **/
    Route::get('admin/categories/addsub/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@addSubCategories',
        'as'   => 'admin.category.addsub',
        'middleware' => ['auth'],
    ]);

    /** Post the Sub-Category Route **/
    Route::post('admin/categories/postsub/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@addPostSubCategories',
        'as'   => 'admin.category.postsub',
        'middleware' => ['auth'],
    ]);

    /** Show the Admin Edit Categories Page **/
    Route::get('admin/categories/editsub/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@editSubCategories',
        'as'   => 'admin.category.editsub',
        'middleware' => ['auth'],
    ]);

    /** Post the Sub-Category update Route**/
    Route::post('admin/categories/updatesub/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@updateSubCategories',
        'as'   => 'admin.category.updatesub',
        'middleware' => ['auth'],
    ]);


    /** Delete a sub-category **/
    Route::delete('admin/categories/deletesub/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@deleteSubCategories',
        'as'   => 'admin.category.deletesub',
        'middleware' => ['auth'],
    ]);


    /** Get all the products under a sub-category route **/
    Route::get('admin/categories/products/cat/{id}', [
        'uses' => '\App\Http\Controllers\CategoriesController@getProductsForSubCategory',
        'as'   => 'admin.category.products',
        'middleware' => ['auth'],
    ]);

    /** Route for the sub-category drop-down */
    Route::get('api/dropdown', 'ProductsController@categoryAPI');


    /******************************************* Products Routes below ************************************************/


    /** Show the Admin Products Page **/
    Route::get('admin/products', [
        'uses' => '\App\Http\Controllers\ProductsController@showProducts',
        'as'   => 'admin.product.show',
        'middleware' => ['auth'],
    ]);

    /** Show the Admin Add product Page **/
    Route::get('admin/product/add', [
        'uses' => '\App\Http\Controllers\ProductsController@addProduct',
        'as'   => 'admin.product.add',
        'middleware' => ['auth'],
    ]);


    /** Post the Add Product Route **/
    Route::post('admin/product/add', [
        'uses' => '\App\Http\Controllers\ProductsController@addPostProduct',
        'as'   => 'admin.product.post',
        'middleware' => ['auth'],
    ]);


    /** Get the Edit product Page **/
    Route::get('admin/product/edit/{id}', [
        'uses' => '\App\Http\Controllers\ProductsController@editProduct',
        'as'   => 'admin.product.edit',
        'middleware' => ['auth'],
    ]);

    /** Post the Admin Update Product Route **/
    Route::post('admin/product/update/{id}', [
        'uses' => '\App\Http\Controllers\ProductsController@updateProduct',
        'as'   => 'admin.product.update',
        'middleware' => ['auth'],
    ]);

    /** Delete a product **/
    Route::delete('admin/product/delete/{id}', [
        'uses' => '\App\Http\Controllers\ProductsController@deleteProduct',
        'as'   => 'admin.product.delete',
        'middleware' => ['auth'],
    ]);

    /** Get the Admin Upload Images Page **/
    Route::get('admin/products/{id}', [
        'uses' => '\App\Http\Controllers\ProductsController@displayImageUploadPage',
        'as'   => 'admin.product.upload',
        'middleware' => ['auth'],
    ]);

    /** Post a photo to a Product **/
    Route::post('admin/products/{id}/photo', 'ProductPhotosController@store');

    /** Delete Product photos **/
    Route::delete('admin/products/photos/{id}', 'ProductPhotosController@destroy');

    /** Post the Product Add Featured Image Route **/
    Route::post('admin/products/add/featured/{id}', 'ProductPhotosController@storeFeaturedPhoto');

    
    /******************************************* Brands Routes below ************************************************/

    
    /** Resource route for Admin Brand Actions **/
    Route::resource('admin/brands', 'BrandsController');

    /** Delete a Brand **/
    Route::delete('admin/brands/delete/{id}', [
        'uses' => '\App\Http\Controllers\BrandsController@delete',
        'as'   => 'admin.brand.delete',
        'middleware' => ['auth'],
    ]);

    /** Get all the products under a brand route **/
    Route::get('admin/brands/products/brand/{id}', [
        'uses' => '\App\Http\Controllers\BrandsController@getProductsForBrand',
        'as'   => 'admin.brand.products',
        'middleware' => ['auth'],
    ]);


    /** Delete a user **/
    Route::delete('admin/dashboard/delete/{id}', [
        'uses' => '\App\Http\Controllers\AdminController@delete',
        'as'   => 'admin.delete',
        'middleware' => ['auth'],
    ]);

    /** Delete a cart session **/
    Route::delete('admin/dashboard/cart/delete/{id}', [
        'uses' => '\App\Http\Controllers\AdminController@deleteCart',
        'as'   => 'admin.cart.delete',
        'middleware' => ['auth'],
    ]);


    /** Update quantity from prducts in Admin dashboard **/
    Route::post('/admin/update', [
        'uses' => 'AdminController@update'
    ]);

});

