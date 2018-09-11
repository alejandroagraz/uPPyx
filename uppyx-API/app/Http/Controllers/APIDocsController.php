<?php

namespace App\Http\Controllers;


class APIDocsController extends Controller
{
     /**
     * @apiDefine HeadersLogin
     * @apiHeader   (Headers)   {String}    Content-Type <code>application/json</code>
     * @apiHeader   (Headers)   {String}    Authorization <code>Bearer eyJ0eXAiOiJKV1QiLCJhbG</code>
     */

    /**
     * @apiDefine HeadersBasic
     * @apiHeader   (Headers)   {String}    Content-Type <code>application/json</code>
     */

    /**
     * @apiDefine HeadersBasicAccept
     * @apiHeader   (Headers)   {String}    Accept <code>application/json</code>
     * @apiHeader   (Headers)   {String}    Authorization Example: <code>Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImY</code>
     * @apiHeader   (Headers)   {String}    Content-Type <code>application/json</code>
     *
     */

    /**
     * @apiDefine HeadersProtected
     * @apiHeader   (Headers)   {String}    Authorization Passport Authorization. e.g.<code>Bearer 3j9igs...</code> <label class="label label-warning">required</label>
     * @apiHeader   (Headers)   {String}    Content-Type <code>application/json</code>
     */

    /**
     * @apiDefine responseOauth
     * @apiSuccessExample OAuth Response:
     *  HTTP/1.1 401 Unauthorized
     *  {
     *      "message": "Failed to authenticate because of bad credentials or an invalid authorization header."
     *      or
     *      "message": "Unauthenticated."
     *  }
     */

    /**
     * login()
     * @apiDescription Login service
     * @api {post} login Login
     * @apiVersion 1.0.0
     * @apiName User Login
     * @apiGroup User
     *
     * @apiUse HeadersBasic
     *
     * @apiParam {String} grant_type    Passport grant type. <label class="label label-warning">required</label>
     * @apiParam {String} client_id     Passport client id. <label class="label label-warning">required</label>
     * @apiParam {String} client_secret Passport client secret. <label class="label label-warning">required</label>
     *
     * @apiParam {String} lang              Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} username          User Email. <label class="label label-warning">required</label>
     * @apiParam {String} password          User password.<label class="label label-warning">required</label>
     * @apiParam {String} token_device      Token device.<label class="label label-warning">required</label>
     * @apiParam {String} operative_system  Operative System of device. <code>ios, android</code><label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "data": {
     *      "id": "5a54311b-62fb-4e36-b2cb-f82da06b42c3",
     *      "name": "Admin User",
     *      "email": "admin@tera.com",
     *      "phone": "04243356932",
     *      "country": Venezuela,
     *      "city": Caracas,
     *      "gender": M,
     *      "birth_of_date": 1985-11-03,
     *      "role": [
     *        "super-admin"
     *      ],
     *      "access_token": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS",
     *      "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg",
     *      "profile_picture": "229f52336e0f40cd60c56af056dd10078f75d909.jpg"
     *      "rental_agency_id": 2,
     *      "rental_agency_name": "Amigo's Car Rental",
     *      "stripe_customer_id": "cus_9kzMsAMTIMjo890",
     *      "facebook_id": null,
     *      "facebook_profile_picture": null,
     *      "google_id": "100834862662018528710",
     *      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *      "configuration": {
     *          "assign_planned_request_time": 120, // min
     *          "max_time_refresh_map": 300, // seg
     *          "request_type_time": 1, // H
     *      }
     *    }
     *  }
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *    "client_id" : "2",
     *    "client_secret" : "odrojDRbmdjTXYAGSMOxdL0tPqGYsJlto0dSkkwK",
     *    "lang": "en",
     *    "grant_type": "password",
     *    "username" : "admin@tera.com",
     *    "password" : "secret",
     *    "token_device": "0123456789",
     *    "operative_system": "android"
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 401 Unauthorized
     *  {
     *      "message": "The information for the login is invalid"
     *  }
     *  HTTP/1.1 400 Bad Request
     *  {
     *      "message": "The selected operative system is invalid."
     *      or
     *      "message": "The operative system field is required."
     *      or
     *      "message": "This user has been disabled."
     *      or
     *      "message": "Please activate the account in order to login."
     *      or
     *      "message": "Deny access."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * loginSocial()
     * @apiDescription Social Login
     * @api {post} login/social Social Login
     * @apiVersion 1.0.0
     * @apiName Social Login
     * @apiGroup User
     *
     * @apiUse HeadersBasic
     *
     * @apiParam {String} grant_type        Passport grant type. <label class="label label-warning">required</label>
     * @apiParam {String} client_id         Passport client id. <label class="label label-warning">required</label>
     * @apiParam {String} client_secret     Passport client secret. <label class="label label-warning">required</label>
     *
     * @apiParam {String} lang              Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} email             User Email. <label class="label label-warning">required</label>
     * @apiParam {String} birth_of_date     User Birth Of Date. <label class="label label-warning">required</label>
     * @apiParam {String} social_id         User Social Id.<label class="label label-warning">required</label>
     * @apiParam {String} social_token      User Social Token.<label class="label label-warning">required</label>
     * @apiParam {String} provider          Social Provider. <code>facebook,google</code><label class="label label-warning">required</label>
     * @apiParam {String} token_device      Token device.<label class="label label-warning">required</label>
     * @apiParam {String} operative_system  Operative System of device. <code>ios, android</code><label class="label label-warning">required</label>
     * @apiParam {String} [country]         User Country. <label class="label label-warning">required</label>
     * @apiParam {String} [city]            User City.
     * @apiParam {String} [gender]          User Gender. <code>M/F</code>
     * @apiParam {String} [phone]           User Phone.
     * @apiParam {String} [avatar]          User Avatar.
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "data": {
     *      "id": "5a54311b-62fb-4e36-b2cb-f82da06b42c3",
     *      "name": "Social User",
     *      "email": "social@tera.com",
     *      "phone": "04243356932",
     *      "country": Venezuela,
     *      "city": Caracas,
     *      "gender": M,
     *      "birth_of_date": 1985-11-03,
     *      "role": [
     *        "user"
     *      ],
     *      "access_token": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS",
     *      "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg",
     *      "profile_picture": "229f52336e0f40cd60c56af056dd10078f75d909.jpg"
     *      "rental_agency_id": 2,
     *      "rental_agency_name": "Amigo's Car Rental",
     *      "stripe_customer_id": "cus_9kzMsAMTIMjo890",
     *      "facebook_id": null,
     *      "facebook_profile_picture": null,
     *      "google_id": "100834862662018528710",
     *      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *      "configuration": {
     *          "assign_planned_request_time": 120, // min
     *          "max_time_refresh_map": 300, // seg
     *          "request_type_time": 1, // H
     *      }
     *    }
     *  }
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *    "grant_type": "password",
     *    "client_id" : "2",
     *    "client_secret" : "odrojDRbmdjTXYAGSMOxdL0tPqGYsJlto0dSkkwK",
     *    "lang": "en",
     *    "email" : "email@test.com",
     *    "birth_of_date" : "1991-11-22",
     *    "social_id" : "122579734933926",
     *    "social_token" : "EAAQEyVPB3XMBAJ9FEhpw05PJZC1xjJ6ENLqIbclpz78y",
     *    "provider" : "facebook",
     *    "operative_system": "android"
     *    "token_device": "0123456789",
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 401 Unauthorized
     *  {
     *      "message": "The information for the login is invalid"
     *  }
     *  HTTP/1.1 400 Bad Request
     *  {
     *      "message": "The lang field is required."
     *      or
     *      "message": "The email field is required."
     *      or
     *      "message": "The birth_of_date field is required."
     *      or
     *      "message": "The social_id field is required."
     *      or
     *      "message": "The social_token field is required."
     *      or
     *      "message": "The selected provider is invalid."
     *      or
     *      "message": "The selected operative system is invalid."
     *      or
     *      "message": "The operative system field is required."
     *      or
     *      "message": "Deny access."
     *      or
     *      "message": "Error Saving Data."
     *      or
     *      "message": "Error Creating Customer."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * resentEmailConfirmation()
     * @apiDescription Resend Email Confirmation
     * @api {post} resend-confirmation-email Email Confirmation
     * @apiVersion 1.0.0
     * @apiName Resend Email Confirmation
     * @apiGroup User
     *
     * @apiUse HeadersBasic
     *
     * @apiParam {String} grant_type    Passport grant type. <code>client_credentials</code> <label class="label label-warning">required</label>
     * @apiParam {String} client_id     Passport client id. <label class="label label-warning">required</label>
     * @apiParam {String} client_secret Passport client secret. <label class="label label-warning">required</label>
     *
     * @apiParam {String} lang              Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} email             User Email. <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "message" : "We have sent an email in order to verify your account.",
     *    "title": "VerifyEmailSent"
     *  }
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *    "lang": "en",
     *    "grant_type": "client_credentials",
     *    "client_id" : "2",
     *    "client_secret" : "odrojDRbmdjTXYAGSMOxdL0tPqGYsJlto0dSkkwK",
     *    "email" : "admin@tera.com"
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad Request
     *  {
     *      "message": "This account has already been verified.",
     *      "title": "AccountAlreadyVerified"
     *  }
     *  HTTP/1.1 404 Not Found
     *  {
     *      "message": "User not found.",
     *      "title": "UserNotFound"
     *  }
     *
     * @apiUse responseOauth
     *
     */


    /**
     * signUp()
     * @apiDescription SignUp service
     * @api {post} register Register
     * @apiVersion 1.0.0
     * @apiName User SignUp
     * @apiGroup User
     *
     * @apiUse HeadersBasic
     *
     * @apiParam {String} grant_type    Passport grant type. <label class="label label-warning">required</label>
     * @apiParam {String} client_id     Passport client id. <label class="label label-warning">required</label>
     * @apiParam {String} client_secret Passport client secret. <label class="label label-warning">required</label>
     *
     * @apiParam {String} lang                  Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} name                  User Name. <label class="label label-warning">required</label>
     * @apiParam {String} email                 User Email. <label class="label label-warning">required</label>
     * @apiParam {String} country               User Country. <label class="label label-warning">required</label>
     * @apiParam {String} [city]                User City.
     * @apiParam {String} [gender]              User Gender. <code>M/F</code>
     * @apiParam {String} birth_of_date         User Birth Of Date. <code>Y-m-d (1995-01-08)</code> <label class="label label-warning">required</label>
     * @apiParam {String} [phone]               User Phone.
     * @apiParam {String} password              User password.<label class="label label-warning">required</label>
     * @apiParam {String} password_confirmation User password confirmation.<label class="label label-warning">required</label>
     * @apiParam {String} token_device          Token device.<label class="label label-warning">required</label>
     * @apiParam {String} operative_system      Operative System of device. <code>ios, android</code>.<label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "data": {
     *      "id": "5a54311b-62fb-4e36-b2cb-f82da06b42c3",
     *      "name": "Admin User",
     *      "email": "admin@tera.com",
     *      "phone": "04243356933",
     *      "country": Venezuela,
     *      "city": Caracas,
     *      "gender": M,
     *      "role": [
     *        "super-admin"
     *      ],
     *      "access_token": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS",
     *      "license_picture": "",
     *      "profile_picture": "",
     *      "rental_agency_id": 2,
     *      "rental_agency_name": "Amigo's Car Rental",
     *      "stripe_customer_id": "cus_9kzMsAMTIMjo890",
     *      "facebook_id": null,
     *      "facebook_profile_picture": null,
     *      "google_id": "100834862662018528710",
     *      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *      "configuration": {
     *          "assign_planned_request_time": 120, // min
     *          "max_time_refresh_map": 300, // seg
     *          "request_type_time": 1, // H
     *      }
     *    }
     *  }
     *
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *       "grant_type": "password",
     *       "client_id" : "2",
     *       "client_secret" : "qWwRRBhosN92m9LFWVv0uNTVPYAs3d9Soe0oMDcG",
     *       "lang": "en",
     *       "name": "Super Admin",
     *       "email": "admin@tera.com",
     *       "phone": "04243356933",
     *       "password": "secret",
     *       "password_confirmation": "secret",
     *       "token_device": "0123456789",
     *       "operative_system": "android"
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 401 Unauthorized
     *  {
     *      "message": "The information for the login is invalid"
     *  }
     *  HTTP/1.1 400 Bad Request
     *  {
     *      "message": "The lang field is required."
     *      or
     *      "message": "The token device field is required."
     *      or
     *      "message": "The password confirmation does not match."
     *      or
     *      "message": "The password field is required."
     *      or
     *      "message": "The email field is required."
     *      or
     *      "message": "The email must be a valid email address."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * uploadProfilePicture()
     * @apiDescription Upload Profile Picture service
     * @api {post} user/uploadpicture Upload Profile Picture
     * @apiVersion 1.0.0
     * @apiName User Upload Profile Picture
     * @apiGroup User
     *
     * @apiParam {String}   grant_type    Passport grant type. <code>client_credentials</code><label class="label label-warning">required</label>
     * @apiParam {String}   client_id     Passport client id. <label class="label label-warning">required</label>
     * @apiParam {String}   client_secret Passport client secret. <label class="label label-warning">required</label>
     *
     * @apiParam {String}   lang            Passport grant type. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {File}     image           photo or licence. This will be uploaded in <code> public/userProfile</code> or <code>public/licenseProfile</code><label class="label label-warning">required</label>
     * @apiParam {String}   user_id         User id. <label class="label label-warning">required</label>
     * @apiParam {Boolean}  picture_profile <code>profile=true licence=false</code>. <label class="label label-warning">required</label>
     * @apiParam {Boolean}  [delete]        When is <code>true</code> deletes the image. Is not necessary set as false.
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 201 Created
     *  {
     *      "message": "file uploaded successfully."
     *      or
     *      "message": "Image deleted successfully."
     *      "data": {
     *          "image_name": "ba978256c20a8f2da7b3a149ff5ac4a4b9db1db1.png"
     *      }
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The lang field is required."
     *      or
     *      "message": "The user id field is required."
     *      or
     *      "message": "The selected user id is invalid."
     *      or
     *      "message": "The image field is required.."
     *  }
     *
     * @apiSuccessExample OAuth Response:
     *  HTTP/1.1 401 Unauthorized
     *  {
     *      "message": "Failed to authenticate because of bad credentials or an invalid authorization header."
     *  }
     *
     */


