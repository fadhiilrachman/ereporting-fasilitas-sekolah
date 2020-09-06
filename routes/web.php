<?php

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/live-ajax', 'DashboardController@live_ajax');

    Route::get('/settings', 'SettingsController@index');
    Route::post('/settings/update-email', 'SettingsController@updateEmail');
    Route::post('/settings/update-password', 'SettingsController@updatePassword');
});

Route::group(['middleware' => ['auth','role:Tata Usaha']], function() {
    Route::get('/master/rooms', 'MasterController@roomsView');
    
    Route::get('/json/master/rooms', 'MasterController@roomsViewJson');
    Route::get('/json/master/rooms/edit/{id}', 'MasterController@roomsEditJson');
    Route::post('/json/master/rooms/delete/{id}', 'MasterController@roomsDestroyJson');
    Route::post('/json/master/rooms/store', 'MasterController@roomsStoreJson');

    Route::get('/master/facilities', 'MasterController@facilitiesView');

    Route::get('/json/master/facilities', 'MasterController@facilitiesViewJson');
    Route::get('/json/master/facilities/edit/{id}', 'MasterController@facilitiesEditJson');
    Route::post('/json/master/facilities/delete/{id}', 'MasterController@facilitiesDestroyJson');
    Route::post('/json/master/facilities/store', 'MasterController@facilitiesStoreJson');
    Route::get('/json/master/facilities/rooms', 'MasterController@facilitiesGetRoomsJson');

    Route::get('/master/criterias', 'MasterController@criteriasView');

    Route::get('/json/master/criterias', 'MasterController@criteriasViewJson');
    Route::get('/json/master/criterias/edit/{id}', 'MasterController@criteriasEditJson');
    Route::post('/json/master/criterias/delete/{id}', 'MasterController@criteriasDestroyJson');
    Route::post('/json/master/criterias/store', 'MasterController@criteriasStoreJson');
    Route::get('/json/master/criterias/rooms', 'MasterController@criteriasGetRoomsJson');
    Route::get('/json/master/criterias/facilities/{id}', 'MasterController@criteriasGetRoomFacilitiesJson');

    Route::get('/master/student', 'MasterController@studentView');

    Route::get('/json/master/student', 'MasterController@studentViewJson');
    Route::get('/json/master/student/edit/{id}', 'MasterController@studentEditJson');
    Route::post('/json/master/student/delete/{id}', 'MasterController@studentDestroyJson');
    Route::post('/json/master/student/store', 'MasterController@studentStoreJson');

    Route::get('/report/process', 'ReportController@processReport');
    Route::post('/report/process', 'ReportController@processSelectReport');
    Route::get('/report/view', 'ReportController@viewReport');

    Route::get('/json/report/rekap', 'ReportController@getRekapReportsJson');
});

Route::group(['middleware' => ['auth','role:Siswa']], function() {
    Route::get('/report/create-new', 'ReportController@createNewView');
    Route::get('/report/history', 'ReportController@historyView');

    Route::post('/report/create-new', 'ReportController@createNewReport');

    Route::post('/json/report/revoke/{id}', 'ReportController@revokeReportJson');

    Route::get('/json/report/rooms', 'ReportController@reportGetRoomsJson');
    Route::get('/json/report/facilities/{id}', 'ReportController@reportGetRoomFacilitiesJson');
    Route::get('/json/report/criterias/{id}', 'ReportController@reportGetCriteriasFacilitiesJson');
    Route::get('/json/report/history', 'ReportController@getStudentReportsJson');
});

Auth::routes();