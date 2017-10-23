<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//Route::group(['middleware' => ['web']], function () {
//    //
//});

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'Home\IndexController@login');
    Route::get('register', 'Home\IndexController@register');
    Route::get('agree', 'Home\IndexController@agree');
    Route::any('index/ajax', 'Home\IndexController@ajax');
    Route::any('login', 'Home\IndexController@login');
    Route::get('forget', 'Home\IndexController@forget');

    Route::any('callbackmaterial', 'Home\IndexController@callBackMaterial');
    Route::any('callbacktools', 'Home\IndexController@callBackTools');
//    Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
//    Route::get('/a/{art_id}', 'Home\IndexController@article');

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');


    Route::get('test', 'Home\IndexController@test');
});

Route::group(['middleware' => ['web','user.login'],'prefix'=>'home','namespace'=>'Home'], function () {

    Route::get('index', 'IndexController@index');

    Route::get('quit', 'IndexController@quit');

    Route::get('userfile/index', 'UserFileController@index');
    Route::any('userfile/ajax', 'UserFileController@ajax');
    Route::any('userfile/addmaterial', 'UserFileController@addMaterial');
    Route::get('userfile/downloadfile/{material_id}', 'UserFileController@downloadFile');

    Route::get('sharefile/index', 'ShareFileController@index');
    Route::any('sharefile/ajax', 'ShareFileController@ajax');
    Route::get('sharefile/downloadfile/{tools_id}', 'ShareFileController@downloadFile');

    Route::get('userinfo/index', 'UserInfoController@index');
    Route::get('userinfo/modifypassword', 'UserInfoController@modifyPassword');
    Route::any('userinfo/ajax', 'UserInfoController@ajax');

    Route::get('recommendinfo/index', 'RecommendInfoController@index');
    Route::get('recommendinfo/addrecommend', 'RecommendInfoController@addRecommend');
    Route::any('recommendinfo/ajax', 'RecommendInfoController@ajax');
});



Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {

    Route::get('index', 'IndexController@index');
    Route::get('quit', 'LoginController@quit');

    Route::get('material/index', 'MaterialController@index');
    Route::post('material/ajax', 'MaterialController@ajax');
    Route::get('material/downloadfile/{material_id}', 'MaterialController@downloadFile');
    Route::get('material/addMaterial', 'MaterialController@addMaterial');


    Route::get('area/index', 'AreaController@index');
    Route::post('area/ajax', 'AreaController@ajax');


    Route::get('bigarea/index', 'BigareaController@index');
    Route::post('bigarea/ajax', 'BigareaController@ajax');


    Route::get('doctor/index', 'DoctorController@index');
    Route::post('doctor/ajax', 'DoctorController@ajax');
    Route::get('doctor/recommendadd/{doctor_id}', 'DoctorController@recommendAdd');


    Route::get('hospital/index', 'HospitalController@index');
    Route::post('hospital/ajax', 'HospitalController@ajax');

    Route::get('recommend/index', 'RecommendController@index');
    Route::post('recommend/ajax', 'RecommendController@ajax');

    Route::get('materialtype/index', 'MaterialTypeController@index');
    Route::post('materialtype/ajax', 'MaterialTypeController@ajax');

    Route::get('report/index', 'ReportController@index');
    Route::post('report/ajax', 'ReportController@ajax');

    Route::get('sales/index', 'SalesController@index');
    Route::post('sales/ajax', 'SalesController@ajax');

    Route::get('tools/index', 'ToolsController@index');
    Route::post('tools/ajax', 'ToolsController@ajax');
    Route::get('tools/downloadfile/{tools_id}', 'ToolsController@downloadFile');
    Route::any('tools/toolsadd', 'ToolsController@toolsAdd');

    Route::get('report/index', 'ReportController@index');
    Route::post('report/ajax', 'ReportController@ajax');

    Route::any('report/reportexcel', 'ReportController@reportExcel');



//    Route::any('pass', 'IndexController@pass');
//
//    Route::post('cate/changeorder', 'CategoryController@changeOrder');
//    Route::resource('category', 'CategoryController');
//
//    Route::resource('article', 'ArticleController');
//
//    Route::post('links/changeorder', 'LinksController@changeOrder');
//    Route::resource('links', 'LinksController');
//
//    Route::post('navs/changeorder', 'NavsController@changeOrder');
//    Route::resource('navs', 'NavsController');
//
//    Route::get('config/putfile', 'ConfigController@putFile');
//    Route::post('config/changecontent', 'ConfigController@changeContent');
//    Route::post('config/changeorder', 'ConfigController@changeOrder');
//    Route::resource('config', 'ConfigController');
//
//    Route::any('upload', 'CommonController@upload');
    Route::get('wechat', 'Home\WechatController@index');

});
