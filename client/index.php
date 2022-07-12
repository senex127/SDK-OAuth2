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

function login()
{
    $queryParams= http_build_query(array(
        "client_id" => "621e3b8d1f964",
        "redirect_uri" => "http://localhost:8081/callback",
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
    echo "<a class=\"auth\" href=\"http://localhost:8080/auth?{$queryParams}\">Se connecter via Oauth Server</a><br/>";
    $queryParams= http_build_query(array(
        "client_id" => "2329530167216445",
        "redirect_uri" => "http://localhost:8083/fb_callback",
        "response_type" => "code",
        "scope" => "public_profile,email",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a class=\"auth\" href=\"https://www.facebook.com/v2.10/dialog/oauth?{$queryParams}\">Se connecter via Facebook</a><br/>";
    $queryParams= http_build_query(array(
        "client_id" => "327719897197-bvauroi6rmsecn9fakolaeti6c8ilv8j.apps.googleusercontent.com",
        "redirect_uri" => "http://localhost:8083/gg_callback",
        "response_type" => "code",
        "scope" => "email",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a class=\"auth\" href=\"https://accounts.google.com/o/oauth2/v2/auth?{$queryParams}\">Se connecter via Google</a></div>";
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
    $redirectUri = "http://localhost:8083/callback";
    $data = http_build_query(array_merge([
        "redirect_uri" => $redirectUri,
        "client_id" => $clientId,
        "client_secret" => $clientSecret
    ], $specifParams));
    $url = "http://oauth-server:8080/token?{$data}";
    $result = file_get_contents($url);
    $result = json_decode($result, true);
    $accessToken = $result['access_token'];

    $url = "http://oauth-server:8080/me";
    $options = array(
        'http' => array(
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $accessToken
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    echo "Hello {$result['lastname']}
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
    $redirectUri = "http://localhost:8083/fb_callback"; 
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
    $redirectUri = "http://localhost:8083/gg_callback";
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
    default:
        echo '404';
        break;
}

?>

</body>
</html>