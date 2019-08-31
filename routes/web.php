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

use App\Example\ExampleService;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::post('/test-with-header', function () {
    /*
     * Status code 201 jest wysyłany jest kiedy stowrzyliśmy conajmniej jeden item
     */
    return new \Illuminate\Http\JsonResponse(['status' => 'success'], 201);
});

Route::get('/test-session', function (\Illuminate\Http\Request $request) {
    $value = $request->session()->get('foo');

    return new \Illuminate\Http\JsonResponse(['foo' => $value]);
});

Route::get('/test-session-with-auth', function (\Illuminate\Http\Request $request) {
    $value = $request->session()->get('foo');

    return new \Illuminate\Http\JsonResponse([
        'foo' => $value, 'fdoo' => 'bar',
    ]);
})->middleware('auth');;

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/testVerifyingAnExactJsonMatch', function () {
    /*
     * Status code 201 jest wysyłany jest kiedy stowrzyliśmy conajmniej jeden item
     */
    return new \Illuminate\Http\JsonResponse(['status' => 'success'], 201);
});

Route::post('/test-file', function (\Illuminate\Http\Request $request) {

    $path = $request->file('avatar')->store('', 'avatars');

    return $path;
});

Route::post('/testService', function (ExampleService $exampleService) {
    return new \Illuminate\Http\JsonResponse([
        'name' => $exampleService->giveMeNameBaby(),
    ]);
});
