<?php


namespace App;


use App\ProviderFactory;


require_once("config.php");




function myAutoloader( $class )
{
    $class = str_ireplace("App\\","",$class);
    $class = str_replace("\\","/",$class);
    
    if(file_exists($class.".php")){
        include $class.".php";
    }
}

spl_autoload_register("App\myAutoloader");

session_start();


    $factory = new ProviderFactory($config);
    $fb_callback = $factory->getProvider("facebook");
    $gg_callback = $factory->getProvider("google");
    $callback = $factory->getProvider("server");
    $discord_callback = $factory->getProvider("discord");


$route = $_SERVER['REQUEST_URI'];
switch (strtok($route, "?")) {
    case '/login':
        break;
    case '/callback':
        $callback->getToken();
        $data = $callback->getUser();
        break;
    case '/discord_callback':
        $discord_callback->getToken();
        $data = $discord_callback->getUser();
        break;
    case '/fb_callback':
        $fb_callback->getToken();
        $data = $fb_callback->getUser();
        break;
    case '/gg_callback';
        $gg_callback->getToken();
        $data = $gg_callback->getUser();
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

        <form action="callback">
            <input type="text" name="username">
            <input type="text" name="password">
            <input type="submit" value="Login">
        </form>


        <a class="auth" href='<?php echo $fb_callback->login() ?>'>Login with Facebook</a>
        <a class="auth" href='<?php echo $gg_callback->login() ?>'>Login with Google</a>
        <a class="auth" href='<?php echo $callback->login() ?>'>Login with LocalServer</a>
        <a class="auth" href='<?php echo $discord_callback->login() ?>'>Login with Discord</a>


</body>

</html>