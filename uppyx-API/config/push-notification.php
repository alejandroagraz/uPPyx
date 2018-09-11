<?php
$environment = (env('APP_ENV') != 'prod') ? "development" : "production";
return [

    'uPPyxiOS' => [
        'environment' => $environment,
        'certificate' => app_path() . '/certificates/ck-'.$environment.'.pem',
        'passPhrase' => 'uppyx',
        'service' => 'apns'
    ],
    'uPPyxAndroid' => [
        'environment' => $environment,
        'apiKey' => 'AAAAmvAimBg:APA91bGU4ENmtNQz9B0A1JZ5nQkAQ7UcveGzMi67IRFQMyT8r5u-pXNcdtA0IqJoRnBeYSxmo4TSoklGULH8JjIk6blFCR6DilA9AHFg4QbdqKrUCPfhFCe6qYgjtXR6X4e0sAN2rOp-4ELZCGL9oKSHipPEU-RaQQ',
        'service' => 'gcm'
    ]

];