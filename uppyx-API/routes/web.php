<?php

//Dashboard with data important
Route::group(['middleware'=>'localization'], function () {
    Auth::routes();
    Route::post('/password/reset', 'ForgotPasswordController@resetPassword');
    Route::get('/password-changed', 'ForgotPasswordController@passwordChanged');
    Route::get('/activate-account/{email}/{lang}', 'UserController@activateAccount');
    Route::get('/activate-account', 'UserController@activateAccountView');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', 'HomeController@index');

Route::post('/login2', 'LoginController@login');
Route::any('/logout', 'LoginController@logout');

Route::post('validate-date-ranges', 'RatesController@validateDateRanges');
Route::post('remove-rates-by-id', 'RatesController@removeRateById');
Route::post('load-range-by-car', 'RatesController@loadSelectedRageByCarClassification');
Route::get('log-detail', 'LogsController@detalleTabla');

Route::get('/policy', 'PolicyController@showPolicy');
Route::get('/terms', 'PolicyController@showTerms');

Route::group(['middleware' => ['auth']], function () {
    //Profile
    Route::get('/user-profile', 'UserController@userProfile');
    Route::post('/user-profile', 'UserController@updateProfile');

    //Delete Configurations
    Route::get('user-profile/{id}/{picture}/destroy', [
        'uses' => 'UserController@deleteUserProfile',
        'as'   => 'user-profile.destroy'
    ]);

    //Dashboard
    Route::any('/custom-dashboard', 'DashboardController@customRange');

    //Edit request
    Route::get('/rental-request-pending', 'RentalRequestController@PendingRentalRequests');
    Route::post('rental-requests/{id}/edit', [
        'uses' => 'RentalRequestController@EditRentalRequest',
        'as'   => 'rental-requests.edit'
    ]);
});

Route::group(['middleware' => ['auth', 'CheckRoleAdmin::class']], function () {

    //Register Rental Car
    Route::get('/register-rent-car', 'RentalAgencyController@viewRegister');

    Route::post('/register-rental-car', 'RentalAgencyController@register');

    //List User Admin Rental Car
    Route::get('/list-user-rental', 'RentalAgencyController@listUserAdminRental');

    //List Agency
    Route::get('/list-admin-rental', 'RentalAgencyController@listAdminRental');

    //Register Admin Rental Car
    Route::get('/register-rental-admin', 'RentalAgencyController@viewRegisterAdminAgency');

    Route::post('/register-rental-admin', 'RentalAgencyController@registerAdminAgency');

    //Enable and Disable User Admin Rental Car
    Route::get('/disable-user-rental/{id}', 'RentalAgencyController@disableUserAdminRental');

    Route::get('/enable-user-rental/{id}', 'RentalAgencyController@enableUserAdminRental');

    //Update Admin Rental
    Route::get('/update_admin_rental/{id}', 'RentalAgencyController@viewAdminRental');

    Route::post('/updated_admin_rental', 'RentalAgencyController@updatedAdminRental');

    //Update User Admin Rental
    Route::get('/update-user-rental/{id}', 'RentalAgencyController@viewUserAdminRental');

    Route::post('/updated-user-rental', 'RentalAgencyController@updatedUserAdminRental');

    //Enable and Disable Admin Rental Car
    Route::get('/disable_admin_rental/{id}', 'RentalAgencyController@disableAdminRental');

    Route::get('/enable_admin_rental/{id}', 'RentalAgencyController@enableAdminRental');

    Route::get('/rental-request-list', 'RentalRequestController@RentalRequestList');

    Route::get('/rental-request-list-data', [
        'as'   => 'requestData',
        'uses' => 'RentalRequestController@RentalRequestListData'
    ]);

    //List, Register, Update, Configurations
    Route::resource('configurations', 'ConfigurationsController');

    //Delete Configurations
    Route::get('configurations/{id}/destroy', [
        'uses' => 'ConfigurationsController@destroy',
        'as'   => 'configurations.destroy'
    ]);

    //List, Register, Update, Rates
    Route::resource('rates', 'RatesController');

    //Delete Rates
    Route::get('rates/{id}/destroy', [
        'uses' => 'RatesController@destroy',
        'as'   => 'rates.destroy'
    ]);

    //List Cities
    Route::get('/city-configurations/{id}', 'ConfigurationsController@citiesSelect');

    //List Charges
    Route::get('/list-charges', 'ChargesController@index');

    //List Charges Js
    Route::get('/charge-list/{country_id}/{city_id}', 'ChargesController@chargesSelect');

    //Register Charges
    Route::get('/register-charges', 'ChargesController@create');
    Route::post('/store-charges', 'ChargesController@store');

    //Eliminar Cargo
    Route::get('/charges/{id}/destroy', 'ChargesController@destroy');

    Route::resource('charges', 'ChargesController');


    Route::get('/list-log', 'LogsController@listadoTabla');

    Route::get('/list-log-data', [
        'as'   => 'logData',
        'uses' => 'LogsController@consultaTabla'
    ]);

});

Route::group(['middleware' => ['auth', 'CheckRoleRentAdmin::class']], function () {

    //Register Agents
    Route::get('/register-agent', 'RentalAgencyController@viewRegisterAgent');

    Route::post('/register-agent', 'RentalAgencyController@registerAgent');

    //List Agents
    Route::get('/list-agent', 'RentalAgencyController@listAgent');

    Route::get('/disable-agent/{id}', 'RentalAgencyController@disableAgent');

    Route::get('/enable-agent/{id}', 'RentalAgencyController@enableAgent');

    Route::get('/list-rental-request', 'RentalAgencyController@viewRequestRental');

    Route::get('/list-rental-request-data', [
        'as'   => 'rentalData',
        'uses' => 'RentalAgencyController@viewRequestRentalData'
    ]);

    //Update Agents
    Route::get('/update-agent/{id}', 'RentalAgencyController@viewUpdateAgent');

    Route::post('/updated-agent', 'RentalAgencyController@updatedAgent');
});

Route::group(['middleware'=>'localization'], function () {
    Route::post('/password/email', 'ForgotPasswordController@sendValidationToken');
});