    /**
     * uploadUserLicense()
     * @apiDescription Upload License from Request
     * @api {post} upload-license Upload License from Request
     * @apiVersion 1.0.0
     * @apiName User Upload License from Request
     * @apiGroup Request
     *
     * @apiHeader   (Headers)   {String}    Authorization <code>Bearer eyJ0eXAiOiJKV1QiLCJhbG</code>
     *
     * @apiParam {String}   lang            Passport grant type. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {File}     image           photo or licence. This will be uploaded in <code>public/licenseProfile</code><label class="label label-warning">required</label>
     * @apiParam {String}   user_id         User id. <label class="label label-warning">required</label>
     * @apiParam {Boolean}  picture_profile <code>picture_profile=true</code> saves into profile and  <code>picture_profile=false</code> saves for specific request. <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 201 Created
     *  {
     *      "message": "file uploaded successfully.",
     *      "data": {
     *          "image_name": "9d32da1b4f2445d4d7eb2d7524b55b3563172bc3.png",
     *          "image_id": 1
     *      }
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The lang field is required."
     *      or
     *      "message": "The user id field is required."
     *      or
     *      "message": "The selected user id is invalid."
     *      or
     *      "message": "The image field is required.."
     *  }
     *
     * @apiSuccessExample OAuth Response:
     *  HTTP/1.1 401 Unauthorized
     *  {
     *      "message": "Failed to authenticate because of bad credentials or an invalid authorization header."
     *  }
     *
     */

