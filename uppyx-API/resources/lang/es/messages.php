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

    "DataNotFound"                  => 'Datos no encontrados.',
    'fileUploadedSuccessfully'      => 'Imagen subida con éxito.',
    'PasswordChanged'               => 'La contraseña fue cambiada con éxito.',
    'NotificationsSaved'            => 'La configuración de notificaciones de usuario fue guardada correctamente.',
    'UserCreated'                   => 'El usuario fue creado con éxito.',
    'UserRegister'                  => 'El usuario fue creado con éxito. Por favor verifique su cuenta para poder usarla.',
    'RequestSent'                   => 'La solicitud ha sido enviada con éxito.',
    'SuccessLogout'                 => 'Ha cerrado la sesión con éxito.',
    'UserDisabled'                  => 'Este usuario ha sido inhabilitado.',
    'UserConfirm'                   => 'Por favor activa la cuenta para poder ingresar.',
    'SuccessUpdate'                 => 'Usuario actualizado con éxito.',
    'SuccessCancel'                 => 'Las solicitudes han sido canceladas con éxito.',
    'RequestStatusChanged'          => 'La solicitud se ha actualizado satisfactoriamente.',
    'ImageDeletedSuccess'           => 'La imagen fue eliminada con éxito.',
    'DaysOfRent'                    => 'Dia(s) de renta.',
    'RequestsCancelled'             => ':request solicitud(es) fueron canceladas.',
    'RequestsCharged'               => ':request solicitud(es) fueron pre-cobradas.',
    'AccountAlreadyVerified'        => 'Esta cuenta ya ha sido verificada.',
    'VerifyEmailSent'               => 'Hemos enviado un email para verificar su cuenta.',
    'ReminderSend'                  => ':emails email(s) fueron enviados.',
    'NothingToDo'                   => 'Nada por hacer.',
    'LocationSent'                  => 'Ubicación enviada.',
    'DeviceNotFound'                => 'Dispositivo no encontrado.',
    'CancellationRequestReasonCreated'  => 'Motivo de cancelación creado.',
    'UserFound'                     => 'Usuario existente.',
    /*
    |--------------------------------------------------------------------------
    | Push Notifications Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during consumption of any service.
    |
    */
    "AgencyHasTakenTheRequest"          => "Su proveedor de vehículo es :agency.",
    "RequestAssignedToAgent"            => "La solicitud fue asignada a un Ejecutivo.",
    "AgentIsOnTheWay"                   => "El ejecutivo va en camino.",
    "RequestCancelledForAgent"          => "La solicitud fue cancelada por el Ejecutivo.",
    "RequestCancelledForManager"        => "El gerente ha cancelado su solicitud.",
    "RequestCancelledForUser"           => "Renta cancelada por el cliente.",
    "ThereIsNewRequest"                 => "Nueva solicitud de renta.",
    "CurrentLocation"                   => "Nueva ubicación.",
    "RequestNotTaken"                   => "La solicitud no ha sido tomada.",
    "RequestTakenByManager"             => "La solicitud ya fue tomada por un gerente.",
    "RequestCancelledForApp"            => "La solicitud fue cancelada por la aplicación.",
    "RequestCancelledForSystem"         => "La solicitud fue cancelada por el sistema.",
    "RequestCancelled"                  => "La solicitud fue cancelada.",
    "RequestTaken"                      => "La solicitud fue tomada.",
    "RequestCarReturned"                => "El carro de esta solicitud fue devuelto.",
    "ProcessingRequest"                 => "Estamos procesando su solicitud",
    "RequestCancelledMsg"               => "¡Lo sentimos! No podemos procesar su solicitud en este momento. Por favor intente de nuevo en unos minutos.",
    "RequestTakenByAgency"              => "El carro estará allí pronto.",
    "RequestDelivered"                  => "Gracias, esperamos verte pronto.",
    "RequestTakenByAgent"               => "La solicitud ya fue tomada por un ejecutivo.",
    "RequestAssignedByManager"          => "Nueva entrega asignada.",
    "RequestUnassignedByManager"        => "La solicitud fue reasignada por un gerente.",
    'ChangePaymentMethod'               => "Ha ocurrido un inconveniente con su método de pago. Por favor cambielo.",
    "RequestCancelledByPaymentMethod"   => "Su solicitud fue cancelada debido a problemas con su método de pago.",
    'AgentHasTakenTheRequest'           => 'Su proveedor de vehículo es :agent.',
    "CarOnWay"                          => "Su vehículo va en camino.",
    "ArrivedAgent"                      => ":agent ha llegado para entregarle su vehículo.",
    "RequestChecking"                   => "La solicitud se encuentra en proceso de verificación de documentos.",
    "OnBoard"                           => "Disfrute su vehículo.",
    "CarReturned"                       => "Nuevo vehículo devuelto.",
    "Finished"                          => "Finished.",

    /*
    |--------------------------------------------------------------------------
    | Errors Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during consumption of any service.
    |
    */

    "ErrorSavingData"                => 'Error al almacenar los datos.',
    "ErrorLogin"                     => 'Usuario o contraseña inválida.',
    "AuthorizationFacebookError"     => 'Usuario de facebook no autorizado.',
    "NoPassword"                     => 'Este usuario no tienen ninguna contraseña asiganada.',
    'FileNotUploaded'                => 'Imposible subir imagen.',
    'ErrorSendingEmail'              => 'Error al enviar email.',
    'UserNotFound'                   => 'Usuario no encontrado.',
    'UserNotFoundForgot'             => 'Este EMail no esta registrado en uPPyx.',
    'FacebookUserChangePassword'     => 'Los usuarios registrados con facebook no pueden cambiar contraseña.',
    'InvalidPasswordToken'           => 'Token inválido.',
    'NotAllowedAge'                  => 'Edad no permitida.',
    'PasswordExpired'                => 'Su contraseña ha vencido.',
    'EmailTaken'                     => 'El email ingresado ya esta siendo utilizado.',
    'ErrorServer'                    => 'Error del servidor.',
    'ImageRequired'                  => 'La imagen es requerida.',
    'DenyAccess'                     => 'Acceso denegado.',
    'DropoffInvalid'                 => 'Drop-off inválido.',
    'ErrorCreatingCustomer'          => 'Error al crear el customer de stripe.',
    'YouHaveRequestActive'           => 'Ya hay una solicitud activa.',
    'ErrorChangingPassword'          => 'Error al cambiar la contraseña.',
    'RequestsNotCancelled'           => 'No hay solicitudes para cancelar.',
    'BusyAgents'                     => 'Verifique la disponibilidad de sus ejecutivos.',
    'AgencyWithoutAgents'            => 'Su agencia no tiene ejecutivos.',
    'RequestWithoutPayment'          => 'La solicitud no posee pago asociado.',
    'UserWithoutRequiredRol'         => 'Usuario sin rol requerido.',
    'UserWithoutRol'                 => 'Usuario sin rol asignado.',
    'BusyAgent'                      => 'El ejecutivo seleccionado esta ocupado.',
    'UserNotInAgency'                => 'El ejecutivo seleccionado no esta en la agencia correcta.',
    'RequestsNotPreCharged'          => 'No hay request planeados por cobrar.',
    'PaymentMethodError'             => 'Error con el método de pago.',
    'InvalidRequest'                 => 'Solicitud inválida.',
    'UnassignedRequests'             => 'Existen request planificados por asignar.',
    'RequestOutOfDateToAssign'       => 'Esta solicitud no puede ser asignada porque su fecha de pickup es superior a :hour hora(s).',
    'UnavailableAgents'              => 'No hay ejecutivos disponibles.',
    'UserAppliedCode'                => 'Usted ya ha utilizado el número de cupones permitidos por usuario.',
    'InvalidDiscountCode'            => 'Cupón de descuento inválido.',
    'RequestOutOfDateToModify'       => 'Esta solicitud no puede ser modificada porque su fecha de dropoff es inferior a :hour hora(s).',
    'YouHaveRequestFinished'         => 'El cupón sólo puede ser utilizado en su primera renta.',
    'InvalidCancellation'            => 'La solicitud no puede ser cancelada.',
    'RequestOutOfStatusToExtend'     => 'Esta solicitud no puede ser extendida debido al estatus es inválido.',
    'RequestOutOfDaysToExtend'       => 'Esta solicitud no puede ser extendida porque su nueva fecha de dropoff es superior a :days dia(s).',
    'RequestUnavailableToExtend'     => 'Esta solicitud no puede ser extendida porque su fecha de dropoff es inferior a :hours hora(s).',
    'UserSocial'                     => 'Usuario registrado por una red social, no puede asignarle una contraseña.',
    'RequestOutOfStatusToRate'       => 'Esta solicitud no puede ser calificada debido al estatus es inválido.',
    'RequestWithRate'                => 'Esta solicitud no puede ser calificada debido a que posee una calificación previa.',
    /*
    |--------------------------------------------------------------------------
    | General Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during consumption of any service.
    |
    */

    'Email-Validation-Code'         => 'Recuperación de Contraseña',

];
