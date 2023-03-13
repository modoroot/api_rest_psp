<?php
    // Se incluye el archivo "autoload.php" del paquete Composer que es necesario para cargar las clases de Google API
    require_once 'vendor/autoload.php';

    // Se define el ID de cliente, secreto de cliente y URI de redireccionamiento de la aplicación web asociada al proyecto en la consola de Google Cloud
    $clientID = '24562032999-s9je57rvqmmmf2nsuivat5u3l296r7ko.apps.googleusercontent.com';
    $clientSecret = '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';
    $redirectUri = 'http://localhost/api_rest_psp/oauth/login.php';

    // Se crea una instancia de la clase `Google_Client` para interactuar con los servicios de Google
    $client = new Google_Client();
    $client->setClientId($clientID);         // Se establece el ID de cliente
    $client->setClientSecret($clientSecret); // Se establece el secreto de cliente
    $client->setRedirectUri($redirectUri);   // Se establece la URI de redireccionamiento después de la autenticación

    // Se definen los alcances de acceso para la información del perfil y email del usuario
    $client->addScope("email");
    $client->addScope("profile");

    // Si se recibe un código de autenticación en la URL tras el inicio de sesión en el 
    // proveedor de identidad, se intercambia por un token de acceso y se almacena
    //  en la instancia del objeto cliente
    if(isset($_GET['code'])){
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Se crea una instancia del servicio Google_Service_Oauth2 para obtener 
        // información sobre el usuario autenticado
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        // Se extrae la dirección de correo electrónico y el nombre completo del usuario autenticado
        $email = $google_account_info->email;
        $name = $google_account_info->name;

        // Se muestra el nombre y el correo electrónico del usuario y se incluye el 
        // fichero index.php de la API REST, que es una pequeña guía de uso
        echo "Name: ".$name."<br>";
        echo "Email: ".$email."<br>";

        include_once '../api_rest/index.php';

    } else { // Si no hay código de autorización en la URL, se muestra un enlace que permite realizar
        //  la autorización mediante OAuth 2.0
        echo "<a href='".$client->createAuthUrl()."'>Login with Google</a>";
    }
?>
