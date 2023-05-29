<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

function firebaseApp()
{
    $serviceAccount = ServiceAccount::fromJsonFile(config_path('firebase_credentials.json'));

    return (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
}