    /**
     * sendValidationToken()
     * @apiDescription Send Password Token
     * @api {POST} user/send-password-token Send Password Token
     * @apiVersion 1.0.0
     * @apiName Send Password Token
     * @apiGroup Forgot Password
     *
     * @apiUse HeadersBasic
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} grant_type    Passport grant type. <code>refresh_token</code> <label class="label label-warning">required</label>
     * @apiParam {String} client_id     Passport client id. <label class="label label-warning">required</label>
     * @apiParam {String} client_secret Passport client secret. <label class="label label-warning">required</label>
     * @apiParam {String} email         User email. <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "message": "sent"
     *  }
     *
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en",
     *      "grant_type" : "password",
     *      "client_id" : "2",
     *      "client_secret" : "qWwRRBhosN92m9LFWVv0uNTVPYAs3d9Soe0oMDcG",
     *      "email" : "admin@tera.com"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "User not found."
     *      or
     *      "message": "User registered by  a social network, you cannot assign it a password."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * validateToken()
     * @apiDescription Validate token sent
     * @api {POST} user/validate-forgot-password/{token} Validate Token
     * @apiVersion 1.0.0
     * @apiName Validate Token
     * @apiGroup Forgot Password
     *
     * @apiUse HeadersBasic
     *
     * @apiParam {String} password      User password.<label class="label label-warning">required</label>
     * @apiParam {String} password_confirmation      User password confirmation.<label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *      "message": "The password has been changed successfully."
     *  }
     *
     * @apiSuccessExample Example:
     * Content-Type: text/plain
     *  {
     *      "password": "123456",
     *      "password_confirmation": "123456"
     *  }
     *
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "User not found."
     *      or
     *      "message": "Invalid token."
     *      or
     *      "message": "Your password has expired."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getUser()
     * @apiDescription Get User
     * @api {POST} user/{user_id} Get User
     * @apiVersion 1.0.0
     * @apiName Get User
     * @apiGroup User
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": {
     *      "id": "5a54311b-62fb-4e36-b2cb-f82da06b42c3",
     *      "name": "Admin User",
     *      "email": "admin@tera.com",
     *      "role": [
     *          {
     *              "id": 3,
     *              "name": "user",
     *              "display_name": "User",
     *              "description": "Test User",
     *              "created_at": null,
     *              "updated_at": null,
     *              "pivot": {
     *                  "user_id": 544,
     *                  "role_id": 3
     *              }
     *          }
     *      ],
     *      "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg",
     *      "profile_picture": "229f52336e0f40cd60c56af056dd10078f75d909.jpg"
     *      "rental_agency_id": 2,
     *      "rental_agency_name": "Amigo's Car Rental",
     *      "stripe_customer_id": "cus_9kzMsAMTIMjo890"
     *      "facebook_id": null,
     *      "facebook_profile_picture": null,
     *      "google_id": "100834862662018528710",
     *      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *      "configuration": {
     *          "assign_planned_request_time": 120, // min
     *          "max_time_refresh_map": 300, // seg
     *          "request_type_time": 1, // H
     *      }
     *    }
     *  }
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "Unauthenticated."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getUserByField()
     * @apiDescription User Exist
     * @api {POST} user-exist User Exist
     * @apiVersion 1.0.0
     * @apiName User Exist
     * @apiGroup User
     *
     * @apiUse HeadersBasic
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} column        Column of query. <code>email, facebook_id, google_id</code> <label class="label label-warning">required</label>
     * @apiParam {String} value         Value of the column. <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *       "grant_type": "password",
     *       "client_id" : "2",
     *       "client_secret" : "qWwRRBhosN92m9LFWVv0uNTVPYAs3d9Soe0oMDcG",
     *       "lang": "en",
     *       "column": "email",
     *       "value": "test@mail.com",
     *  }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "data": {
     *      "id": "5a54311b-62fb-4e36-b2cb-f82da06b42c3",
     *      "name": "Admin User",
     *      "email": "admin@tera.com",
     *      "phone": "+584241664556",
     *      "country": "Venezuela",
     *      "city": "Caracas",
     *      "gender": "M",
     *      "birth_of_date": "1991-12-09",
     *      "role": "user",
     *      "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg",
     *      "profile_picture": "229f52336e0f40cd60c56af056dd10078f75d909.jpg"
     *      "rental_agency_id": 2,
     *      "rental_agency_name": "Amigo's Car Rental",
     *      "stripe_customer_id": "cus_9kzMsAMTIMjo890"
     *      "facebook_id": null,
     *      "facebook_profile_picture": null,
     *      "google_id": "100834862662018528710",
     *      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *      "configuration": {
     *          "assign_planned_request_time": 120, // min
     *          "max_time_refresh_map": 300, // seg
     *          "request_type_time": 1, // H
     *      }
     *    }
     *  }
     * HTTP/1.1 200 OK
     * {
     *  "message": "Data not found.",
     *  "data": false
     * }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * createRequest()
     * @apiDescription Request
     * @api {POST} rental-request Save Request
     * @apiVersion 1.0.0
     * @apiName Save Request
     * @apiGroup Request
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String}   lang                        Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String}   pickup_address              pick up address <label class="label label-warning">required</label>
     * @apiParam {Date}     pickup_date                 pick up date <code>2016-11-04 14:00:00</code> <label class="label label-warning">required</label>
     * @apiParam {String}   dropoff_address             Drop off address <label class="label label-warning">required</label>
     * @apiParam {Date}     dropoff_date                drop off date <code>2016-11-04 14:00:00</code> <label class="label label-warning">required</label>
     * @apiParam {Integer}  car_classification_id       Classification car Id. <label class="label label-warning">required</label>
     * @apiParam {Integer}  total_days                  Total days <label class="label label-warning">required</label>
     * @apiParam {Numeric}  total_cost                  Total cost <label class="label label-warning">required</label>
     * @apiParam {String}   pickup_address_coordinates  Pick up address coordinates Example: <code>10.4946267,-66.8541056</code> <label class="label label-warning">required</label>
     * @apiParam {String}   dropoff_address_coordinates Drop off address coordinates Example: <code>10.4824091,-66.8151651</code> <label class="label label-warning">required</label>
     * @apiParam {Integer}  [image_id]                  This param is only for requests with custom license
     * @apiParam {Integer}  city_id                     City Id. <label class="label label-warning">required</label>
     * @apiParam {String}   [gate]                      Airport Gate.
     * @apiParam {String}   [discount_code_id]          Discount Code Id. Id returned from service (Get Discount Code) Example: <code>0807cb0a-2072-472b-a338-5b9a749460e1</code>
     * @apiParam {String}   credit_card_id              Credit Card Id Example:<code>card_1A9gREDXMhWrbRsAmd5mDUZR</code> <label class="label label-warning">required</label>
     * @apiParam {String}   time_zone                   Rental Request Time Zone Example: <code>America/Caracas</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "message": "La solicitud ha sido enviada con exito."
     *  }
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en",
     *      "pickup_date" : "2016-11-04 13:00:00",
     *      "dropoff_date" : "2016-11-15 13:00:00",
     *      "car_classification_id" : 3,
     *      "total_days" : 10,
     *      "total_cost" : 299.99,
     *      "pickup_address" : "Edificio Jota Jota, Avenida Francisco de Miranda, Caracas, Distrito Capital",
     *      "dropoff_address" : "Avenida Principal Las Vegas de Petare, Caracas, Miranda",
     *      "pickup_address_coordinates" : "10.4946267,-66.8541056",
     *      "dropoff_address_coordinates" : "10.4824091,-66.8151651",
     *      "image_id" : 2
     *      "city_id" : 1
     *  }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *  "data": [
     *     {
     *        "id": "747e7a4d-9df5-4b38-9c14-40c51ddf1dd2",
     *        "total_cost": 100,
     *        "total_days": 15,
     *        "pickup_address": "Avenida Francisco de Miranda, Caracas, Miranda",
     *        "pickup_address_coordinates": {
     *          "latitude": "10.4824091",
     *          "longitude": "-66.8151651"
     *        },
     *        "pickup_date": "2016-12-19 00:00:00",
     *        "dropoff_address": "Calle yuruani, Caracas, Miranda",
     *        "dropoff_address_coordinates": {
     *          "latitude": "10.4892448",
     *          "longitude": "-66.8063607"
     *        },
     *        "dropoff_date": "2016-12-22 00:00:00",
     *        "type": "standard",
     *        "status": "sent",
     *        "last_agent_coordinate" : null,
     *        "gate": "gate-12",
     *        "blocked_amount": 200,
     *        "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *        "created_at": {
     *          "date": "2017-04-25 15:05:18.000000",
     *          "timezone_type": 3,
     *          "timezone": "UTC"
     *        },
     *        "returned_car": false,
     *        "time_zone": "America/Caracas",
     *        "requestOwner": {
     *              "id": "8424aaf0-173d-48fe-96ae-d9601a112a6b",
     *              "name": "Aalkdj Ajkakak",
     *              "phone": "+584241234997",
     *              "address": "Caracas",
     *              "email": "sdfs@tefsdf.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9uIO81vi8mMhQK"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *        },
     *        "agency": null,
     *        "takenByUser": null,
     *        "takenByManager": null,
     *        "takenByUserDropoff": null,
     *        "classification": {
     *           "id": "cf24217d-7092-45f7-bf1b-3abf3d774a42",
     *           "title": "uPPe",
     *           "description": "Estandard Corollas",
     *           "category": "car",
     *           "type": "standard",
     *           "price_low_season": null,
     *           "price_high_season": null,
     *           "photo": "photo1.jpg"
     *        }
     *        "configurations": {
     *           "assign_planned_request_time": 120, // min
     *           "max_time_refresh_map": 300, // seg
     *           "request_type_time": 1, // H
     *        },
     *        "cancelationReason": null,
     *        "discountCodes" : {
     *          "id" => "cf24217d-7092-45f7-bf1b-3abf3d774b678",
     *          "discount_operation" => "-",
     *          "discount_unit" => "$",
     *          "discount_amount" => "12",
     *        },
     *        "rate": null,
     *        "can_assign": false,
     *        "can_dropoff": false,
     *        "can_extend": true,
     *        "is_extended": false,
     *        "city": "Miami",
     *        "country": "United States"
     *     }
     *   ]
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The pickup address field is required."
     *      or
     *      "message": "The pickup date field is required."
     *      or
     *      "message": "The dropoff address field is required."
     *      or
     *      "message": "The dropoff date field is required."
     *      or
     *      "message": "The car classification id field is required."
     *      or
     *      "message": "The total days field is required."
     *      or
     *      "message": "The total cost field is required."
     *      or
     *      "message": "The credit card token field is required."
     *      or
     *      "message": "You have an active request."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * logout()
     * @apiDescription Logout service
     * @api {POST} logout Logout
     * @apiVersion 1.0.0
     * @apiName User Logout
     * @apiGroup User
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang              Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} user_id           User id. <label class="label label-warning">required</label>
     * @apiParam {String} token_device      Token device.<label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "message": "The session has been closed."
     *  }
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *    "lang": "en",
     *    "user_id" : "5a54311b-62fb-4e36-b2cb-f82da06b42c3",
     *    "token_device": "1234567890",
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad Request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The user id field is required."
     *      or
     *      "message": "The user id field is invalid."
     *      or
     *      "message": "The token device field is required."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getCars()
     * @apiDescription Get Cars Classification
     * @api {GET} cars-clasification Get Cars Classification
     * @apiVersion 1.0.0
     * @apiName Get Cars Classification
     * @apiGroup Cars
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *      ...
     *      {
     *          "id": 1,
     *          "title": "uPPe",
     *          "description": "Estandard Corollas",
     *          "price_low_season": 50,
     *          "price_high_season": 65,
     *          "photo": "photo1.jpg"
     *      }
     *      ...
     *    ]
     *  }
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "Data not found."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getPolicies()
     * @apiDescription Get Policies Available
     * @api {GET} policy Get Policies Available
     * @apiVersion 1.0.0
     * @apiName Get Policies Available
     * @apiGroup Policy
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *      ...
     *      {
     *          "id": 1,
     *          "name": "SSLI",
     *          "description": "Seguro SSLI"
     *      }
     *      ...
     *    ]
     *  }
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "Data not found."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getCities()
     * @apiDescription Get Cities
     * @api {GET} city Get Cities
     * @apiVersion 1.0.0
     * @apiName Get Cities
     * @apiGroup City
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} city          City. <code>miami, bogota, caracas, panama </code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *      ...
     *      {
     *          "id": 1,
     *          "name": "Miami",
     *          "country_id": 1,
     *          "country": "Estados Unidos",
     *          "region": "us",
     *          "short_name": "us",
     *          "pick_up_max_time" : 6,
     *          "max_wait_time" : 2,
     *          "location": {
     *              "latitude": "25°46.4562′ N",
     *              "longitude": "80°11.6196′ O"
     *          }
     *          "polilines": {
     *              ...
     *              "latitude": "25°46.4560′ N",
     *              "longitude": "80°11.6194′ O",
     *              ...
     *          }
     *          "bounds": {
     *              ...
     *              "latitude": "25.45567",
     *              "longitude": "-80.4721",
     *              ...
     *          }
     *      }
     *      ...
     *    ]
     *  }
     * @apiSuccessExample Url-Example:
     *
     *  URL/api/v1/city?city=caracas&lang=es
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The city is required."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data not found."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getCountries()
     * @apiDescription Get Countries
     * @api {GET} countries Get Countries
     * @apiVersion 1.0.0
     * @apiName Get Countries
     * @apiGroup Country
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *      ...
     *      {
     *          "id": 1,
     *          "name": "Estados Unidos",
     *          "name_en": "United States",
     *          "region": "us",
     *          "short_name": "us"
     *      }
     *      ...
     *    ]
     *  }
     * @apiSuccessExample Url-Example:
     *
     *  URL/api/v1/countries?lang=es
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *  }
     *
     * HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data not found."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * updateUser()
     * @apiDescription Update
     * @api {PUT} user/{user_id} Update User
     * @apiVersion 1.0.0
     * @apiName User Update
     * @apiGroup User
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang      Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} name      User name. <label class="label label-warning">required</label>
     * @apiParam {String} [birth_of_date]   User Birth Of Date.
     * @apiParam {String} [country]         User Country.
     * @apiParam {String} [phone]   User phone.
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "message": "The user has been successfully updated."
     *  }
     *
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "es",
     *      "name" : "Victor Roldan",
     *      "phone" : "+584243356988"
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad Request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The phone is required."
     *      or
     *      "message": "The phone is invalid."
     *      or
     *      "message": "Error saving data."
     *      or
     *      "message": "Data not found."
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getRequest()
     * @apiDescription Get Request
     * @api {GET} rental-request/{rental_request} Get Request
     * @apiVersion 1.0.0
     * @apiName Get Request
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *     {
     *         "id": "fe8fa56d-db91-42df-883c-4bd36ee469a8",
     *         "total_cost": 390,
     *         "total_days": 10,
     *         "pickup_address": "West NyahfortTunisia",
     *         "pickup_address_coordinates": {
     *           "latitude": "10.4824091",
     *           "longitude": "-66.8151651"
     *         },
     *         "pickup_date": "2016-11-12 00:59:21",
     *         "dropoff_address": "Lake RoelburghLiechtenstein",
     *         "dropoff_address_coordinates": {
     *           "latitude": "10.4892448",
     *           "longitude": "-66.8063607"
     *         },
     *         "dropoff_date": "Lake RoelburghLiechtenstein",
     *         "type": "standard",
     *         "status": "on-board",
     *         "last_agent_coordinate" : {
     *              "latitude": "24.45567",
     *              "longitude": "-20.4721"
     *          },
     *         "gate": "gate-12",
     *         "blocked_amount": 200,
     *         "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *         "created_at": {
     *           "date": "2017-04-25 15:05:18.000000",
     *           "timezone_type": 3,
     *           "timezone": "UTC"
     *         },
     *        "returned_car": false,
     *        "time_zone": "America/Caracas",
     *         "requestOwner": {
     *             "id": "2572e059-a2a0-4253-9dc6-6d7b75925a2a",
     *             "name": "Bridget Schaefer",
     *             "phone": "+7849636381864",
     *             "address": "274 Ebert Highway Suite 761\nRubenmouth, TX 86949-1377",
     *             "email": "leonie.tillman@example.org",
     *             "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *             "stripe_customer_id": "cus_9rdkzqsp22aKgv"
     *         },
     *         "agency": {
     *             "id": "c7af7ad5-9c88-44e8-a818-96e8d6aa32ab",
     *             "name": "Mr. Rory Schinner V",
     *             "address": "406 Sauer Hill Suite 614\nTownemouth, NH 02097-3916",
     *             "phone": "+3878082445416",
     *             "description": "Dignissimos et nisi illo labore temporibus. Impedit autem qui praesentium enim provident.",
     *             "status": 1
     *         },
     *         "takenByUser": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *        "takenByManager": {
     *              "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *              "name": "Rental Admin",
     *              "phone": null,
     *              "address": null,
     *              "email": "rental@tera.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *         },
     *         "takenByUserDropoff": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *         "classification": {
     *             "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *             "category": "van",
     *             "description": "Estandard Rav 4",
     *             "type": "standard",
     *             "price_low_season": 40,
     *             "price_high_season": 55,
     *             "photo": "photo2.jpg"
     *         },
     *         "cancelationReason": null,
     *         "discountCodes" : null,
     *          "rate": {
     *              "id": "955b3524-ed60-4838-af6d-299c8154c90d",
     *              "rate": 2,
     *              "comment": "Comment"
     *          },
     *         "configurations": {
     *             "assign_planned_request_time": 120,  // min
     *             "max_time_refresh_map": 300, // seg
     *             "request_type_time": 1,  // H
     *             "max_days_by_rental": 21, // d
     *             "extends_request_time": 24, // H
     *         },
     *         "can_assign" : true,
     *         "can_dropoff" : false,
     *        "can_extend": true,
     *        "is_extended": false,
     *         "city": "Miami",
     *         "country": "Estados Unidos"
     *      ]
     *  }
     * @apiSuccessExample Url-Example:
     *
     * URL/api/v1/rental-request/04200d07-efa9-4bcd-bf73-cf537b3e259c?lang=en
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When the request was not found
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * updateRequest()
     * @apiDescription Update Request
     * @api {PUT} update-request/{rental_request_id} Update Request
     * @apiVersion 1.0.0
     * @apiName Update Request
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang                        Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} rental_request_id           Rental Request Id <label class="label label-warning">required</label>
     * @apiParam {String} dropoff_address             New Dropoff Address <label class="label label-warning">required</label>
     * @apiParam {String} dropoff_address_coordinates Drop off address coordinates Example: <code>10.4824091,-66.8151651</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *     {
     *         "id": "fe8fa56d-db91-42df-883c-4bd36ee469a8",
     *         "total_cost": 390,
     *         "total_days": 10,
     *         "pickup_address": "West NyahfortTunisia",
     *         "pickup_address_coordinates": {
     *           "latitude": "10.4824091",
     *           "longitude": "-66.8151651"
     *         },
     *         "pickup_date": "2016-11-12 00:59:21",
     *         "dropoff_address": "Lake RoelburghLiechtenstein",
     *         "dropoff_address_coordinates": {
     *           "latitude": "10.4892448",
     *           "longitude": "-66.8063607"
     *         },
     *         "dropoff_date": "Lake RoelburghLiechtenstein",
     *         "type": "standard",
     *         "status": "on-board",
     *         "last_agent_coordinate" : {
     *              "latitude": "24.45567",
     *              "longitude": "-20.4721"
     *          },
     *         "gate": "gate-12",
     *         "blocked_amount": 200,
     *         "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *         "created_at": {
     *           "date": "2017-04-25 15:05:18.000000",
     *           "timezone_type": 3,
     *           "timezone": "UTC"
     *         },
     *         "returned_car": true,
     *         "time_zone": "America/Caracas",
     *         "requestOwner": {
     *              "id": "8424aaf0-173d-48fe-96ae-d9601a112a6b",
     *              "name": "Aalkdj Ajkakak",
     *              "phone": "+584241234997",
     *              "address": "Caracas",
     *              "email": "sdfs@tefsdf.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9uIO81vi8mMhQK"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *         },
     *         "agency": {
     *             "id": "c7af7ad5-9c88-44e8-a818-96e8d6aa32ab",
     *             "name": "Mr. Rory Schinner V",
     *             "address": "406 Sauer Hill Suite 614\nTownemouth, NH 02097-3916",
     *             "phone": "+3878082445416",
     *             "description": "Dignissimos et nisi illo labore temporibus. Impedit autem qui praesentium enim provident.",
     *             "status": 1
     *         },
     *         "takenByUser": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *        "takenByManager": {
     *              "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *              "name": "Rental Admin",
     *              "phone": null,
     *              "address": null,
     *              "email": "rental@tera.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *         },
     *         "takenByUserDropoff": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "",
     *             "profile_picture": null,
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *         "classification": {
     *             "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *             "category": "van",
     *             "description": "Estandard Rav 4",
     *             "type": "standard",
     *             "price_low_season": 40,
     *             "price_high_season": 55,
     *             "photo": "photo2.jpg"
     *         },
     *         "configurations": {
     *             "assign_planned_request_time": 120,  // min
     *             "max_time_refresh_map": 300, // seg
     *             "request_type_time": 1,  // H
     *             "max_days_by_rental": 21, // d
     *             "extends_request_time": 24, // H
     *         },
     *         "cancelationReason": null,
     *         "discountCodes" : null,
     *         "rate" : null,
     *         "can_assign" : true,
     *         "can_dropoff" : false,
     *         "can_extend": true,
     *         "is_extended": false,
     *         "city": "Miami",
     *         "country": "Estados Unidos"
     *      }
     *    ]
     * }
     *
     * @apiSuccessExample Url-Example:
     *
     * URL/api/v1/update-request/04200d07-efa9-4bcd-bf73-cf537b3e259c
     *
     * Content-Type: application/json
     *  {
     *      "lang" : "en"
     *      "dropoff_address" : "New Address"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The rental_request_id field is required."
     *      or
     *      "message": "The dropoff_address field is required."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When the request was not found
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * extendRental()
     * @apiDescription Extends Request
     * @api {PUT} extend-rental-request/{rental_request_id} Extends Request
     * @apiVersion 1.0.0
     * @apiName Extends Request
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     * @apiParam {String}   lang                        Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String}   dropoff_address             New DropOff Address <label class="label label-warning">required</label>
     * @apiParam {Date}     dropoff_date                New DropOff Date <code>2016-11-04 14:00</code> <label class="label label-warning">required</label>
     * @apiParam {Integer}  total_days                  Total days <label class="label label-warning">required</label>
     * @apiParam {Numeric}  total_cost                  Total cost <label class="label label-warning">required</label>
     * @apiParam {String}   dropoff_address_coordinates New drop off address coordinates Example: <code>10.4824091,-66.8151651</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *     {
     *         "id": "fe8fa56d-db91-42df-883c-4bd36ee469a8",
     *         "total_cost": 390,
     *         "total_days": 10,
     *         "pickup_address": "West NyahfortTunisia",
     *         "pickup_address_coordinates": {
     *           "latitude": "10.4824091",
     *           "longitude": "-66.8151651"
     *         },
     *         "pickup_date": "2016-11-12 00:59:21",
     *         "dropoff_address": "Lake RoelburghLiechtenstein",
     *         "dropoff_address_coordinates": {
     *           "latitude": "10.4892448",
     *           "longitude": "-66.8063607"
     *         },
     *         "dropoff_date": "Lake RoelburghLiechtenstein",
     *         "type": "standard",
     *         "status": "on-board",
     *         "last_agent_coordinate" : {
     *              "latitude": "24.45567",
     *              "longitude": "-20.4721"
     *          },
     *         "gate": "gate-12",
     *         "blocked_amount": 200,
     *         "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *         "created_at": {
     *           "date": "2017-04-25 15:05:18.000000",
     *           "timezone_type": 3,
     *           "timezone": "UTC"
     *         },
     *         "returned_car": false,
     *         "requestOwner": {
     *              "id": "8424aaf0-173d-48fe-96ae-d9601a112a6b",
     *              "name": "Aalkdj Ajkakak",
     *              "phone": "+584241234997",
     *              "address": "Caracas",
     *              "email": "sdfs@tefsdf.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9uIO81vi8mMhQK"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *         },
     *         "agency": {
     *             "id": "c7af7ad5-9c88-44e8-a818-96e8d6aa32ab",
     *             "name": "Mr. Rory Schinner V",
     *             "address": "406 Sauer Hill Suite 614\nTownemouth, NH 02097-3916",
     *             "phone": "+3878082445416",
     *             "description": "Dignissimos et nisi illo labore temporibus. Impedit autem qui praesentium enim provident.",
     *             "status": 1
     *         },
     *         "takenByUser": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *        "takenByManager": {
     *              "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *              "name": "Rental Admin",
     *              "phone": null,
     *              "address": null,
     *              "email": "rental@tera.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *         },
     *         "takenByUserDropoff": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "",
     *             "profile_picture": null,
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *         "classification": {
     *             "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *             "category": "van",
     *             "description": "Estandard Rav 4",
     *             "type": "standard",
     *             "price_low_season": 40,
     *             "price_high_season": 55,
     *             "photo": "photo2.jpg"
     *         },
     *         "configurations": {
     *             "assign_planned_request_time": 120,  // min
     *             "max_time_refresh_map": 300, // seg
     *             "request_type_time": 1,  // H
     *             "max_days_by_rental": 21, // d
     *             "extends_request_time": 24, // H
     *         },
     *         "cancelationReason": null,
     *         "discountCodes" : null,
     *         "rate" : null,
     *         "can_assign" : true,
     *         "can_dropoff" : false,
     *         "can_extend": false,
     *         "is_extended": true,
     *         "city": "Miami",
     *         "country": "Estados Unidos"
     *      }
     *    ]
     * }
     *
     * @apiSuccessExample Url-Example:
     *
     * URL/api/v1/extend-rental-request/04200d07-efa9-4bcd-bf73-cf537b3e259c
     *
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en",
     *      "dropoff_date" : "2016-11-15 13:00",
     *      "dropoff_address" : "Avenida Principal Las Vegas de Petare, Caracas, Miranda",
     *      "total_days" : 10,
     *      "total_cost" : 299.99,
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The rental_request_id field is required."
     *      or
     *      "message": "The dropoff_address field is required."
     *      or
     *      "message": "The dropoff_date field is required."
     *      or
     *      "message": "The total_days field is required."
     *      or
     *      "message": "The total_cost field is required."
     *      or
     *      "message": "This request can't be extended because it's dropoff date is lower than 24 hour(s).",
     *      or
     *      "This request can't be extended because it's new dropoff date is greater than 21 day(s).",
     *      or
     *      "Error saving data.",
     *      or
     *      "This request can't be extended because it's status is invalid.",
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When the request was not found
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * rateExperience()
     * @apiDescription Rate Experience
     * @api {POST} rate-rental-request Rate Experience
     * @apiVersion 1.0.0
     * @apiName Rate Experience
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     * @apiParam {String}   lang                        Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String}   rental_request_id           Rental request to assign agent. <label class="label label-warning">required</label>
     * @apiParam {Integer}  rate                        Rate <code>1 - 5</code> <label class="label label-warning">required</label>
     * @apiParam {String}   [comment]                   Rate comment
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *     {
     *         "id": "fe8fa56d-db91-42df-883c-4bd36ee469a8",
     *         "total_cost": 390,
     *         "total_days": 10,
     *         "pickup_address": "West NyahfortTunisia",
     *         "pickup_address_coordinates": {
     *           "latitude": "10.4824091",
     *           "longitude": "-66.8151651"
     *         },
     *         "pickup_date": "2016-11-12 00:59:21",
     *         "dropoff_address": "Lake RoelburghLiechtenstein",
     *         "dropoff_address_coordinates": {
     *           "latitude": "10.4892448",
     *           "longitude": "-66.8063607"
     *         },
     *         "dropoff_date": "Lake RoelburghLiechtenstein",
     *         "type": "standard",
     *         "status": "on-board",
     *         "last_agent_coordinate" : {
     *              "latitude": "24.45567",
     *              "longitude": "-20.4721"
     *          },
     *         "gate": "gate-12",
     *         "blocked_amount": 200,
     *         "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *         "created_at": {
     *           "date": "2017-04-25 15:05:18.000000",
     *           "timezone_type": 3,
     *           "timezone": "UTC"
     *         },
     *        "returned_car": true,
     *        "time_zone": "America/Caracas",
     *         "requestOwner": {
     *             "id": "2572e059-a2a0-4253-9dc6-6d7b75925a2a",
     *             "name": "Bridget Schaefer",
     *             "phone": "+7849636381864",
     *             "address": "274 Ebert Highway Suite 761\nRubenmouth, TX 86949-1377",
     *             "email": "leonie.tillman@example.org",
     *             "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *             "stripe_customer_id": "cus_9rdkzqsp22aKgv"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *         },
     *         "agency": {
     *             "id": "c7af7ad5-9c88-44e8-a818-96e8d6aa32ab",
     *             "name": "Mr. Rory Schinner V",
     *             "address": "406 Sauer Hill Suite 614\nTownemouth, NH 02097-3916",
     *             "phone": "+3878082445416",
     *             "description": "Dignissimos et nisi illo labore temporibus. Impedit autem qui praesentium enim provident.",
     *             "status": 1
     *         },
     *         "takenByUser": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *        "takenByManager": {
     *              "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *              "name": "Rental Admin",
     *              "phone": null,
     *              "address": null,
     *              "email": "rental@tera.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *         },
     *         "takenByUserDropoff": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "",
     *             "profile_picture": null,
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *         "classification": {
     *             "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *             "category": "van",
     *             "description": "Estandard Rav 4",
     *             "type": "standard",
     *             "price_low_season": 40,
     *             "price_high_season": 55,
     *             "photo": "photo2.jpg"
     *         },
     *         "configurations": {
     *             "assign_planned_request_time": 120,  // min
     *             "max_time_refresh_map": 300, // seg
     *             "request_type_time": 1,  // H
     *             "max_days_by_rental": 21, // d
     *             "extends_request_time": 24, // H
     *         },
     *         "cancelationReason": null,
     *         "discountCodes" : null,
     *         "rate": {
     *              "id": "955b3524-ed60-4838-af6d-299c8154c90d",
     *              "rate": 2,
     *              "comment": "Comment"
     *          },
     *         "can_assign" : true,
     *         "can_dropoff" : false,
     *         "can_extend": false,
     *         "is_extended": true,
     *         "city": "Miami",
     *         "country": "Estados Unidos"
     *      }
     *    ]
     * }
     *
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en",
     *      "rental_request_id" : "4550d306-ba88-427a-9ea8-e064333872f4",
     *      "rate" : 2,
     *      "comment" : "Comment"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The rental_request_id field is required."
     *      or
     *      "message": "The rate field is required."
     *      or
     *      "message": "The comment field is required."
     *      or
     *      "message": "This request can't be rated because its status is invalid.",
     *      or
     *      "This request can't be rated because it has a previous rate.",
     *      or
     *      "Error saving data.",
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When the request was not found
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getSentRequests()
     * @apiDescription Get Sent Requests
     * @api {GET} rental-requests Get Sent Requests
     * @apiVersion 1.0.0
     * @apiName Get Sent Requests
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {Integer} limit        Pagination Limit. <code>1-50</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *         {
     *          "id": "e1f6e1a6-7646-44c4-b0e8-a570253d0f5a",
     *          "total_cost": 1428,
     *          "total_days": 17,
     *          "pickup_address": "West EvaviewMexico",
     *          "pickup_address_coordinates": [],
     *          "pickup_date": "2016-12-10 08:15:10",
     *          "dropoff_address": "North VelmaPoland",
     *          "dropoff_address_coordinates": [],
     *          "dropoff_date": "2016-12-20 02:04:02",
     *          "type": "standard",
     *          "status": "sent",
     *          "last_agent_coordinate" : null,
     *          "gate": "gate-12",
     *          "blocked_amount": 1895,
     *          "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *          "created_at": {
     *            "date": "2017-04-25 15:05:18.000000",
     *            "timezone_type": 3,
     *            "timezone": "UTC"
     *          },
     *          "returned_car": false,
     *          "time_zone": "America/Caracas",
     *          "requestOwner": {
     *             "id": "2572e059-a2a0-4253-9dc6-6d7b75925a2a",
     *             "name": "Bridget Schaefer",
     *             "phone": "+7849636381864",
     *             "address": "274 Ebert Highway Suite 761\nRubenmouth, TX 86949-1377",
     *             "email": "leonie.tillman@example.org",
     *             "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *             "stripe_customer_id": "cus_9rdkzqsp22aKgv"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *          },
     *          "agency": null,
     *          "takenByUser": null,
     *          "takenByManager": null,
     *          "takenByUserDropoff": null,
     *          "classification": {
     *             "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *             "category": "van",
     *             "description": "TOYOTA COROLLA OR SIMILAR",
     *             "type": "standard",
     *             "price_low_season": 40,
     *             "price_high_season": 55,
     *             "photo": "photo2.jpg"
     *          },
     *         "cancelationReason": null,
     *         "discountCodes" : null,
     *         "rate": null,
     *         "configurations": {
     *             "assign_planned_request_time": 120,  // min
     *             "max_time_refresh_map": 300, // seg
     *             "request_type_time": 1,  // H
     *             "max_days_by_rental": 21, // d
     *             "extends_request_time": 24, // H
     *         },
     *          "can_assign" : true,
     *          "can_dropoff" : false,
     *          "can_extend": true,
     *          "is_extended": false,
     *          "city": "Miami",
     *          "country": "Estados Unidos"
     *        },
     *       ...
     * ]
     *    "pagination":
     *      {
     *       "total": 4,
     *       "per_page": 3,
     *       "current_page": 1,
     *       "last_page": 2,
     *       "next_page_url": "http://localhost/uppyx-api/public/api/v1/rental-requests?page=2",
     *       "next_page_number" : 2
     *       "prev_page_url": null
     *      }
     * }
     *
     * @apiSuccessExample Url-Example:
     *
     * URL/api/v1/rental-requests?lang=en
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *  }
     * HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When there are not requests pending to accept
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getRequests()
     * @apiDescription Get Own Requests
     * @api {GET} own-requests Get Own Requests
     * @apiVersion 1.0.0
     * @apiName Get Own Requests
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {Integer} limit        Pagination Limit. <code>1-50</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *         {
     *          "id": "e1f6e1a6-7646-44c4-b0e8-a570253d0f5a",
     *          "total_cost": 1428,
     *          "total_days": 17,
     *          "pickup_address": "West EvaviewMexico",
     *          "pickup_address_coordinates": {
     *              "latitude": "10.4892448",
     *              "longitude": "-66.8063607"
     *          },
     *          "pickup_date": "2016-12-10 08:15:10",
     *          "dropoff_address": "North VelmaPoland",
     *          "dropoff_address_coordinates":{
     *              "latitude": "10.4892448",
     *              "longitude": "-66.8063607"
     *          },
     *          "dropoff_date": "2016-12-20 02:04:02",
     *          "type": "standard",
     *          "status": "finished",
     *          "last_agent_coordinate" : {
     *              "latitude": "10.4892448",
     *              "longitude": "-66.8063607"
     *          },
     *          "gate": "gate-12",
     *          "blocked_amount": 1895,
     *          "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *          "created_at": {
     *            "date": "2017-04-25 15:05:18.000000",
     *            "timezone_type": 3,
     *            "timezone": "UTC"
     *          },
     *          "returned_car": true,
     *          "time_zone": "America/Caracas",
     *          "requestOwner": {
     *             "id": "2572e059-a2a0-4253-9dc6-6d7b75925a2a",
     *             "name": "Bridget Schaefer",
     *             "phone": "+7849636381864",
     *             "address": "274 Ebert Highway Suite 761\nRubenmouth, TX 86949-1377",
     *             "email": "leonie.tillman@example.org",
     *             "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *             "stripe_customer_id": "cus_9rdkzqsp22aKgv"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *          },
     *          "agency": {
     *              "id": "9de3d91a-da6a-43e2-834a-6d4cc5306643",
     *              "name": "Agencia 1",
     *              "address": "Av. 1",
     *              "phone": "+584245464997",
     *              "description": "Agencia 1",
     *              "status": 1
     *          },
     *          "takenByUser": {
     *              "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *              "name": "Teresa Mayert",
     *              "phone": "+9882132994136",
     *              "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *              "email": "ihand@example.org",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *          },
     *          "takenByManager": {
     *              "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *              "name": "Rental Admin",
     *              "phone": null,
     *              "address": null,
     *              "email": "rental@tera.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *          },
     *          "takenByUserDropoff": {
     *             "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *             "name": "Teresa Mayert",
     *             "phone": "+9882132994136",
     *             "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *             "email": "ihand@example.org",
     *             "license_picture": "",
     *             "profile_picture": null,
     *             "facebook_id": null,
     *             "facebook_profile_picture": null,
     *             "google_id": "100834862662018528710",
     *             "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *         },
     *         "classification": {
     *             "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *             "category": "van",
     *             "description": "TOYOTA COROLLA OR SIMILAR",
     *             "type": "standard",
     *             "price_low_season": 40,
     *             "price_high_season": 55,
     *             "photo": "photo2.jpg"
     *          },
     *         "cancelationReason": null,
     *         "discountCodes" : null,
     *         "rate": null,
     *         "configurations": {
     *             "assign_planned_request_time": 120,  // min
     *             "max_time_refresh_map": 300, // seg
     *             "request_type_time": 1,  // H
     *             "max_days_by_rental": 21, // d
     *             "extends_request_time": 24, // H
     *         },
     *          "can_assign" : false,
     *          "can_dropoff" : false,
     *          "can_extend": true,
     *          "is_extended": false,
     *          "city": "Miami",
     *          "country": "Estados Unidos"
     *       },
     *       ...
     *     ]
     *     "pagination":
     *      {
     *       "total": 4,
     *       "per_page": 3,
     *       "current_page": 1,
     *       "last_page": 2,
     *       "next_page_url": "http://localhost/uppyx-api/public/api/v1/own-requests?page=2",
     *       "next_page_number" : 2
     *       "prev_page_url": null
     *      }
     * }
     *
     * @apiSuccessExample Url-Example:
     *
     * URL/api/v1/own-requests?lang=en&limit=1
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The limit is required."
     *  }
     * HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When there are not requests
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getDropOffRequests()
     * @apiDescription Get Dropoff Requests
     * @api {GET} dropoff-request Get Dropoff Requests
     * @apiVersion 1.0.0
     * @apiName Get Dropoff Requests
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": {
     *         "on-board": [
     *              {
     *                  "id": "e1f6e1a6-7646-44c4-b0e8-a570253d0f5a",
     *                  "total_cost": 1428,
     *                  "total_days": 17,
     *                  "pickup_address": "West EvaviewMexico",
     *                  "pickup_address_coordinates": [],
     *                  "pickup_date": "2016-12-10 08:15:10",
     *                  "dropoff_address": "North VelmaPoland",
     *                  "dropoff_address_coordinates": [],
     *                  "dropoff_date": "2016-12-20 02:04:02",
     *                  "type": "standard",
     *                  "status": "on-board",
     *                  "last_agent_coordinate" : {
     *                      "latitude": "24.45567",
     *                      "longitude": "-20.4721"
     *                  },
     *                  "gate": "gate-12",
     *                  "blocked_amount": 1895,
     *                  "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *                  "created_at": {
     *                    "date": "2017-04-25 15:05:18.000000",
     *                    "timezone_type": 3,
     *                    "timezone": "UTC"
     *                  },
     *                  "returned_car": true,
     *                  "time_zone": "America/Caracas",
     *                  "requestOwner": {
     *                      "id": "2572e059-a2a0-4253-9dc6-6d7b75925a2a",
     *                      "name": "Bridget Schaefer",
     *                      "phone": "+7849636381864",
     *                      "address": "274 Ebert Highway Suite 761\nRubenmouth, TX 86949-1377",
     *                      "email": "leonie.tillman@example.org",
     *                      "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *                      "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                      "stripe_customer_id": "cus_9rdkzqsp22aKgv"
     *                      "birth_of_date": "1990-12-10"
     *                      "country": "Venezuela"
     *                  },
     *                  "agency": {
     *                      "id": "c7af7ad5-9c88-44e8-a818-96e8d6aa32ab",
     *                      "name": "Mr. Rory Schinner V",
     *                      "address": "406 Sauer Hill Suite 614\nTownemouth, NH 02097-3916",
     *                      "phone": "+3878082445416",
     *                      "description": "Dignissimos et nisi illo labore temporibus. Impedit autem qui praesentium.",
     *                      "status": 1
     *                  },
     *                  "takenByUser": {
     *                      "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *                      "name": "Teresa Mayert",
     *                      "phone": "+9882132994136",
     *                      "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *                      "email": "ihand@example.org",
     *                      "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *                      "profile_picture": null,
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                  },
     *                  "takenByManager": {
     *                      "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *                      "name": "Rental Admin",
     *                      "phone": null,
     *                      "address": null,
     *                      "email": "rental@tera.com",
     *                      "license_picture": "",
     *                      "profile_picture": null,
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                      "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *                  },
     *                  "takenByUserDropoff": {
     *                      "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *                      "name": "Teresa Mayert",
     *                      "phone": "+9882132994136",
     *                      "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *                      "email": "ihand@example.org",
     *                      "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *                      "profile_picture": null,
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                  },
     *                  "classification": {
     *                      "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *                      "category": "van",
     *                      "description": "TOYOTA COROLLA OR SIMILAR",
     *                      "type": "standard",
     *                      "price_low_season": 40,
     *                      "price_high_season": 55,
     *                      "photo": "photo2.jpg"
     *                  },
     *                  "cancelationReason": null,
     *                  "discountCodes" : null,
     *                  "rate": null,
     *                  "configurations": {
     *                      "assign_planned_request_time": 120,  // min
     *                      "max_time_refresh_map": 300, // seg
     *                      "request_type_time": 1,  // H
     *                  },
     *                  "can_assign" : true,
     *                  "can_dropoff" : true,
     *                  "can_extend": true,
     *                  "is_extended": false,
     *                  "city": "Miami",
     *                  "country": "Estados Unidos"
     *              },
     *              ...
     *       ],
     *      "taken-user-dropoff": [],
     *      "returned-car": [],
     *      "finished": []
     *  }
     * }
     *
     * @apiSuccessExample Url-Example:
     *
     * URL/api/v1/rental-requests?lang=en
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *  }
     * HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When there are not requests pending to accept
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getAcceptedRequests()
     * @apiDescription Get Accepted Requests
     * @api {GET} accepted-request Get Accepted Requests
     * @apiVersion 1.0.0
     * @apiName Get Accepted Requests
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": {
     *          "taken-manager": [
     *              {
     *                  "id": "433da0ce-c961-4f28-a5fa-8950bd44e609",
     *                  "total_cost": 1010,
     *                  "total_days": 10,
     *                  "pickup_address": "KathrynportLiechtenstein",
     *                  "pickup_address_coordinates": [],
     *                  "pickup_date": "2016-12-10 07:13:38",
     *                  "dropoff_address": "AngelochesterComoros",
     *                  "dropoff_address_coordinates": [],
     *                  "dropoff_date": "2016-12-17 14:08:55",
     *                  "type": "standard",
     *                  "status": "taken-manager",
     *                  "last_agent_coordinate" : null,
     *                  "gate": "gate-12",
     *                  "blocked_amount": 1895,
     *                  "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *                  "created_at": {
     *                    "date": "2017-04-25 15:05:18.000000",
     *                    "timezone_type": 3,
     *                    "timezone": "UTC"
     *                  },
     *                  "returned_car": false,
     *                  "time_zone": "America/Caracas",
     *                  "requestOwner": {
     *                      "id": "2572e059-a2a0-4253-9dc6-6d7b75925a2a",
     *                      "name": "Bridget Schaefer",
     *                      "phone": "+7849636381864",
     *                      "address": "274 Ebert Highway Suite 761\nRubenmouth, TX 86949-1377",
     *                      "email": "leonie.tillman@example.org",
     *                      "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *                      "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                      "stripe_customer_id": "cus_9rdkzqsp22aKgv"
     *                      "birth_of_date": "1990-12-10"
     *                      "country": "Venezuela"
     *                  },
     *                  "agency": {
     *                      "id": "c7af7ad5-9c88-44e8-a818-96e8d6aa32ab",
     *                      "name": "Mr. Rory Schinner V",
     *                      "address": "406 Sauer Hill Suite 614\nTownemouth, NH 02097-3916",
     *                      "phone": "+3878082445416",
     *                      "description": "Dignissimos et nisi illo labore temporibus. Impedit autem qui praesentium.",
     *                      "status": 1
     *                  },
     *                  "takenByUser": {
     *                      "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *                      "name": "Teresa Mayert",
     *                      "phone": "+9882132994136",
     *                      "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *                      "email": "ihand@example.org",
     *                      "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *                      "profile_picture": null,
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                  },
     *                  "takenByManager": {
     *                        "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *                        "name": "Rental Admin",
     *                        "phone": null,
     *                        "address": null,
     *                        "email": "rental@tera.com",
     *                        "license_picture": "",
     *                        "profile_picture": null,
     *                        "facebook_id": null,
     *                        "facebook_profile_picture": null,
     *                        "google_id": "100834862662018528710",
     *                        "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                        "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *                   },
     *                  "takenByUserDropoff": {
     *                      "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *                      "name": "Teresa Mayert",
     *                      "phone": "+9882132994136",
     *                      "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *                      "email": "ihand@example.org",
     *                      "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *                      "profile_picture": null,
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                  },
     *                  "classification": {
     *                      "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *                      "category": "van",
     *                      "description": "TOYOTA COROLLA OR SIMILAR",
     *                      "type": "standard",
     *                      "price_low_season": 40,
     *                      "price_high_season": 55,
     *                      "photo": "photo2.jpg"
     *                  },
     *                  "cancelationReason" : null
     *                  "configurations": {
     *                      "assign_planned_request_time": 120,  // min
     *                      "max_time_refresh_map": 300, // seg
     *                      "request_type_time": 1,  // H
     *                  },
     *                  "can_assign" : true,
     *                  "can_dropoff" : false,
     *                  "can_extend": true,
     *                  "is_extended": false,
     *                  "city": "Miami",
     *                  "country": "Estados Unidos"
     *              },
     *              ...
     *        ],
     *        "taken-user": [],
     *        "on-way": [],
     *        "checking": [],
     *        "on-board": [],
     *        "cancelled": [
     *              {
     *                  "id": "433da0ce-c961-4f28-a5fa-8950bd44e609",
     *                  "total_cost": 1010,
     *                  "total_days": 10,
     *                  "pickup_address": "KathrynportLiechtenstein",
     *                  "pickup_address_coordinates": [],
     *                  "pickup_date": "2016-12-10 07:13:38",
     *                  "dropoff_address": "AngelochesterComoros",
     *                  "dropoff_address_coordinates": [],
     *                  "dropoff_date": "2016-12-17 14:08:55",
     *                  "type": "standard",
     *                  "status": "cancelled",
     *                  "last_agent_coordinate" : {
     *                      "latitude": "24.45567",
     *                      "longitude": "-20.4721"
     *                  },
     *                  "gate": "gate-12",
     *                  "blocked_amount": 1895,
     *                  "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *                  "created_at": {
     *                    "date": "2017-04-25 15:05:18.000000",
     *                    "timezone_type": 3,
     *                    "timezone": "UTC"
     *                  },
     *                  "returned_car": false,
     *                  "time_zone": "America/Caracas",
     *                  "requestOwner": {
     *                      "id": "2572e059-a2a0-4253-9dc6-6d7b75925a2a",
     *                      "name": "Bridget Schaefer",
     *                      "phone": "+7849636381864",
     *                      "address": "274 Ebert Highway Suite 761\nRubenmouth, TX 86949-1377",
     *                      "email": "leonie.tillman@example.org",
     *                      "license_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *                      "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                      "stripe_customer_id": "cus_9rdkzqsp22aKgv"
     *                      "birth_of_date": "1990-12-10"
     *                      "country": "Venezuela"
     *                  },
     *                  "agency": {
     *                      "id": "c7af7ad5-9c88-44e8-a818-96e8d6aa32ab",
     *                      "name": "Mr. Rory Schinner V",
     *                      "address": "406 Sauer Hill Suite 614\nTownemouth, NH 02097-3916",
     *                      "phone": "+3878082445416",
     *                      "description": "Dignissimos et nisi illo labore temporibus. Impedit autem qui praesentium.",
     *                      "status": 1
     *                  },
     *                  "takenByUser": {
     *                      "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *                      "name": "Teresa Mayert",
     *                      "phone": "+9882132994136",
     *                      "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *                      "email": "ihand@example.org",
     *                      "license_picture": "1237c84b75da988635d3995859688041bda9d699.jpg"
     *                      "profile_picture": "9737c84b75da988635d3995859688041bda9d679.jpg"
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                  },
     *                  "takenByManager": {
     *                        "id": "e60aad14-7941-4c53-84de-f7d8587f89c9",
     *                        "name": "Rental Admin",
     *                        "phone": null,
     *                        "address": null,
     *                        "email": "rental@tera.com",
     *                        "license_picture": "",
     *                        "profile_picture": null,
     *                        "facebook_id": null,
     *                        "facebook_profile_picture": null,
     *                        "google_id": "100834862662018528710",
     *                        "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                        "stripe_customer_id": "cus_9kz7Wz8kSFBLrZ"
     *                   },
     *                  "takenByUserDropoff": {
     *                      "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *                      "name": "Teresa Mayert",
     *                      "phone": "+9882132994136",
     *                      "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *                      "email": "ihand@example.org",
     *                      "license_picture": "",
     *                      "profile_picture": null,
     *                      "facebook_id": null,
     *                      "facebook_profile_picture": null,
     *                      "google_id": "100834862662018528710",
     *                      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *                  },
     *                  "classification": {
     *                      "id": "d3c8115e-82f8-4fd6-8566-e111cae34255",
     *                      "category": "van",
     *                      "description": "TOYOTA COROLLA OR SIMILAR",
     *                      "type": "standard",
     *                      "price_low_season": 40,
     *                      "price_high_season": 55,
     *                      "photo": "photo2.jpg"
     *                  },
     *                  "cancelationReason": {
     *                      "id": "56e3dfeb-355c-422b-92f3-fde6040d5ac0",
     *                      "reason": "El usuario no tiene los documentos requeridos",
     *                      "comment": "Comment"
     *                  },
     *                  "configurations": {
     *                      "assign_planned_request_time": 120,  // min
     *                      "max_time_refresh_map": 300, // seg
     *                      "request_type_time": 1,  // H
     *                  },
     *                  "can_assign" : true,
     *                  "can_dropoff" : false,
     *                  "can_extend": true,
     *                  "is_extended": false,
     *                  "city": "Miami",
     *                  "country": "Estados Unidos"
     *              },
     *              ...
     *        ]
     *     }
     * }
     *
     * @apiSuccessExample Url-Example:
     *
     *  URL/api/v1/accepted-request?lang=en
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When there are not requests accepted
     *      or
     *      "message": "Deny access." When user has not permission to access to this service
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getAssignedRequests()
     * @apiDescription Get Assigned Requests
     * @api {GET} assigned-request Get Assigned Requests
     * @apiVersion 1.0.0
     * @apiName Get Assigned Requests
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} status        Language of application. <code>taken-user/taken-user-dropoff</code>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *        {
     *          "id": "88a219e4-c4d5-4061-9c3c-beecda965a2a",
     *          "total_cost": 150,
     *          "total_days": 1,
     *          "pickup_address": "Avenida Avenida, Caracas, Miranda",
     *          "pickup_address_coordinates": {
     *              "latitude": "10.4892448",
     *              "longitude": "-66.8063607"
     *          },
     *          "pickup_date": "2017-01-18 17:55:00",
     *          "dropoff_address": "Avenida Avenida, Miranda, Miranda",
     *          "dropoff_address_coordinates": {
     *              "latitude": "10.4824091",
     *              "longitude": "-66.8151651"
     *          },
     *          "dropoff_date": "2017-01-19 17:55:00",
     *          "type": "standard",
     *          "status": "taken-user",
     *          "last_agent_coordinate" : null,
     *          "gate": "gate-12",
     *          "blocked_amount": 150,
     *          "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *          "created_at": {
     *              "date": "2017-04-25 15:05:18.000000",
     *              "timezone_type": 3,
     *              "timezone": "UTC"
     *          },
     *          "returned_car": false,
     *          "time_zone": "America/Caracas",
     *          "requestOwner": {
     *              "id": "8424aaf0-173d-48fe-96ae-d9601a112a6b",
     *              "name": "Aalkdj Ajkakak",
     *              "phone": "+584241234997",
     *              "address": "Caracas",
     *              "email": "sdfs@tefsdf.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9uIO81vi8mMhQK"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *          },
     *          "agency": {
     *              "id": "69db06c6-6b34-41ed-aa21-9ae8ca1cbefb",
     *              "name": "Hilpert, Hagenes and Purdy",
     *              "address": "757 Kreiger Stravenue Suite 823\nNorth Lizeth, MA 55267",
     *              "phone": "+5966343317659",
     *              "description": "Iure quas quae ab ea. Exercitationem consequatur voluptatum cum magni molestiae nemo",
     *              "status": 1
     *          },
     *          "takenByUser": {
     *              "id": "53e97f51-76f1-4f81-bad3-93d136493c7e",
     *              "name": "Aasdf Aasda",
     *              "phone": "+584241664997",
     *              "address": "Caracas",
     *              "email": "asddcas@asdad.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *          },
     *          "takenByManager": {
     *              "id": "baa6e25c-f134-4f78-9343-80ce8f0bed0d",
     *              "name": "Aasd Tasdf",
     *              "phone": "+584241554698",
     *              "address": "Caracas",
     *              "email": "sdfsdf@dsfsf.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9uIKnO1DtPZ6lh"
     *          },
     *          "takenByUserDropoff": {
     *              "id": "93ca5686-375f-4471-8a33-2e15f8fe7a77",
     *              "name": "Teresa Mayert",
     *              "phone": "+9882132994136",
     *              "address": "7421 Caitlyn Courts\nPort Thadberg, ID 09834",
     *              "email": "ihand@example.org",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *           },
     *          "classification": {
     *              "id": "95f74e2c-cf22-437b-9fbf-1a15e263bdfd",
     *              "title": "TOYOTA COROLLA",
     *              "description": "Estandard Corollas",
     *              "category": "car",
     *              "type": "standard",
     *              "price_low_season": null,
     *              "price_high_season": null,
     *              "photo": "photo1.jpg"
     *          },
     *          "cancelationReason": null,
     *          "discountCodes" : null,
     *          "rate": null,
     *          "configurations": {
     *              "assign_planned_request_time": 120,  // min
     *              "max_time_refresh_map": 300, // seg
     *              "request_type_time": 1,  // H
     *          },
     *          "can_assign" : true,
     *          "can_dropoff" : false,
     *          "can_extend": true,
     *          "is_extended": false,
     *          "city": "Miami",
     *          "country": "Estados Unidos"
     *       ...
     *      }
     *    ],
     *    "pagination": null
     * }
     *
     * @apiSuccessExample Url-Example:
     *
     *  URL/api/v1/assigned-request?lang=en         When status is taken-user
     *  or
     *  URL/api/v1/assigned-request?status=taken-user-dropoff&lang=en           When status is taken-user-dropoff
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When there is not request assigned
     *      or
     *      "message": "Deny access." When user has not permission to access to this service
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getAgentsList()
     * @apiDescription Get Agents
     * @api {GET} agents-list Get Agents
     * @apiVersion 1.0.0
     * @apiName Get Agents
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 Ok
     *  {
     *    "data": [
     *      ...
     *      {
     *      "id": "53cbcf63-0aa0-41d2-b53f-c17c1ad5ee27",
     *      "name": "Daren Keebler",
     *      "email": "9557.marguerite47@example.net",
     *      "phone": "+1033719914302",
     *      "access_token": null,
     *      "license_picture": "",
     *      "profile_picture": null,
     *      "facebook_id": null,
     *      "facebook_profile_picture": null,
     *      "google_id": "100834862662018528710",
     *      "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *      "rental_agency_id": 2,
     *      "rental_agency_name": "Hilpert, Hagenes and Purdy",
     *      "stripe_customer_id": null
     *      "created_at": "2016-12-08",
     *      "updated_at": "2016-12-08"
     *      },
     *      ...
     *    ]
     *  }
     * @apiSuccessExample Url-Example:
     *
     *  URL/api/v1/agents-list?lang=en
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The selected lang is invalid."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "There aren't agents available." When there is not agents available
     *      or
     *      "message": "Deny access." When user has not permission to access to this service
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * assignRequest()
     * @apiDescription Assign Request
     * @api {POST} assign-request Assign Request
     * @apiVersion 1.0.0
     * @apiName Assign Request
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang              Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} user_id           User Agent Id. <label class="label label-warning">required</label>
     * @apiParam {String} rental_request_id Rental request to assign agent. <label class="label label-warning">required</label>
     * @apiParam {String} status            Status. Valid status: <code>taken-user,taken-user-dropoff</code><label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "message": "The request has been updated successfully."
     *  }
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en"
     *      "rental_request_id" :"7ce67b90-e3e6-4823-b27c-549e1910f4a5",
     *      "user_id" : "53cbcf63-0aa0-41d2-b53f-c17c1ad5ee27"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The rental_request_id field is required."
     *      or
     *      "message": "The selected rental_request_id is invalid."
     *      or
     *      "message": "The user_id field is required."
     *      or
     *      "message": "The selected user_id is invalid."
     *      or
     *      "message": "The agent selected is busy."
     *      or
     *      "message": "The agent selected is not in correct agency."
     *      or
     *      "message": "This request can't be assigned because it's pickup date is greater than 24 hours."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Deny access." When user has not permission to access to this service
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * cancelRequest()
     * @apiDescription Cancel Request Cron
     * @api {GET} cancel-rental-request Cancel Request Cron
     * @apiVersion 1.0.0
     * @apiName Cancel Rental Request Cron
     * @apiGroup Request
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "message": "The requests has been successfully deleted."
     *     or
     *    "message": "There aren't requests to cancel."
     *  }
     * @apiSuccessExample Url-Example:
     *
     *  URL/api/v1/cancel-rental-request?lang=en
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *  }
     *
     * @apiUse responseOauth
     *
     */


