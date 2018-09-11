<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Success Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during consumption of any service.
    |
    */
    "DataNotFound"                      => 'Data not found.',
    'fileUploadedSuccessfully'          => 'File uploaded successfully.',
    'PasswordChanged'                   => 'The password has been changed successfully.',
    'NotificationsSaved'                => 'The user configuration setting was saved correctly.',
    'UserCreated'                       => 'User was registered successfully.',
    'UserRegister'                      => 'User was registered successfully. Please verify your account for use.',
    'RequestSent'                       => 'Request has been sent successfully.',
    'SuccessLogout'                     => 'The session has been closed.',
    'UserDisabled'                      => 'This user has been disabled.',
    'UserConfirm'                       => 'Please activate the account in order to login.',
    'SuccessUpdate'                     => 'The user has been successfully updated.',
    'SuccessCancel'                     => 'The request has been successfully cancelled.',
    'RequestStatusChanged'              => 'The request has been updated successfully.',
    'ImageDeletedSuccess'               => 'Image deleted successfully.',
    'DaysOfRent'                        => 'Rental Day(s).',
    'RequestsCancelled'                 => ':request requests has been cancelled.',
    'RequestsCharged'                   => ':request requests has been pre-charged.',
    'AccountAlreadyVerified'            => 'This account has already been verified.',
    'VerifyEmailSent'                   => 'We have sent an email in order to verify your account.',
    'ReminderSend'                      => ':emails email(s) was sent.',
    'NothingToDo'                       => 'Nothing to do.',
    'LocationSent'                      => 'Location sent.',
    'DeviceNotFound'                    => 'Device not found.',
    'CancellationRequestReasonCreated'  => 'Cancellation request reason created.',
    'UserFound'                         => 'User found.',
    /*
    |--------------------------------------------------------------------------
    | Push Notifications Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during consumption of any service.
    |
    */
    "AgencyHasTakenTheRequest"          => "Yor car provider is :agency.",
    "RequestAssignedToAgent"            => "The request was assigned to an Agent.",
    "AgentIsOnTheWay"                   => "The Agent is on the way.",
    "RequestCancelledForAgent"          => "The request was cancelled for the Agent.",
    "RequestCancelledForManager"        => "The agency has cancelled your request.",
    "RequestCancelledForUser"           => "Request cancelled by customer.",
    "ThereIsNewRequest"                 => "New rental request.",
    "CurrentLocation"                   => "New Location.",
    "RequestNotTaken"                   => "The request has not been taken.",
    "RequestTakenByManager"             => "The request has been taken by manager.",
    "RequestCancelledForApp"            => "The request was cancelled by app client.",
    "RequestCancelledForSystem"         => "The request was cancelled by system.",
    "RequestCancelled"                  => "The request was cancelled.",
    "RequestTaken"                      => "The request was taken.",
    "RequestCarReturned"                => "The car of this request was returned.",
    "ProcessingRequest"                 => "We are processing your request.",
    "RequestCancelledMsg"               => "Sorry! We can't process your request at this time. Please try again in a few minutes.",
    "RequestTakenByAgency"              => "The car will be there soon.",
    "RequestDelivered"                  => "Thanks! We hope see you soon.",
    "RequestTakenByAgent"               => "The request has been taken by agent.",
    "RequestAssignedByManager"          => "New delivery assigned.",
    "RequestUnassignedByManager"        => "The request has been reassigned by manager.",
    'ChangePaymentMethod'               => "There was a problem with your payment method. Please change it.",
    "RequestCancelledByPaymentMethod"   => "Your request was cancelled due to problems with your payment method.",
    "AgentHasTakenTheRequest"           => "You car'll be delivered by :agent.",
    "CarOnWay"                          => "Your car is on the way.",
    "ArrivedAgent"                      => ":agent has arrived to deliver your car.",
    "RequestChecking"                   => "The request is on process of documents verify.",
    "OnBoard"                           => "Enjoy you car.",
    "CarReturned"                       => "New car returned.",
    "Finished"                          => "Finished.",

    /*
    |--------------------------------------------------------------------------
    | Errors Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during consumption of any service.
    |
    */
    "ErrorSavingData"                    => 'Error saving data.',
    "ErrorLogin"                         => 'The information for the login is invalid.',
    "AuthorizationFacebookError"         => 'Unauthorized facebook user.',
    "NoPassword"                         => 'This user has no assigned password.',
    'FileNotUploaded'                    => 'File not uploaded.',
    'ErrorSendingEmail'                  => 'Error sending email.',
    'UserNotFound'                       => 'User not found.',
    'UserNotFoundForgot'                 => 'User not found.',
    'FacebookUserChangePassword'         => 'Users registered with facebook can\'t change password.',
    'InvalidPasswordToken'               => 'Invalid token.',
    'NotAllowedAge'                      => 'Not allowed age.',
    'PasswordExpired'                    => 'Your password has expired.',
    'EmailTaken'                         => 'The email has already been taken.',
    'ErrorServer'                        => 'Error server.',
    'ImageRequired'                      => 'The image field is required.',
    'DenyAccess'                         => 'Deny access.',
    'DropoffInvalid'                     => 'Invalid drop-off.',
    'ErrorCreatingCustomer'              => 'Error creating stripe customer.',
    'YouHaveRequestActive'               => 'You have an active request.',
    'ErrorChangingPassword'              => 'Error changing password.',
    'RequestsNotCancelled'               => 'There aren\'t requests to cancel.',
    'BusyAgents'                         => 'Check the availability of your agents.',
    'AgencyWithoutAgents'                => 'Your agency does not have agents.',
    'RequestWithoutPayment'              => 'The request has not payment associated.',
    'UserWithoutRequiredRol'             => 'User without role required.',
    'UserWithoutRol'                     => 'User without role.',
    'BusyAgent'                          => 'The agent selected is busy.',
    'UserNotInAgency'                    => 'The agent selected is not in correct agency.',
    'RequestsNotPreCharged'              => 'There aren\'t requests to charge.',
    'PaymentMethodError'                 => 'Error with the payment method.',
    'InvalidRequest'                     => 'Invalid Request.',
    'UnassignedRequests'                 => 'There are planned requests to assign.',
    'RequestOutOfDateToAssign'           => 'This request can\'t be assigned because it\'s pickup date is greater than :hour hour(s).',
    'UnavailableAgents'                  => 'There aren\'t agents available.',
    'UserAppliedCode'                    => 'You have already used the number of coupons allowed per user.',
    'InvalidDiscountCode'                => 'Invalid Discount Code.',
    'RequestOutOfDateToModify'           => 'This request can\'t be modified because it\'s dropoff date is lower than :hour hour(s).',
    'YouHaveRequestFinished'             => 'The coupon can only be used on your first rent.',
    'InvalidCancellation'                => 'The request can\'t be cancelled.',
    'RequestOutOfStatusToExtend'         => 'This request can\'t be extended because its status is invalid.',
    'RequestOutOfDaysToExtend'           => 'This request can\'t be extended because its new dropoff date is greater than :days day(s).',
    'RequestUnavailableToExtend'         => 'This request can\'t be extended because its dropoff date is lower than :hours hour(s).',
    'UserSocial'                         => 'The e-mail provided is not registered with uPPyx.',
    'RequestOutOfStatusToRate'           => 'This request can\'t be rated because its status is invalid.',
    'RequestWithRate'                    => 'This request can\'t be rated because it has a previous rate.',

    /*
    |--------------------------------------------------------------------------
    | General Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during consumption of any service.
    |
    */
    'Email-Validation-Code'             => 'Reset Password',

];
