<?php

use App\Jobs\OrderCanceled;
use App\Jobs\OrderCreated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('order', function () {

    $id = 1;
    $sends = 1;

    while(true) {

        OrderCreated::dispatch("Message: {$id}");
        OrderCanceled::dispatch("Message: {$id}");

        echo "{$id} \n";
        
        $id++;


        sleep(2);

        if ($id > $sends) break;
    }

    return <<<html
    <h1>Order created </h1>
    <h2>Message sent to rabbitmq</h2>
    html;
});
