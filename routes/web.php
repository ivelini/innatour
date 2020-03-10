<?php

Auth::routes();

Route::group(['prefix' => 'manager', 'namespace' => 'Admin\Manager', 'middleware' => ['auth', 'auth.manager']], function () {

    Route::resource('tour', 'TourController')
        ->names('manager.tour');

    Route::resource('category', 'CategoryController')
        ->except(['create', 'show'])
        ->names('manager.category');

    Route::resource('page', 'PageController')
        ->except(['show'])
        ->names('manager.page');

    Route::put('tour/{tour}/publishing', 'TourController@publishing')
        ->name('manager.tour.publishing');

    Route::get('tour/category/{category}', 'TourController@indexCurrentCategory')
        ->name('manager.tour.indexCurrentCategory');

    Route::get('tour/scope/{scope}', 'TourController@indexCurrentScope')
        ->name('manager.tour.indexCurrentScope');

    Route::resource('scope', 'ScopeController')
        ->except(['show'])
        ->names('manager.scope');

    Route::get('/', 'TourController@dashboard')->name('manager.dashboard');

    Route::prefix('client')->group(function () {

        Route::get('new','ClientController@new')->name('manager.client.new');
        Route::get('active','ClientController@active')->name('manager.client.active');
        Route::get('closed','ClientController@closed')->name('manager.client.closed');

        Route::put('{client}/active', 'ClientController@update')->name('manager.client.makeActive');
        Route::put('{client}/close', 'ClientController@update')->name('manager.client.close');
        Route::delete('{client}', 'ClientController@destroy')->name('manager.client.destroy');


    });
    Route::group(['prefix' => 'system', 'namespace' => 'System', 'middleware' => 'auth.admin'], function () {
        Route::get('users', 'UserController@index')->name('manager.system.users');
        Route::put('user/{user}', 'UserController@changeRole')->name('manager.system.user.changeRole');
        Route::delete('user/{user}', 'UserController@destroy')->name('manager.system.user.destroy');

        Route::get('main', 'MainController@index')->name('manager.system.main');
        Route::post('main', 'MainController@updateCarusel')->name('manager.system.main.updateCarusel');
        Route::post('main/tourSearch', 'MainController@updateTourSearch')->name('manager.system.main.updateTourSearch');

        Route::get('settings', 'SettingsController@index')->name('manager.system.settings');
        Route::post('settings', 'SettingsController@update')->name('manager.system.settings.update');
    });

});

Route::group(['namespace' => 'User'], function () {
    Route::get('tour', 'TourController@index')
        ->name('tour.index');

    Route::get('tour/{slug}', 'TourController@show')
        ->name('tour.show');

    Route::get('category/{slug}', 'CategoryController@indexCurrentCategory')
        ->name('category.indexCurrentCategory');

    Route::get('scope/{slug}', 'ScopeController@indexCurrentScope')
        ->name('scope.indexCurrentScope');

    Route::get('/', 'TourController@index')
        ->name('index');

    Route::post('tour/{tour}', 'ActionController@sendTourFormMessage')
        ->name('tour.show.sendMessage');

    Route::get('page/{slug}', 'PageController@show')
        ->name('page.show');

    Route::get('test', 'TourController@test');
});
