<?php
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return Auth::check() ? redirect('check/type') : view('backend.login');
})->name('/');
Route::post('login','Auth\LoginController@login')->name('login');
Route::get('logout','Auth\LoginController@logout')->middleware('auth');
Route::get('check/type',function(){
    if(Auth::check()){
        $type=Auth::user()->type;
        switch($type){
            case "admin" : return redirect(url('admin/create/depart'));break;
            case "sub_depart_admin" : return redirect(url('sub_depart'));break;
        }
    }else{
        return redirect('/');
    }
});
/* ------------------------------------- Admin Section------------------------------ */
Route::group(['middleware'=>['auth','admin'],'prefix'=>'admin'],function(){
    // create main department
    Route::get('create/depart','AdminController@createDepart');
    Route::post('store/depart','AdminController@storeDepart');
    Route::get('depart/data','AdminController@departData');
    Route::get('depart/data/edit/{id}','AdminController@editDepart');
    Route::post('update/depart','AdminController@updateDepart');
    Route::get('main-depart/related/sub-depart/{id}','AdminController@mainDepartRelatedSubDepart');
    Route::delete('main-depart/delete/{id}','AdminController@mainDepartRelatedSubDepartDelete');

     // create sub department
     Route::get('create/sub-depart','AdminController@createSubDepart');
     Route::post('store/sub-depart','AdminController@storeSubDepart');
     Route::get('sub-depart/data','AdminController@dataSubDepart');
     Route::get('sub-depart/data/edit/{id}','AdminController@editSubDepartData');
     Route::post('update/sub-depart-data','AdminController@updateSubDepartData');
     Route::get('sub-depart/delete/{id}','AdminController@deleteSubDepartData');

     // create adjure/letter
     Route::get('create/adjure/letter','AdminController@createAdjureLetter');
     Route::post('store/adjure/letter','AdminController@storeAdjureLetter');
     Route::get('adjure/data','AdminController@adjureData');
     Route::get('adjure/data/edit/{id}','AdminController@editAdjureData');
     Route::post('update/adjure','AdminController@updateAdjureData');
     Route::delete('delete/adjure/data/{id}','AdminController@deleteAdjureData');
});

/* --------------------------------------- Sub Department Section------------------------*/
Route::group(['middleware'=>['auth','sub_depart_admin'],'prefix'=>'sub_depart'],function(){
    Route::get('/','SubDepartmentController@index');
    Route::get('simple/output-letter/create','SubDepartmentController@simpleOutputLetterCreate');
    Route::post('send/simple/output-letter','SubDepartmentController@sendSimpleOutputLetter');

    Route::get('simple/income-letter','SubDepartmentController@simpleIncomeLetter'); // simple income letter
    Route::get('simple/all/income-letter','SubDepartmentController@allSimpleIncomeLetter');
    Route::post('search/income_letter','SubDepartmentController@searchIncomeLetter');

    Route::get('simple/outcome-letter','SubDepartmentController@simpleOutcomeLetter'); // simple outcome letter
    Route::get('simple/all/outcome-letter','SubDepartmentController@allSimpleOutcomeLetter');
    Route::post('search/outcome_letter','SubDepartmentController@searchOutcomeLetter');

    Route::get('profile/setting','SubDepartmentController@profileSetting');
    Route::post('profile_setting/change','SubDepartmentController@changeProfileSetting');

    Route::get('file/download/{path}','SubDepartmentController@downloadFile');
    Route::get('single/letter/{id}/{to}','SubDepartmentController@singleLetterPage');

    Route::get('is-read/state-change/{id}','SubDepartmentController@isReadStateChange');

    // ----------------------- important letter -----------------------------------
    Route::get('important/output-letter/create','SubDepartmentController@importantOutputLetterCreate');
    Route::post('send/important/output-letter','SubDepartmentController@sendImportantOutputLetter');

    Route::get('important/income-letter','SubDepartmentController@importantIncomeLetter'); // impoart income letter
    Route::get('important/all/income-letter','SubDepartmentController@allImportantIncomeLetter');
    Route::post('search/important/income_letter','SubDepartmentController@searchImportantIncomeLetter');

    Route::get('important/outcome-letter','SubDepartmentController@importantOutcomeLetter'); // important outcome letter
    Route::get('important/all/outcome-letter','SubDepartmentController@allImportantOutcomeLetter');
    Route::post('search/important/outcome_letter','SubDepartmentController@searchImportantOutcomeLetter');

    Route::get('single/important/letter/{id}/{to}','SubDepartmentController@singleImportantLetterPage');
});

Route::get('department/show','AdminController@departmentShow')->middleware('auth');
Route::get('adjure/file/download/{path}','AdminController@adjureDownloadFile')->middleware('auth');
Route::get('adjure/letter','AdminController@adjureData')->middleware('auth');
Route::get('adjure/data/detail/{id}','AdminController@detailAdjureData')->middleware('auth');