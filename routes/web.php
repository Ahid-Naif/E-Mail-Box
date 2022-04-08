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
    Route::get('/monitoring', function()
    {
        return view('monitoring');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::post('/send_code', function()
    {
        // get delivery box information
        $box = DeliveryTrip::where('id', '1')->first();

        $values['box_code'] = $order->code;
        $values['isBoxOpen'] = False;

        $box->update($values);
        
        $basic  = new \Vonage\Client\Credentials\Basic("43bd37db", "yhrY752gCCZmgbff");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($order->owner->phone_number, 
                    'SFBox', 
                    $order->code . ' ' . 'https://sfbox.xyz/monitoring')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

        return redirect()->back();
    });

    Route::post('/open_box', function(Request $request, Order $order){
        // get delivery box information
        $box = DeliveryTrip::where('id', '1')->first();

        $attributes['isBoxOpen'] = True;
        
        $box->update($attributes);

        return redirect()->back();
    });
});

Route::get('/', function () {
    return view('welcome');
});