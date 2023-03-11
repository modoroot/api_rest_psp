<?php
    require_once 'vendor/autoload.php';

    $clientID = '24562032999-s9je57rvqmmmf2nsuivat5u3l296r7ko.apps.googleusercontent.com';
    $clientSecret = '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';
    $redirectUri = 'http://localhost/api_rest_psp/oauth/login.php';

    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope("email");
    $client->addScope("profile");

    if(isset($_GET['code'])){
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        $email = $google_account_info->email;
        $name = $google_account_info->name;

        echo "Name: ".$name."<br>";
        echo "Email: ".$email."<br>";

        include_once '../api_rest/index.php';

    }else{
        echo "<a href='".$client->createAuthUrl()."'>Login with Google</a>";
    }
?>