    /**
     * changeStatusRequestById()
     * @apiDescription Change Request Status
     * @api {POST} change-request-status/{rental_request_id} Change Request Status
     * @apiVersion 1.0.0
     * @apiName Change Request Status
     * @apiGroup Request
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang              Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} status            New status for request. Valid status: <code>sent,taken-manager,taken-user,finished,on-way,on-board,checking,taken-user-dropoff,returned-car,cancelled-system,cancelled-app,cancelled</code> <label class="label label-warning">required</label>
     * @apiParam {String} rental_request_id This param is passed by URL string. <label class="label label-warning">required</label>
     * @apiParam {String} latitude          Latitude coordinate. This param is required only when status = "on-way". <label class="label label-warning">required</label>
     * @apiParam {String} longitude         Latitude longitude. This param is required only when status = "on-way". <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "message": "The request has been updated successfully." | "title" : "RequestStatusChanged"
     *  }
     *
     *  HTTP/1.1 200 OK
     *  {
     *    1. RRFutureStatus = 'cancelled-app'
     *      1.1 RRPresentStatus = 'taken-manager or taken-user or on-way or on-board'
     *          {
     *              "data": [
     *                  {
     *                      "id": "fe8fa56d-db91-42df-883c-4bd36ee469a8",
     *                      "total_cost": 150,
     *                      "total_days": 1,
     *                      "pickup_address": "Avenida Avenida, Caracas, Miranda",
     *                      "pickup_address_coordinates": {
     *                          "latitude": "10.4892448",
     *                          "longitude": "-66.8063607"
     *                      },
     *                      "pickup_date": "2017-01-18 17:55:00",
     *                      "dropoff_address": "Avenida Avenida, Miranda, Miranda",
     *                      "dropoff_address_coordinates": {
     *                          "latitude": "10.4824091",
     *                          "longitude": "-66.8151651"
     *                      },
     *                      "dropoff_date": "2017-01-19 17:55:00",
     *                      "type": "standard",
     *                      "status": "taken-user",
     *                      "last_agent_coordinate" : null,
     *                      "gate": "gate-12",
     *                      "blocked_amount": 150,
     *                      ...
     *                  }
     *              ]
     *          }
     *  }
     *
     *  HTTP/1.1 200 OK
     *  {
     *      1.2 RRPresentStatus = 'sent'
     *          "message": "The request has been updated successfully." | "title" : "RequestStatusChanged"
     *  }
     *
     *  HTTP/1.1 200 OK
     *  {
     *      1.3 RRPresentStatus = 'cancelled or cancelled-system'
     *          "message": "The request was cancelled." | "title" : "RequestCancelled"
     *  }
     *
     *  HTTP/1.1 200 OK
     *  {
     *    2. RRPresentStatus = 'cancelled-app or cancelled-system' RRFutureStatus = 'cancelled'
     *          "message": "The request was cancelled." | "title" : "RequestCancelled"
     *  }
     *
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en"
     *      "status": "cancelled"
     *  }
     *  Content-Type: application/json
     *  {
     *      "lang" : "en"
     *      "status": "on-way"
     *      "latitude" : "10.4892448, -66.8063607",
     *      "longitude" : "10.4892448, -66.8063607"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *
     *      "message": "The language of application is required." | "title" : "Validation Failed"
     *      or
     *      "message": "The status field is required." | "title" : "Validation Failed"
     *      or
     *      "message": "The selected status is invalid." | "title" : "Validation Failed"
     *      or
     *      "message": "The field latitude is required when status is on-way" | "title" : "Validation Failed"
     *      or
     *      "message": "The field longitude is required when status is on-way" | "title" : "Validation Failed"
     *  }
     *
     *  HTTP/1.1 400 Bad request
     *  {
     *      1. RRPresentStatus = 'on-way' && RRFutureStatus = 'cancelled'
     *
     *          "message": "The request has not payment associated." | "title" : "RequestWithoutPayment"
     *  }
     *
     *  HTTP/1.1 400 Bad request
     *  {
     *      2. RRPresentStatus = 'taken-manager or taken-user' && RRFutureStatus = 'cancelled' && RRType = 'standard'
     *
     *          "message": "The request has not payment associated." | "title" : "RequestWithoutPayment"
     *  }
     *
     *  HTTP/1.1 400 Bad request
     *  {
     *      3. RRPresentStatus = 'sent' && RRFutureStatus = 'taken-manager'
     *
     *          "message": "Your agency does not have agents." | "title" : "AgencyWithoutAgents"
     *          or
     *          "message": "Check the availability of your agents." | "title" : "AgencyWithoutAgents"
     *          or
     *          "message": "There are planned requests to assign." | "title" : "UnassignedRequests"
     *          or
     *          "message": "Invalid Request." | "title" : "InvalidRequest"
     *  }

     *  HTTP/1.1 400 Bad request
     *  {
     *      4. RRPresentStatus != 'taken-user' && RRFutureStatus = 'on-way'
     *
     *          "message": "Your agency does not have agents." | "title" : "RequestCancelled"
     *          or
     *          "message": "Check the availability of your agents." | "title" : "RequestCancelledForApp" | RRPresentStatus = 'cancelled-app'
     *          or
     *          "message": "There are planned requests to assign." | "title" : "RequestCancelledForSystem" | RRPresentStatus = 'cancelled-system'
     *          or
     *          "message": "Invalid Request." | "title" : "RequestTaken" | RRPresentStatus = 'taken-user or taken-manager or on-board or on-way'
     *          or
     *          "message": "The request has not been taken." | "title" : "RequestNotTaken" | RRPresentStatus = 'sent'
     *
     *  }
     *
     *  HTTP/1.1 400 Bad request
     *  {
     *      5. RRPresentStatus != 'checking', 'on-board', 'taken-user-drop', 'returned-car', 'finished' && RRFutureStatus = 'cancelled'
     *
     *          "message": "The request can't be cancelled" | "title" : "InvalidCancellation"
     *  }
     *
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data Not Found." When the request was not found
     *      or
     *      "message": "Deny access." When user has not permission to access to this service
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getSummary()
     * @apiDescription Get Summary
     * @api {POST} summary Get Summary
     * @apiVersion 1.0.0
     * @apiName Get Summary
     * @apiGroup Request
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} pickup_date   Pick-up date. <code>format: yyyy-mm-dd hh:mm</code> <label class="label label-warning">required</label>
     * @apiParam {String} dropoff_date  Drop-off date. <code>format: yyyy-mm-dd hh:mm</code> <label class="label label-warning">required</label>
     * @apiParam {Integer} country      Country id. <label class="label label-warning">required</label>
     * @apiParam {Integer} city         City id. <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "data": {
     *      ...
     *      {
     *        "car_classification": {
     *          "id": 1,
     *          "uuid": 9f6e7465-0816-4c16-afcb-f672b43606f7,
     *          "title": null,
     *          "description": "Estandard Corollas",
     *          "category": "car",
     *          "type": "standard"
     *        },
     *        "days": 2,
     *        "daily_cost_car": 75.5,
     *        "daily_cost": [
     *          ...
     *          {
     *            "alias": "surcharge",
     *            "value": 2,
     *            "description": "Surcharge"
     *          },
     *          ...
     *        ],
     *        "total_charges": [
     *          {
     *            "alias": "rental-day",
     *            "value": 850,
     *            "description": "Rental Day(s) 10d"
     *          },
     *          {
     *            "alias": "surcharge",
     *            "value": 4,
     *            "description": "Surcharge"
     *          },
     *          ...
     *        ],
     *        "subtotal": 144,
     *        "tax": "7%",
     *        "sales_tax": 10.08,
     *        "total": 151
     *        "valid_from": "2017-01-01 00:00"
     *        "valid_to": "2017-06-30 00:00"
     *        "city": 1
     *      },
     *      ...
     *    ]
     *  }
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "pickup_date": "2016-12-10 14:00",
     *      "dropoff_date" : "2016-12-20 14:00",
     *      "country" : 1,
     *      "city" : 1,
     *      "lang" : "en"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The language of application is required."
     *      or
     *      "message": "The country is required."
     *      or
     *      "message": "The city is required."
     *      or
     *      "message": "Invalid drop-off."
     *      or
     *      "message": "Data Not Found."
     *  }
     *  HTTP/1.1 404 Bad request
     *  {
     *      "message": "Data no found." When the rate was not found
     *      or
     *      "message": "Deny access." When user has not permission to access to this service
     *  }
     *
     * @apiUse responseOauth
     *
     */


