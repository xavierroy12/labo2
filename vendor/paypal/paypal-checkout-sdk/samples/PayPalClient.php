<?php

namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment which has access
     * credentials context. This can be used invoke PayPal API's provided the
     * credentials have the access to do so.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }
    
    /**
     * Setting up and Returns PayPal SDK environment with PayPal Access credentials.
     * For demo purpose, we are using SandboxEnvironment. In production this will be
     * ProductionEnvironment.
     */
    public static function environment()
    {
        
        $clientId = getenv("CLIENT_ID") ? : "Afm1vzJKaBYMNwWP0t8wHv3RaCjoO5vh1M2C_rbMqGZW-vUr2fex7vptH_Jc0JCvHGnxXqCC5kT14DoN";
        $clientSecret = getenv("CLIENT_SECRET") ? : "EAPPFDOvzW3TCKt5ksmuezmo9R1pP4d4tGC2-_28CqENMK6PPsQqaCfEtPeWDqgkSnP7EQFMy0M2NNvU";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
