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
        $food_box = \DB::table('boxes')->where('box_name', 'food_box')->first();
        $delivery_box = \DB::table('boxes')->where('box_name', 'delivery_box')->first();

        return view('dashboard', compact('food_box', 'delivery_box'));
    })->name('dashboard');

    // Genrate code
    Route::post('/food_box/generate_code', function () {
        $values['code'] = rand(1000, 9999);
        $values['mobile_number'] = '+966' . substr(request('mobile_number'), 1, 9);
        $values['isCodeUsed'] = false;

        \DB::table('boxes')->where('box_name', 'food_box')->update($values);
        
        $basic  = new \Vonage\Client\Credentials\Basic("43bd37db", "yhrY752gCCZmgbff");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($values['mobile_number'], 
                'EMail-Box', 
                'Scan code in url ' . route('open_code', $values['code']))
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

        return redirect()->back();
    });   
    Route::post('/delivery_box/generate_code', function () {
        $values['code'] = rand(1000, 9999);
        $values['mobile_number'] = '+966' . substr(request('mobile_number'), 1, 9);
        $values['isCodeUsed'] = false;

        \DB::table('boxes')->where('box_name', 'delivery_box')->update($values);
        
        $basic  = new \Vonage\Client\Credentials\Basic("43bd37db", "yhrY752gCCZmgbff");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($values['mobile_number'], 
                'EMail-Box', 
                'Scan code in url ' . 'https://sfbox.xyz/box/codes/'.$values['code'])
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

        return redirect()->back();
    });

    // open code
    Route::get('/box/codes/{code}', function($code){
        // get delivery box information
        $box = DeliveryTrip::where('id', '1')->first();

        $attributes['isBoxOpen'] = True;
        
        $box->update($attributes);

        return redirect()->back();
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