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

    // view code
    Route::get('/box/codes/{code}', function($code){
        $box = getBox('code', $code)->first();
        abort_if(!hasValue($box), 403, 'Code is not valid');

        $isExpired = isCodeExpired($box);
        abort_if($isExpired, 403, 'Code is expired');

        return view('open_code', compact('box'));
    })->name('open_code');

    // open box
    Route::get('/food_box/open', function(){
        $values['isOpen'] = True;
        getBox('box_name', 'food_box')->update($values);

        return redirect()->back();
    });
    Route::get('/delivery_box/open', function(){
        $values['isOpen'] = True;
        getBox('box_name', 'delivery_box')->update($values);

        return redirect()->back();
    });
});

// Raspberry Pi
Route::get('/food_box/isBoxOpen', function(){
    return getBox('box_name', 'food_box')->first()->isOpen;
});
Route::get('/delivery_box/isBoxOpen', function(){
    return getBox('box_name', 'delivery_box')->first()->isOpen;
});

Route::get('/checkCode/{code}', function($code){
    $box = getBox('code', $code)->first();
    if(hasValue($box) && !isCodeExpired($box))
    {
        return $box->box_name;
    }
    else
    {
        return '';
    }
});

// close box
Route::get('/food_box/close', function(){
    $values['isOpen'] = False;
    getBox('box_name', 'food_box')->update($values);

    return redirect()->back();
});
Route::get('/delivery_box/close', function(){
    $values['isOpen'] = False;
    getBox('box_name', 'delivery_box')->update($values);

    return redirect()->back();
});