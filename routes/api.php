<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    });
    Route::post('/save-subscription/{id}',function($id, Request $request){
        $user = \App\Models\User::findOrFail($id);
        $user->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
        $user->notify(new \App\Notifications\GenericNotification("Welcome To WebPush", "You will now get all of our push notifications"));
        return response()->json([
          'success' => true
        ]);
      });
      Route::post('/send-notification/{id}', function($id, Request $request){
        $user = \App\Models\User::findOrFail($id);
        $user->notify(new \App\Notifications\GenericNotification($request->title, $request->body));
        return response()->json([
          'success' => true
        ]);
    });