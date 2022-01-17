<?php

//start session on web page
session_start();

$user = (isset($_SESSION["user"]) && !empty($_SESSION["user"]))? trim($_SESSION["user"]):""; 
$perfil = (isset($_SESSION["perfil"]) && !empty($_SESSION["perfil"]))? trim($_SESSION["perfil"]):""; 

// if ($user=="") {
//     unset($_SESSION["user"]);
//     $_SESSION = array();
    
//     session_destroy();  
// } 

if ($user==""){
    //config.php
    
    //Include Google Client Library for PHP autoload file
    require_once 'vendor/autoload.php';
    
    //Make object of Google API Client for call Google API
    $google_client = new Google_Client();
    
    //Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
    $google_client->setClientId('594064547014-qtsmu9tgks9lsgucsl81mu850aadfi4a.apps.googleusercontent.com');
    
    //Set the OAuth 2.0 Client Secret key
    $google_client->setClientSecret('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');
    
    //Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
    $google_client->setRedirectUri('http://127.0.0.1/E-commerceMuebleria/index.php');
    
    // to get the email and profile 
    $google_client->addScope('email');
    
    $google_client->addScope('profile');
}
?>