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

Route::get('/login', ['uses' => 'GitAuthController@login', 'as' => 'git.login']);
Route::get('/callback', ['uses' => 'GitAuthController@callback', 'as' => 'git.callback']);
Route::get('/logout', ['uses' => 'GitAuthController@logout', 'as' => 'git.logout']);

Route::get('/issues/{owner}/{repo}', ['uses' => 'IssuesController@issues', 'as' => 'git.issues']);
Route::get('/issues/{owner}/{repo}/{id}', ['uses' => 'IssuesController@issue', 'as' => 'git.issue']);

Route::get('/', function () {
    return redirect(route('git.issues', ['symfony', 'symfony']));
});