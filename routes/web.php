<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Core\Models\Payment;
use App\Core\Models\Product;
use App\Core\Models\Provider;
use App\Core\Models\Transaction;
use App\Http\Middleware\AdminLoginMiddleware;
use Illuminate\Http\Request;

Route::get('/', 'Core\CheckOutController@showHome');

Route::get('/admin', 'Core\LoginController@showLayout');

Route::post('/admin/login', 'Core\LoginController@login');

Route::get('/admin/logout', 'Core\LoginController@logout');

Route::get('admin/dashboard', function () {
    return view('dashboard');
});

Route::get('/admin/provider', 'Core\ProviderController@providershow')->middleware(AdminLoginMiddleware::class);

Route::get('/admin/provider/new', 'Core\ProviderController@showNew')->middleware(AdminLoginMiddleware::class);

Route::post('/admin/createnewprovider', 'Core\ProviderController@provideradd')->middleware(AdminLoginMiddleware::class);

Route::delete('/admin/provider/delete/{provider}', 'Core\ProviderController@providerdelete')->middleware(AdminLoginMiddleware::class);

Route::get('/admin/provider/edit/{id}', 'Core\ProviderController@providerShowOne')->middleware(AdminLoginMiddleware::class);

Route::post('admin/provider/editprovider/{id}', 'Core\ProviderController@providerEdit')->middleware(AdminLoginMiddleware::class);

Route::get('admin/product', 'Core\ProductController@productShow')->middleware(AdminLoginMiddleware::class);

Route::get('admin/product/new', 'Core\ProductController@productShowNew')->middleware(AdminLoginMiddleware::class);

Route::post('admin/createnewproduct', 'Core\ProductController@productAdd')->middleware(AdminLoginMiddleware::class);

Route::delete('/admin/product/delete/{product}', 'Core\ProductController@productDelete')->middleware(AdminLoginMiddleware::class);

Route::get('admin/product/edit/{product_code}', 'Core\ProductController@productShowEdit')->middleware(AdminLoginMiddleware::class);

Route::post('admin/product/editproduct/{product_name}', 'Core\ProductController@productEdit')->middleware(AdminLoginMiddleware::class);

Route::get('product', 'Core\ProductController@getProductsByPhoneNumberAndType');

Route::get('/addtransaction', 'Core\CheckOutController@transactionCart');

Route::post('checkout/', 'Core\CheckOutController@checkOut');

Route::get('lacak', function(){
    $data['payment'] = Payment::all();
    return view('search', $data);
});

Route::get('status', function(Request $request){
    $payment = Payment::find($request->input('payment_id'));
    $data['transactions'] = $payment->transactions;
    $data['payment'] = $payment;
    return view('payment_status', $data);
});