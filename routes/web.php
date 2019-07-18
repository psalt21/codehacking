<?php
use Illuminate\Http\Request;

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

Route::get('/', function () {
    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $token = $gateway->ClientToken()->generate();

    return view('welcome', [
        'token'=>$token
    ]);
});

Route::post('/checkout', function (Request $request) {
    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $result = $gateway->transaction()->sale([
        'amount' => $request->amount,
        'paymentMethodNonce' => $request->payment_method_nonce,
        'customer' => [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email
        ],
        'billing' => [
            'countryName' => $request->country,
            'streetAddress' => $request->streetAddress,
            'locality' => $request->city,
            'region' => $request->state,
            'postalCode' => $request->postalCode,
        ],
        'options' => [
            'submitForSettlement' => true
        ]
    ]);

    if ($result->success) {
        $transaction = $result->transaction;
        // header("Location: " . $baseUrl . "transaction.php?id=" . $transaction->id);
        return back()->with('success_message', 'Transaction successful. The ID is:'. $transaction->id);
    } else {
        $errorString = "";

        foreach ($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        // $_SESSION["errors"] = $errorString;
        // header("Location: " . $baseUrl . "index.php");
        return back()->withErrors('An error occurred with the message: '. $result->message);
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function () {
    return view('admin.index');
});

Route::resource('admin/users', 'AdminUsersController');
