<?php
    session_start();
    require_once "../vendor/autoload.php";
    require_once "../vendor\jublonet\codebird-php\src\codebird.php";
    // require_once "../app/TwitterAuth.php";

    // $token_google = getenv('IDCLIENTEGOOGLE');
    $token_google = "594064547014-qtsmu9tgks9lsgucsl81mu850aadfi4a.apps.googleusercontent.com";
    // $secreto_clave_google = getenv('SECRETOCLAVEGOOGLE');
    $secreto_clave_google = "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";
    $token_twitter = getenv('TOKENTWITTER');
    $secreto_clave_twitter = getenv('SECRETOCLAVETWITTER');

    $user = (isset($_SESSION["user"]) && !empty($_SESSION["user"]))? trim($_SESSION["user"]):""; 
    $perfil = (isset($_SESSION["perfil"]) && !empty($_SESSION["perfil"]))? trim($_SESSION["perfil"]):""; 

    // \Codebird\Codebird::setConsumerKey($token_twitter);
    
    // $cliente = \Codebird\Codebird::getInstance();

    if ($user==""){      
        //Make object of Google API Client for call Google API
        $google_client = new Google_Client();
        
        // //Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
        $google_client->setClientId($token_google);
        
        // //Set the OAuth 2.0 Client Secret key
        $google_client->setClientSecret($secreto_clave_google);
        
        // //Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
        $google_client->setRedirectUri("http://127.0.0.1/vistas/index.php");
        
        // // to get the email and profile 
        $google_client->addScope("email");
        
        $google_client->addScope("profile");

        if(isset($_SESSION["user_first_name"]) || isset($_SESSION["user_id"])){
            $perfil = "U";
        }
    }
?>