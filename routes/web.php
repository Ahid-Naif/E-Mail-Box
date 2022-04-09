<?php
require __DIR__.'/auth.php';
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/', function () {
        $food_box = getBox('box_name', 'food_box')->first();
        $delivery_box = getBox('box_name', 'delivery_box')->first();

        return view('dashboard', compact('food_box', 'delivery_box'));
    })->name('dashboard');

    // Genrate code
    Route::post('/food_box/generate_code', function () {
        $values['code'] = rand(1000, 9999);
        $values['mobile_number'] = '+966' . substr(request('mobile_number'), 1, 9);
        $values['isCodeUsed'] = false;
        $values['updated_at'] = \Carbon\Carbon::now();

        getBox('box_name', 'food_box')->update($values);
        
        $mobile_number = $values['mobile_number'];
        $message = 'Scan code in url ' . route('open_code', $values['code']);
        sendSMSMessage($mobile_number, $message);

        return redirect()->back();
    });   
    Route::post('/delivery_box/generate_code', function () {
        $values['code'] = rand(1000, 9999);
        $values['mobile_number'] = '+966' . substr(request('mobile_number'), 1, 9);
        $values['isCodeUsed'] = false;
        $values['updated_at'] = \Carbon\Carbon::now();

        getBox('box_name', 'delivery_box')->update($values);
        $mobile_number = $values['mobile_number'];
        $message = 'Scan code in url ' . route('open_code', $values['code']);
        sendSMSMessage($mobile_number, $message);

        return redirect()->back();
    });

    // open code
    Route::get('/box/codes/{code}', function($code){
        $box = getBox('code', $code)->first();
        abort_if(!hasValue($box), 403, 'Code is not valid');

        $isExpired = isCodeExpired($box);
        abort_if($isExpired, 403, 'Code is expired');

        return view('open_code', compact('box'));
    })->name('open_code');

    // open box
    Route::get('/food_box/open', function(){
        // get delivery box information
        $box = DeliveryTrip::where('id', '1')->first();

        $attributes['isBoxOpen'] = True;
        
        $box->update($attributes);

        return redirect()->back();
    });
    Route::get('/delivery_box/open', function(){
        // get delivery box information
        $box = DeliveryTrip::where('id', '1')->first();

        $attributes['isBoxOpen'] = True;
        
        $box->update($attributes);

        return redirect()->back();
    });
});

// Raspberry Pi
Route::get('/food_box/isBoxOpen', function(){
    // get delivery box information
    $box = DeliveryTrip::where('id', '1')->first();

    return $box['isBoxOpen'];
});
Route::get('/delivery_box/isBoxOpen', function(){
    // get delivery box information
    $box = DeliveryTrip::where('id', '1')->first();

    return $box['isBoxOpen'];
});

Route::get('/food_box/checkCode', function(){
    // get delivery box information
    $box = DeliveryTrip::where('id', '1')->first();
    
    return $box['box_code'];
});
Route::get('/delivery_box/checkCode', function(){
    // get delivery box information
    $box = DeliveryTrip::where('id', '1')->first();
    
    return $box['box_code'];
});

// open box from raspberry pi
Route::get('/food_box/remote_open_box', function(){
    // get delivery box information
    $box = DeliveryTrip::where('id', '1')->first();
    $attributes['isBoxOpen'] = True;

    $box->update($attributes);

    return redirect()->back();
});
Route::get('/delivery_box/remote_open_box', function(){
    // get delivery box information
    $box = DeliveryTrip::where('id', '1')->first();
    $attributes['isBoxOpen'] = True;

    $box->update($attributes);

    return redirect()->back();
});