<?php


namespace App;


use App\ProviderHandler;


require_once("config.php");

session_start();

function myAutoloader( $class )
{
    $class = str_ireplace("App\\","",$class);
    $class = str_replace("\\","/",$class);
    
    if(file_exists($class.".php")){
        include $class.".php";
    }
}

spl_autoload_register("App\myAutoloader");

    $factory = new ProviderHandler($config);
    $fb_callback = $factory->getProvider("facebook");
    $ds_callback = $factory->getProvider("discord");
    $gg_callback = $factory->getProvider("google");
    $callback = $factory->getProvider("server");


    $route = $_SERVER['REQUEST_URI'];
    switch (strtok($route, "?")) {
        case '/login':
            break;
        case '/fb_callback':
            $fb_callback->getToken();
            $data = $fb_callback->getUser();
            var_dump($data);
            break;
        case '/ds_callback':
            $ds_callback->getToken();
            $data = $ds_callback->getUser();
            var_dump($data);
            break;

        case '/gg_callback':
            $gg_callback->getToken();
            $data = $gg_callback->getUser();
            var_dump($data);
            break;
        
        case '/callback':
            $callback->getToken();
            $data = $callback->getUser();
            var_dump($data);
            break;

        default:
            echo '404';
            break;

}

?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

<div class='login'>
    
<h1>SDK-OAUTH</h1>

<?php

echo "
        <form action='callback' method='POST'>
            <input type='text' name='username'>
            <input type='text' name='password'>
            <input type='submit' value='Login'>
        </form>
    ";

?>

<?php
echo "<a class='auth' href=". $ds_callback->login()." ?>Login with Discord</a>";
echo "<a class='auth' href=". $fb_callback->login()." ?>Login with Facebook</a>";
echo "<a class='auth' href=". $gg_callback->login()." ?>Login with Google</a>";
echo "<a class='auth' href=". $callback->login()." ?>Login with Server</a>";

?>