    /**
     * currentRequestByUser()
     * @apiDescription Current Request
     * @api {GET} current-request/{user_id} Current Request
     * @apiVersion 1.0.0
     * @apiName Current Request
     * @apiGroup Request
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} lang      Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} user_id   User Id <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Url-Example:
     *
     *  URL/api/v1/current-request/d9df9874-5421-495f-9883-6a7f61b4d016?lang=en
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *  "data": [
     *     {
     *        "id": "747e7a4d-9df5-4b38-9c14-40c51ddf1dd2",
     *        "total_cost": 100,
     *        "total_days": 15,
     *        "pickup_address": "Avenida Francisco de Miranda, Caracas, Miranda",
     *        "pickup_address_coordinates": {
     *          "latitude": "10.4824091",
     *          "longitude": "-66.8151651"
     *        },
     *        "pickup_date": "2016-12-19 00:00:00",
     *        "dropoff_address": "Calle yuruani, Caracas, Miranda",
     *        "dropoff_address_coordinates": {
     *          "latitude": "10.4892448",
     *          "longitude": "-66.8063607"
     *        },
     *        "dropoff_date": "2016-12-22 00:00:00",
     *        "type": "standard",
     *        "status": "taken-manager",
     *        "last_agent_coordinate" : null,
     *        "gate": "gate-12",
     *        "blocked_amount": 200,
     *        "credit_card_id": "card_1A9gREDXMhWrbRsAmd5mDUZR",
     *        "created_at": {
     *          "date": "2017-04-25 15:05:18.000000",
     *          "timezone_type": 3,
     *          "timezone": "UTC"
     *        },
     *        "returned_car": false,
     *        "time_zone": "America/Caracas",
     *        "requestOwner": {
     *              "id": "8424aaf0-173d-48fe-96ae-d9601a112a6b",
     *              "name": "Aalkdj Ajkakak",
     *              "phone": "+584241234997",
     *              "address": "Caracas",
     *              "email": "sdfs@tefsdf.com",
     *              "license_picture": "",
     *              "profile_picture": null,
     *              "facebook_id": null,
     *              "facebook_profile_picture": null,
     *              "google_id": "100834862662018528710",
     *              "google_profile_picture": "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50",
     *              "stripe_customer_id": "cus_9uIO81vi8mMhQK"
     *             "birth_of_date": "1990-12-10"
     *             "country": "Venezuela"
     *        },
     *        "agency": {
     *           "id": "021b5e52-98ae-4da8-9d89-dc3556dda9cd",
     *           "name": "Hattie Effertz",
     *           "address": "7654 Funk Squares Apt. 093 Shanahanland, AR 93089",
     *           "phone": "+4183140037567",
     *           "description": "agency description",
     *           "status": 1
     *        },
     *        "takenByUser": {
     *           "id": "8e9c8d15-e1b6-46a8-8161-d95007e8437e",
     *           "name": "Agent User",
     *           "phone": +584245693845,
     *           "address": "test address",
     *           "email": "agent@tera.com",
     *           "license_picture": ""
     *        },
     *        "classification": {
     *           "id": "cf24217d-7092-45f7-bf1b-3abf3d774a42",
     *           "title": "uPPe",
     *           "description": "Estandard Corollas",
     *           "category": "car",
     *           "type": "standard",
     *           "price_low_season": null,
     *           "price_high_season": null,
     *           "photo": "photo1.jpg"
     *        },
     *        "cancelationReason": null,
     *        "discountCodes" : {
     *          "id" => "cf24217d-7092-45f7-bf1b-3abf3d774b678",
     *          "discount_operation" => "-",
     *          "discount_unit" => "$",
     *          "discount_amount" => "12",
     *        } ,
     *        "rate": null,
     *        "configurations": {
     *             "assign_planned_request_time": 120,  // min
     *             "max_time_refresh_map": 300, // seg
     *             "request_type_time": 1,  // H
     *             "max_days_by_rental": 21, // d
     *             "extends_request_time": 24, // H
     *         },
     *        "can_assign" : true,
     *        "can_dropoff" : false,
     *        "can_extend": true,
     *        "is_extended": false,
     *        "city": "Miami",
     *        "country": "Estados Unidos"
     *     }
     *   ]
     *  "message": "We are processing your request"
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The selected user id is invalid"
     *  }
     *  HTTP/1.1 404 Data not found
     *  {
     *      "message": "Data not found" When there is not a current request
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * sendCurrentLocation()
     * @apiDescription Send Current Location
     * @api {POST} send-current-location Send Current Location
     * @apiVersion 1.0.0
     * @apiName Send Current Location
     * @apiGroup Request
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} lang          Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} request_id    Rental Request Id <label class="label label-warning">required</label>
     * @apiParam {String} latitude      Latitude <code>26.94533</code> <label class="label label-warning">required</label>
     * @apiParam {String} longitude     Longitude <code>-80.07659</code> <label class="label label-warning">required</label>
     *
     *
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en",
     *      "request_id": "f50f10b4-8b9a-4714-bb05-edd5d7ec3668",
     *      "latitude": "26.94533",
     *      "longitude": "-80.07659"
     *  }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "message": "No devices found",
     *      or
     *      "message": "New Location",
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The selected request id is invalid"
     *      or
     *      "message": "The latitude field is required."
     *      or
     *      "message": "The longitude field is required."
     *  }
     *  HTTP/1.1 404 Data not found
     *  {
     *      "message": "Data not found" When the request was not found
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * sendCancellationRequestReason()
     * @apiDescription Send Cancel Reason
     * @api {POST} cancellation-reason Send Cancel Reason
     * @apiVersion 1.0.0
     * @apiName Send Cancel Reason
     * @apiGroup Request
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} lang                  Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} rental_request_id     Rental Request Id <label class="label label-warning">required</label>
     * @apiParam {String} reason                Reason of cancellation <label class="label label-warning">required</label>
     * @apiParam {String} [comment]             Comments
     *
     *
     * @apiSuccessExample Json-Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "en",
     *      "rental_request_id": "f50f10b4-8b9a-4714-bb05-edd5d7ec3668",
     *      "reason" : "El usuario no tiene los documentos requeridos"
     *      "comment" : "Comentario"
     *  }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "message": "Cancellation request reason created",
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The selected rental request id is invalid" When the request was not found because request status != cancelled
     *      or
     *      "message": "The reason field is required."
     *  }
     *  HTTP/1.1 404 Data not found
     *  {
     *      "message": "Data not found" When the request was not found because userAgent is not present in request
     *      or
     *      "message": "Deny access" When the user is not in specified rol
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * getDiscountAmount()
     * @apiDescription Get Discount Code
     * @api {GET} discount-code Get Discount Code
     * @apiVersion 1.0.0
     * @apiName Get Discount Code
     * @apiGroup Request
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} lang                  Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} code                  Discount Code <label class="label label-warning">required</label>
     *
     *
     * @apiSuccessExample Url-Example:
     *
     * URL/api/v1/discount-code?code=4024007196776602&lang=en
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "data": {
     *          "id": "0807cb0a-2072-472b-a338-5b9a749460e1",
     *          "code": "4024007196776602",
     *          "active": 1,
     *          "operation": "-",
     *          "unit": "$",
     *          "amount": 15,
     *          "uses": 1,
     *          "expiry": "2020-01-01"
     *      }
     *  }
     *
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad request
     *  {
     *      "message": "The selected code is invalid"
     *      or
     *      "message": "The code field is required."
     *      or
     *      "message": "The selected lang is invalid."
     *      or
     *      "message": "The lang field is invalid."
     *      or
     *      "message": "You have already used the number of coupons allowed per user."
     *      or
     *      "message": "Invalid Discount Code."
     *      or
     *      "message": "You have made at least one rent."
     *  }
     *  HTTP/1.1 404 Data not found
     *  {
     *      "message": "Deny access"
     *  }
     *
     * @apiUse responseOauth
     *
     */

