<?php

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

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


Route::group(['prefix' => 'v1'], function () {
    //PRIVATE ROUTES
    Route::group(['middleware' => ['auth:api', 'localization']], function () {
        Route::post('user/push', 'UserController@sendPushTest');
        Route::get('user/{user_id}', 'UserController@getUser');
        Route::put('user/{user_id}/change-password', 'UserController@changePasswordUser');
        Route::post('logout', 'UserController@logout');
        Route::put('user/{user_id}', 'UserController@updateUser');
        Route::post('upload-license', 'UserController@uploadUserLicense');
        // Rental Request Services
        Route::get('rental-request/{request_id}', 'RentalRequestController@getRequest');
        Route::post('rental-request', 'RentalRequestController@createRequest');
        Route::get('rental-requests', 'RentalRequestController@getSentRequests');
        Route::post('summary', 'RentalRequestController@getSummary');
        Route::post('change-request-status/{rental_request_id}', 'RentalRequestController@changeStatusRequestById');
        Route::get('current-request/{user_id}', 'RentalRequestController@currentRequestByUser');
        Route::post('send-current-location', 'RentalRequestController@sendCurrentLocation');
        Route::get('accepted-request', 'RentalRequestController@getAcceptedRequests');
        Route::post('assign-request', 'RentalRequestController@assignRequest');
        Route::get('agents-list', 'RentalRequestController@getAgentsList');
        Route::get('assigned-request', 'RentalRequestController@getAssignedRequests');
        Route::get('dropoff-request', 'RentalRequestController@getDropOffRequests');
        Route::put('update-request/{rental_request_id}', 'RentalRequestController@updateRequest');
        Route::get('own-requests', 'RentalRequestController@getRequests');
        Route::put('extend-rental-request/{rental_request_id}', 'RentalRequestExtensionController@extendRental');
        Route::post('rate-rental-request', 'RentalRequestRatesController@rateExperience');
        // Other Services
        Route::get('cars-clasification', 'CarsClassificationController@getCars');
        Route::get('policy', 'PolicyController@getPolicies');
        Route::get('city', 'CityController@getCities');
        Route::get('countries', 'CityController@getCountries');
        Route::post('cancellation-reason', 'CancellationRequestReasonsController@sendCancellationRequestReason');
        Route::get('discount-code', 'DiscountCodesController@getDiscountAmount');

        Route::group(['prefix' => 'stripe'], function () {
            // Token
            Route::post('create-card-token', 'StripeController@createCardToken');
            // Customer
            Route::get('retrieve-customer/{customer_id}', 'StripeController@retrieveCustomer');
            Route::post('create-customer', 'StripeController@createCustomer');
            Route::put('update-customer/{customer_id}', 'StripeController@updateCustomer');
            Route::delete('delete-customer/{customer_id}', 'StripeController@deleteCustomer');
            Route::get('all-customers/{limit}', 'StripeController@allCustomers');
            // Card
            Route::get('customer/{customer_id}/retrieve-card/{card_id}', 'StripeController@retrieveCard');
            Route::post('create-card', 'StripeController@createCard');
            Route::put('customer/{customer_id}/update-card/{card_id}', 'StripeController@updateCard');
            Route::delete('customer/{customer_id}/delete-card/{card_id}', 'StripeController@deleteCard');
            Route::get('customer/{customer_id}/all-cards/{limit}', 'StripeController@allCards');
            // Charge
            Route::get('retrieve-charge/{charge_id}', 'StripeController@retrieveCharge');
            Route::get('capture-charge/{charge_id}', 'StripeController@captureCharge');
            Route::post('create-charge', 'StripeController@createCharge');
            Route::put('update-charge/{charge_id}', 'StripeController@updateCharge');
            Route::delete('delete-charge/{charge_id}', 'StripeController@deleteCharge');
            Route::get('all-charges/{limit}', 'StripeController@allCharges');
            // Refund
            Route::get('retrieve-refund/{refund_id}', 'StripeController@retrieveRefund');
            Route::post('create-refund', 'StripeController@createRefund');
            Route::put('update-refund/{refund_id}', 'StripeController@updateRefund');
            Route::get('all-refunds/{limit}', 'StripeController@allRefunds');
        });
    });

    //PUBLIC ROUTES
    Route::group(['middleware' => ['localization', 'UppyxClientCredentials']], function () {
        Route::post('register', 'UserController@signUp');
        Route::post('login', 'UserController@login');
        Route::post('login/social', 'UserController@loginSocial');
        Route::post('user/uploadpicture', 'UserController@uploadProfilePicture');
        Route::post('user/send-password-token', 'ForgotPasswordController@sendValidationToken');
        Route::post('user/validate-forgot-password/{token}', 'ForgotPasswordController@validateToken');
        Route::post('resend-confirmation-email', 'UserController@resendEmailConfirmation');
        Route::post('user-exist', 'UserController@getUserByField');
    });

    //FREE ROUTES
    Route::get('cancel-rental-request', 'RentalRequestController@cancelRequest');

    //PROTECTED ROUTES
    Route::group([], function () {
        Route::get('test-protected', 'Auth\LoginController@test2');
    });
});