<?php
/* 
function login()
{
    $queryParams= http_build_query(array(
        "client_id" => "621e3b8d1f964",
        "redirect_uri" => "http://localhost:8084/callback",
        "response_type" => "code",
        "scope" => "read,write",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "
        <form action='callback' method='POST'>
            <input type='text' name='username'>
            <input type='text' name='password'>
            <input type='submit' value='Login'>
        </form>
    ";
    echo "<a class=\"auth\" href=\"http://localhost:8084/auth?{$queryParams}\">Se connecter via Oauth Server</a><br/>";
    $queryParams= http_build_query(array(
        "client_id" => "2329530167216445",
        "redirect_uri" => "http://localhost:8084/fb_callback",
        "response_type" => "code",
        "scope" => "public_profile,email",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a class=\"auth\" href=\"https://www.facebook.com/v2.10/dialog/oauth?{$queryParams}\">Se connecter via Facebook</a><br/>";
    $queryParams= http_build_query(array(
        "client_id" => "327719897197-bvauroi6rmsecn9fakolaeti6c8ilv8j.apps.googleusercontent.com",
        "redirect_uri" => "http://localhost:8084/gg_callback",
        "response_type" => "code",
        "scope" => "email",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a class=\"auth\" href=\"https://accounts.google.com/o/oauth2/v2/auth?{$queryParams}\">Se connecter via Google</a><br/>";
    $queryParams= http_build_query(array(
        "client_id" => "988757754296561704",
        "redirect_uri" => "http://localhost:8084/ds_callback",
        "response_type" => "code",
        "scope" => "identify email",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a class=\"auth\" href=\"https://discord.com/api/oauth2/authorize?{$queryParams}\">Se connecter via Discord</a> </div>";
}

function callback()
{
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $specifParams = [
            "grant_type" => "password",
            "username" => $_POST["username"],
            "password" => $_POST["password"]
        ];
    } else {
        $specifParams = [
            "grant_type" => "authorization_code",
            "code" => $_GET["code"],
        ];
    }
    $clientId = "621e3b8d1f964";
    $clientSecret = "621e3b8d1f966";
    $redirectUri = "http://localhost:8084/callback";
    $data = http_build_query(array_merge([
        "redirect_uri" => $redirectUri,
        "client_id" => $clientId,
        "client_secret" => $clientSecret
    ], $specifParams));
    $url = "http://oauth-server:8085/token?{$data}";
    $result = @file_get_contents($url);
    $result = json_decode($result, true);
    $accessToken = @$result['access_token'];

    $url = "http://oauth-server:8085/me";
    $options = array(
        'http' => array(
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $accessToken
        )
    );
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    echo "Hello
    <iframe src=\"https://giphy.com/embed/ule4vhcY1xEKQ\" width=\"480\" height=\"480\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>";
}

function fbcallback()
{
    $specifParams = [
            "grant_type" => "authorization_code",
            "code" => $_GET["code"],
        ];
    $clientId = "2329530167216445"; 
    $clientSecret = "c5a9b7db815e9fcda4d363a351cfecc7"; 
    $redirectUri = "http://localhost:8084/fb_callback"; 
    $data = http_build_query(array_merge([
        "redirect_uri" => $redirectUri,
        "client_id" => $clientId,
        "client_secret" => $clientSecret
    ], $specifParams));

    $url = "https://graph.facebook.com/v2.10/oauth/access_token?{$data}";
    $result = file_get_contents($url);
    $result = json_decode($result, true);
    $accessToken = $result['access_token'];

    $url = "https://graph.facebook.com/v2.10/me";
    $options = array(
        'http' => array(
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $accessToken
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    echo "Hello {$result['name']}
    <iframe src=\"https://giphy.com/embed/dSdvPrKU0w8WGo4c9L\" width=\"480\" height=\"269\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>";
}

function ggcallback(){
    $specifParams = [
            "grant_type" => "authorization_code",
            "code" => $_GET["code"],
        ];
    $clientId = "327719897197-bvauroi6rmsecn9fakolaeti6c8ilv8j.apps.googleusercontent.com";
    $clientSecret = "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";
    $redirectUri = "http://localhost:8084/gg_callback";
    $data = http_build_query(array_merge([
        "redirect_uri" => $redirectUri,
        "client_id" => $clientId,
        "client_secret" => $clientSecret
    ], $specifParams));

    $url = "https://oauth2.googleapis.com/token";
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $data
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    $accessToken = $result['access_token'];

    $url = "https://www.googleapis.com/oauth2/v1/userinfo";
    $options = array(
        'http' => array(
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $accessToken
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    echo "Hello {$result['email']}
    <br/>
    <iframe src=\"https://giphy.com/embed/cp9mafwcwRCkU\" width=\"480\" height=\"246\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>";
}

function dscallback()
{
     //Verif si le code de discord est présent    
    if(!isset($_GET['code'])){ 
        echo 'no code';
        die();     }     
        
        $ds_code = $_GET['code'];
        $payload = ['code' => $ds_code,
        'client_id' => '988757754296561704',
        'client_secret' => '_43o9fV1w0XxnPtOfgedeogag-U51lDR',
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'http://localhost:8084/ds_callback',
        ];

        $payload_str = http_build_query($payload);
        $discord_token_url = "https://discord.com/api/v10/oauth2/token";
        $options = ['http' => ['header'  => "Accept: application/json\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($payload_str) . "\r\n",
        'method'  => 'POST',             
        'content' => $payload_str ]];     
        $context  = stream_context_create($options);     
        $result = file_get_contents($discord_token_url, false, $context);
        // echo 'test: '.$result ;
        $result = json_decode($result, true);
        
        $accessToken = $result["access_token"];
        // echo 'access_token: '.$accessToken.'<br>' ;

        $url = "https://discord.com/api/users/@me";
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $accessToken
            )
        );
    
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        echo 'username '.$result["email"];
        echo '<br>';
        echo 'username '.$result["username"];
}

$route = $_SERVER['REQUEST_URI'];
switch (strtok($route, "?")) {
    case '/login':
        login();
        break;
    case '/callback':
        callback();
        break;
    case '/fb_callback':
        fbcallback();
        break;
    case '/gg_callback';
        ggcallback();
        break;
    case '/ds_callback';
        dscallback();
        break;
    default:
        echo '404';
        break;
}
 */
?>

</body>
</html>