    /**
     * createCard()
     * @apiDescription Associate a card to a registered customer https://stripe.com/docs/api#create_card
     * @api {post} stripe/create-card Register Card
     * @apiVersion 1.0.0
     * @apiName Register Card
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} source        Token of transaction. <label class="label label-warning">required</label>
     * @apiParam {String} customer_id   Customer Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Json Example:
     *  Content-Type: application/json
     *  {
     *      "source": "tok_19QebuFaRfArkAZWlM27PuZW",
     *      "customer_id": "cus_9kzMsAMTIMjo890",
     *  }
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *  "message": "StripeResponse",
     *  "data": {
     *      "id": "card_19SpmtLJm7C3N2UszmmkfOoh",
     *      "object": "card",
     *      "address_city": null,
     *      "address_country": null,
     *      "address_line1": null,
     *      "address_line1_check": null,
     *      "address_line2": null,
     *      "address_state": null,
     *      "address_zip": null,
     *      "address_zip_check": null,
     *      "brand": "American Express",
     *      "country": "US",
     *      "customer": "cus_9kzMsAMTIMjo8y",
     *      "cvc_check": "pass",
     *      "dynamic_last4": null,
     *      "exp_month": 10,
     *      "exp_year": 2020,
     *      "fingerprint": "FFqtsFFVwvJTDwM1",
     *      "funding": "credit",
     *      "last4": "8431",
     *      "metadata": [],
     *      "name": null,
     *      "tokenization_method": null
     *  }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * retrieveCard()
     * @apiDescription Retrieve a card from registered customer https://stripe.com/docs/api#retrieve_card
     * @api {get} stripe/customer/{customer_id}/retrieve-card/{card_id} Get Card
     * @apiVersion 1.0.0
     * @apiName Retrieve Card
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} card_id       Card Id Associate to a registered customer. <label class="label label-warning">required</label>
     * @apiParam {String} customer_id   Customer Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Url-Example:
     *
     * URL/api/v1/stripe/customer/cus_9kzMsAMTIMjo890/retrieve-card/card_19SpmtLJm7C3N2UszmmkfOoh
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *  "message": "StripeResponse",
     *  "data": {
     *      "id": "card_19SpmtLJm7C3N2UszmmkfOoh",
     *      "object": "card",
     *      "address_city": null,
     *      "address_country": null,
     *      "address_line1": null,
     *      "address_line1_check": null,
     *      "address_line2": null,
     *      "address_state": null,
     *      "address_zip": null,
     *      "address_zip_check": null,
     *      "brand": "American Express",
     *      "country": "US",
     *      "customer": "cus_9kzMsAMTIMjo8y",
     *      "cvc_check": "pass",
     *      "dynamic_last4": null,
     *      "exp_month": 10,
     *      "exp_year": 2020,
     *      "fingerprint": "FFqtsFFVwvJTDwM1",
     *      "funding": "credit",
     *      "last4": "8431",
     *      "metadata": [],
     *      "name": null,
     *      "tokenization_method": null
     *  }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * allCards()
     * @apiDescription Retrieve all cards from registered customer https://stripe.com/docs/api#list_cards
     * @api {get} stripe/customer/{customer_id}/all-cards/{limit} Get All Cards
     * @apiVersion 1.0.0
     * @apiName Retrieve all Cards
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {Integer} limit         Limit of cards to retrieve (min = 1 - max = 10). <label class="label label-warning">required</label>
     * @apiParam {String} customer_id   Customer Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Url-Example:
     *
     * URL/api/v1/stripe/customer/cus_9kzMsAMTIMjo890/all-cards/10
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *  "message": "StripeResponse",
     *  "data": {
     *      "object": "list",
     *      "data": [
     *        {
     *          "id": "card_19SWkILJm7C3N2UsxLbpzyeo",
     *          "object": "card",
     *          "address_city": null,
     *          "address_country": null,
     *          "address_line1": null,
     *          "address_line1_check": null,
     *          "address_line2": null,
     *          "address_state": null,
     *          "address_zip": null,
     *          "address_zip_check": null,
     *          "brand": "American Express",
     *          "country": "US",
     *          "customer": "cus_9kzMsAMTIMjo8y",
     *          "cvc_check": "pass",
     *          "dynamic_last4": null,
     *          "exp_month": 10,
     *          "exp_year": 2018,
     *          "fingerprint": "kXqmJYBztqMG5Y3H",
     *          "funding": "credit",
     *          "last4": "0005",
     *          "metadata": [],
     *          "name": null,
     *          "tokenization_method": null
     *        },
     *        {
     *          "id": "card_19SpmtLJm7C3N2UszmmkfOoh",
     *          "object": "card",
     *          "address_city": null,
     *          "address_country": null,
     *          "address_line1": null,
     *          "address_line1_check": null,
     *          "address_line2": null,
     *          "address_state": null,
     *          "address_zip": null,
     *          "address_zip_check": null,
     *          "brand": "American Express",
     *          "country": "US",
     *          "customer": "cus_9kzMsAMTIMjo8y",
     *          "cvc_check": "pass",
     *          "dynamic_last4": null,
     *          "exp_month": 10,
     *          "exp_year": 2020,
     *          "fingerprint": "FFqtsFFVwvJTDwM1",
     *          "funding": "credit",
     *          "last4": "8431",
     *          "metadata": [],
     *          "name": null,
     *          "tokenization_method": null
     *        }
     *     ],
     *     "has_more": false,
     *     "url": "/v1/customers/cus_9nCuhY8QVHFLqv/sources"
     *   }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * createCharge()
     * @apiDescription Create a charge to a registered customer https://stripe.com/docs/api#create_charge
     * @api {post} stripe/create-charge Register Charge
     * @apiVersion 1.0.0
     * @apiName Register Charge
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {Integer} amount       Amount of charge. <label class="label label-warning">required</label>
     * @apiParam {String} currency      Currency of charge. <label class="label label-warning">required</label>
     * @apiParam {String} description   Description of charge.
     * @apiParam {Boolean} capture      Capture of charge. <code>true or false </code> <br/> <code>true</code> =
     * Capture the full authorization amount. <code>false</code> = The amount is on hold for 7 days.
     *
     * @apiParamExample Json Example:
     *  Content-Type: application/json
     *  {
     *      "amount": 100,
     *      "currency": "usd",
     *      "description" : "charge"
     *      "capture" : false
     *  }
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *    "message": "StripeResponse",
     *    "data": {
     *      "id": "ch_19Sqj4LJm7C3N2UssaUXHUbB",
     *      "object": "charge",
     *      "amount": 300,
     *      "amount_refunded": 0,
     *      "application": null,
     *      "application_fee": null,
     *      "balance_transaction": null,
     *      "captured": false,
     *      "created": 1482252270,
     *      "currency": "usd",
     *      "customer": "cus_9kzMsAMTIMjo8y",
     *      "description": "Cobro de capture 7",
     *      "destination": null,
     *      "dispute": null,
     *      "failure_code": null,
     *      "failure_message": null,
     *      "fraud_details": [],
     *      "invoice": null,
     *      "livemode": false,
     *      "metadata": [],
     *      "order": null,
     *      "outcome": {
     *          "network_status": "approved_by_network",
     *          "reason": null,
     *          "risk_level": "normal",
     *          "seller_message": "Payment complete.",
     *          "type": "authorized"
     *      },
     *      "paid": true,
     *      "receipt_email": null,
     *      "receipt_number": null,
     *      "refunded": false,
     *      "refunds": {
     *      "object": "list",
     *      "data": [],
     *      "has_more": false,
     *      "total_count": 0,
     *      "url": "/v1/charges/ch_19Sqj4LJm7C3N2UssaUXHUbB/refunds"
     *    },
     *      "review": null,
     *      "shipping": null,
     *      "source": {
     *          "id": "card_19SWkILJm7C3N2UsxLbpzyeo",
     *          "object": "card",
     *          "address_city": null,
     *          "address_country": null,
     *          "address_line1": null,
     *          "address_line1_check": null,
     *          "address_line2": null,
     *          "address_state": null,
     *          "address_zip": null,
     *          "address_zip_check": null,
     *          "brand": "American Express",
     *          "country": "US",
     *          "customer": "cus_9kzMsAMTIMjo8y",
     *          "cvc_check": null,
     *          "dynamic_last4": null,
     *          "exp_month": 10,
     *          "exp_year": 2018,
     *          "fingerprint": "kXqmJYBztqMG5Y3H",
     *          "funding": "credit",
     *          "last4": "0005",
     *          "metadata": [],
     *          "name": null,
     *          "tokenization_method": null
     *      },
     *      "source_transfer": null,
     *      "statement_descriptor": null,
     *      "status": "succeeded"
     *    }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * retrieveCharge()
     * @apiDescription Retrieve a charge from registered customer https://stripe.com/docs/api#retrieve_charge
     * @api {post} stripe/retrieve-charge/{charge_id} Get Charge
     * @apiVersion 1.0.0
     * @apiName Retrieve Charge
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} charge_id     Charge Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Url-Example:
     *
     * URL/api/v1/stripe/retrieve-charge/ch_19Sqj4LJm7C3N2UssaUXHUbB
     *
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *    "message": "StripeResponse",
     *    "data": {
     *      "id": "ch_19Sqj4LJm7C3N2UssaUXHUbB",
     *      "object": "charge",
     *      "amount": 300,
     *      "amount_refunded": 0,
     *      "application": null,
     *      "application_fee": null,
     *      "balance_transaction": null,
     *      "captured": false,
     *      "created": 1482252270,
     *      "currency": "usd",
     *      "customer": "cus_9kzMsAMTIMjo8y",
     *      "description": "Cobro de capture 7",
     *      "destination": null,
     *      "dispute": null,
     *      "failure_code": null,
     *      "failure_message": null,
     *      "fraud_details": [],
     *      "invoice": null,
     *      "livemode": false,
     *      "metadata": [],
     *      "order": null,
     *      "outcome": {
     *          "network_status": "approved_by_network",
     *          "reason": null,
     *          "risk_level": "normal",
     *          "seller_message": "Payment complete.",
     *          "type": "authorized"
     *      },
     *      "paid": true,
     *      "receipt_email": null,
     *      "receipt_number": null,
     *      "refunded": false,
     *      "refunds": {
     *      "object": "list",
     *      "data": [],
     *      "has_more": false,
     *      "total_count": 0,
     *      "url": "/v1/charges/ch_19Sqj4LJm7C3N2UssaUXHUbB/refunds"
     *    },
     *      "review": null,
     *      "shipping": null,
     *      "source": {
     *          "id": "card_19SWkILJm7C3N2UsxLbpzyeo",
     *          "object": "card",
     *          "address_city": null,
     *          "address_country": null,
     *          "address_line1": null,
     *          "address_line1_check": null,
     *          "address_line2": null,
     *          "address_state": null,
     *          "address_zip": null,
     *          "address_zip_check": null,
     *          "brand": "American Express",
     *          "country": "US",
     *          "customer": "cus_9kzMsAMTIMjo8y",
     *          "cvc_check": null,
     *          "dynamic_last4": null,
     *          "exp_month": 10,
     *          "exp_year": 2018,
     *          "fingerprint": "kXqmJYBztqMG5Y3H",
     *          "funding": "credit",
     *          "last4": "0005",
     *          "metadata": [],
     *          "name": null,
     *          "tokenization_method": null
     *      },
     *      "source_transfer": null,
     *      "statement_descriptor": null,
     *      "status": "succeeded"
     *    }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * captureCharge()
     * @apiDescription Capture a charge from registered customer https://stripe.com/docs/api#capture_charge
     * @api {post} stripe/capture-charge/{charge_id} Capture Charge
     * @apiVersion 1.0.0
     * @apiName Capture Charge
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} charge_id     Charge Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Url-Example:
     *
     * URL/api/v1/stripe/capture-charge/ch_19Sqj4LJm7C3N2UssaUXHUbB
     *
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *    "message": "StripeResponse",
     *    "data": {
     *      "id": "ch_19Sqj4LJm7C3N2UssaUXHUbB",
     *      "object": "charge",
     *      "amount": 300,
     *      "amount_refunded": 0,
     *      "application": null,
     *      "application_fee": null,
     *      "balance_transaction": null,
     *      "captured": true,
     *      "created": 1482252270,
     *      "currency": "usd",
     *      "customer": "cus_9kzMsAMTIMjo8y",
     *      "description": "Cobro de capture 7",
     *      "destination": null,
     *      "dispute": null,
     *      "failure_code": null,
     *      "failure_message": null,
     *      "fraud_details": [],
     *      "invoice": null,
     *      "livemode": false,
     *      "metadata": [],
     *      "order": null,
     *      "outcome": {
     *          "network_status": "approved_by_network",
     *          "reason": null,
     *          "risk_level": "normal",
     *          "seller_message": "Payment complete.",
     *          "type": "authorized"
     *      },
     *      "paid": true,
     *      "receipt_email": null,
     *      "receipt_number": null,
     *      "refunded": false,
     *      "refunds": {
     *      "object": "list",
     *      "data": [],
     *      "has_more": false,
     *      "total_count": 0,
     *      "url": "/v1/charges/ch_19Sqj4LJm7C3N2UssaUXHUbB/refunds"
     *    },
     *      "review": null,
     *      "shipping": null,
     *      "source": {
     *          "id": "card_19SWkILJm7C3N2UsxLbpzyeo",
     *          "object": "card",
     *          "address_city": null,
     *          "address_country": null,
     *          "address_line1": null,
     *          "address_line1_check": null,
     *          "address_line2": null,
     *          "address_state": null,
     *          "address_zip": null,
     *          "address_zip_check": null,
     *          "brand": "American Express",
     *          "country": "US",
     *          "customer": "cus_9kzMsAMTIMjo8y",
     *          "cvc_check": null,
     *          "dynamic_last4": null,
     *          "exp_month": 10,
     *          "exp_year": 2018,
     *          "fingerprint": "kXqmJYBztqMG5Y3H",
     *          "funding": "credit",
     *          "last4": "0005",
     *          "metadata": [],
     *          "name": null,
     *          "tokenization_method": null
     *      },
     *      "source_transfer": null,
     *      "statement_descriptor": null,
     *      "status": "succeeded"
     *    }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * createRefund()
     * @apiDescription Create refund  from registered charge https://stripe.com/docs/api#create_refund
     * @api {post} stripe/create-refund Refund Charge
     * @apiVersion 1.0.0
     * @apiName Refund Charge
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} charge_id     Charge Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Json Example:
     *  Content-Type: application/json
     *  {
     *      "charge" : "ch_19SoCPLJm7C3N2UsBv9ohiDG"
     *  }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *    "message": "StripeResponse",
     *    "data": {
     *      "id": "re_19QhQpFaRfArkAZWftjpRvsc",
     *      "object": "refund",
     *      "amount": 100,
     *      "balance_transaction": null,
     *      "charge": "ch_19SoCPLJm7C3N2UsBv9ohiDG",
     *      "created": 1481739887,
     *      "currency": "usd",
     *      "metadata": {
     *      },
     *      "reason": null,
     *      "receipt_number": null,
     *      "status": "succeeded"
     *    }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * retrieveCustomer()
     * @apiDescription Retrieve a customer https://stripe.com/docs/api#retrieve_customer
     * @api {post} stripe/retrieve-customer/{customer_id} Retrieve Customer
     * @apiVersion 1.0.0
     * @apiName Retrieve Customer
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} charge_id     Charge Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Url-Example:
     *
     * URL/api/v1/stripe/retrieve-customer/cus_9kz7Wz8kSFBLrZ
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *  "message": "StripeResponse",
     *  "data": {
     *      "id": "cus_9kz7Wz8kSFBLrZ",
     *      "object": "customer",
     *      "account_balance": 0,
     *      "created": 1481923280,
     *      "currency": null,
     *      "default_source": "card_19SWYELJm7C3N2UsMwZYoj5u",
     *      "delinquent": false,
     *      "description": null,
     *      "discount": null,
     *      "email": "rental@tera.com",
     *      "livemode": false,
     *      "metadata": {
     *      "name": "Rental Admin",
     *      "uuid": "e60aad14-7941-4c53-84de-f7d8587f89c9"
     *  },
     *  "shipping": null,
     *  "sources": {
     *      "object": "list",
     *      "data": [
     *      {
     *          "id": "card_19SWYELJm7C3N2UsMwZYoj5u",
     *          "object": "card",
     *          "address_city": null,
     *          "address_country": null,
     *          "address_line1": null,
     *          "address_line1_check": null,
     *          "address_line2": null,
     *          "address_state": null,
     *          "address_zip": null,
     *          "address_zip_check": null,
     *          "brand": "Visa",
     *          "country": "US",
     *          "customer": "cus_9kz7Wz8kSFBLrZ",
     *          "cvc_check": "pass",
     *          "dynamic_last4": null,
     *          "exp_month": 1,
     *          "exp_year": 2017,
     *          "fingerprint": "DWuYRRuuzS1LKYb2",
     *          "funding": "credit",
     *          "last4": "1881",
     *          "metadata": [],
     *          "name": null,
     *          "tokenization_method": null
     *      }
     *      ],
     *      "has_more": false,
     *      "total_count": 1,
     *      "url": "/v1/customers/cus_9kz7Wz8kSFBLrZ/sources"
     *      },
     *  "subscriptions": {
     *      "object": "list",
     *      "data": [],
     *      "has_more": false,
     *      "total_count": 0,
     *      "url": "/v1/customers/cus_9kz7Wz8kSFBLrZ/subscriptions"
     *  }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * updateCustomer()
     * @apiDescription Update default card of customer https://stripe.com/docs/api#update_customer
     * @api {put} stripe/update-customer/{customer_id} Update Customer
     * @apiVersion 1.0.0
     * @apiName Update Customer
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} default_source     ID of source to make the customer’s new default for invoice payments. (Card Id)
     * <label class="label label-warning">required</label>
     *
     * @apiParamExample Json Example:
     *
     *  Content-Type: application/json
     *  {
     *      "default_source" : "card_19SWYELJm7C3N2UsMwZYoj5u"
     *  }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *  "message": "StripeResponse",
     *  "data": {
     *      "id": "cus_9kz7Wz8kSFBLrZ",
     *      "object": "customer",
     *      "account_balance": 0,
     *      "created": 1481923280,
     *      "currency": null,
     *      "default_source": "card_19SWYELJm7C3N2UsMwZYoj5u",
     *      "delinquent": false,
     *      "description": null,
     *      "discount": null,
     *      "email": "rental@tera.com",
     *      "livemode": false,
     *      "metadata": {
     *      "name": "Rental Admin",
     *      "uuid": "e60aad14-7941-4c53-84de-f7d8587f89c9"
     *  },
     *  "shipping": null,
     *  "sources": {
     *      "object": "list",
     *      "data": [
     *      {
     *          "id": "card_19SWYELJm7C3N2UsMwZYoj5u",
     *          "object": "card",
     *          "address_city": null,
     *          "address_country": null,
     *          "address_line1": null,
     *          "address_line1_check": null,
     *          "address_line2": null,
     *          "address_state": null,
     *          "address_zip": null,
     *          "address_zip_check": null,
     *          "brand": "Visa",
     *          "country": "US",
     *          "customer": "cus_9kz7Wz8kSFBLrZ",
     *          "cvc_check": "pass",
     *          "dynamic_last4": null,
     *          "exp_month": 1,
     *          "exp_year": 2017,
     *          "fingerprint": "DWuYRRuuzS1LKYb2",
     *          "funding": "credit",
     *          "last4": "1881",
     *          "metadata": [],
     *          "name": null,
     *          "tokenization_method": null
     *      }
     *      ],
     *      "has_more": false,
     *      "total_count": 1,
     *      "url": "/v1/customers/cus_9kz7Wz8kSFBLrZ/sources"
     *      },
     *  "subscriptions": {
     *      "object": "list",
     *      "data": [],
     *      "has_more": false,
     *      "total_count": 0,
     *      "url": "/v1/customers/cus_9kz7Wz8kSFBLrZ/subscriptions"
     *  }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * deleteCard()
     * @apiDescription Retrieve a card from registered customer https://stripe.com/docs/api#delete_card
     * @api {delete} stripe/customer/{customer_id}/delete-card/{card_id} Delete Card
     * @apiVersion 1.0.0
     * @apiName Delete Card
     * @apiGroup Stripe
     *
     * @apiUse HeadersBasicAccept
     *
     * @apiParam {String} card_id       Card Id. <label class="label label-warning">required</label>
     * @apiParam {String} customer_id   Customer Id. <label class="label label-warning">required</label>
     *
     * @apiParamExample Url-Example:
     *
     * URL/api/v1/stripe/customer/cus_9kzMsAMTIMjo8y/delete-card/card_19SukSLJm7C3N2UsdZ9rE81C
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *  "message": "StripeResponse",
     * "data": {
     *  "id": "card_19TF6zLJm7C3N2UsNR8n4bNg",
     *  "deleted": true
     * }
     * }
     * @apiErrorExample Error-Response:
     * Stripe Errors Docs https://stripe.com/docs/api#errors
     * @apiUse responseOauth
     *
     */

    /**
     * changePasswordUser()
     * @apiDescription Change Password
     * @api {PUT} user/{user_id}/change-password Change Password
     * @apiVersion 1.0.0
     * @apiName User Change Password
     * @apiGroup User
     *
     * @apiUse HeadersLogin
     *
     * @apiParam {String} lang                      Language of application. <code>en/es</code> <label class="label label-warning">required</label>
     * @apiParam {String} user_id                   User id. <label class="label label-warning">required</label>
     * @apiParam {String} password                  New password. <code>between 5 and 15 characters, at least 1 digit</code> <label class="label label-warning">required</label>
     * @apiParam {String} password_confirmation     Confirm New password. <code>between 5 and 15 characters, at least 1 digit</code> <label class="label label-warning">required</label>
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "message": "The password has been changed successfully."
     *  }
     * @apiSuccessExample Json Example:
     *  Content-Type: application/json
     *  {
     *      "lang" : "es",
     *      "password" : "123456",
     *      "password_confirmation" : "123456"
     *  }
     * @apiSuccessExample Error-Response:
     *  HTTP/1.1 400 Bad Request
     *  {
     *      "message": "The selected user id is invalid."
     *      or
     *      "message": "The language of application is required."
     *      or
     *      "message": "The password field is required."
     *      or
     *      "message": "The password confirmation field is required."
     *      or
     *      "message": "The password format is invalid."
     *  }
     *
     * @apiUse responseOauth
     *
     */

}