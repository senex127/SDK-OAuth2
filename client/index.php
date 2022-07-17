<?php

namespace App;

use App\Providers\Facebook;
use App\Providers\Server;
use App\Providers\Discord;
use App\Providers\Google;
use App\ProviderFactory;



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
    $fb = $factory->getProvider("facebook");
    $Google = $factory->getProvider("Google");
    $server = $factory->getProvider("server");
    $discord = $factory->getProvider("discord");



$route = $_SERVER['REQUEST_URI'];
switch (strtok($route, "?")) {
    case '/Fblogin':
        echo "<a href='{$fb->loginUrl()}'>Login with Facebook</a>";
        break;
    case '/serverLogin':
    echo "<a href='{$server->loginUrl()}'>Login with Server</a>";
    break;    
    case '/fbAUth':
        $fb->getToken();
        $data = $fb->getData();
              break;
    case '/serverAuth':
        $server->getToken();
        $data = $server->getUser();
        break;
   case '/discordAuth':
        $discord->getToken();
        $data = $discord->getUser();
        break;   
        
    case '/GoogleAuth':
        $Google->getToken();
        $data = $Google->getUser();
        break;
    
    case '/user':
        $data = $fb->getUser();
        break;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

</style>
<body>
<div >
<?php echo isset($data) ?  var_dump($data) : ""?>
</div>
    

<div >
    <div>
        <h2>O2auth Login</h2>
    <a  href='<?php echo $fb->loginUrl() ?>'>Login with Facebook 
</a>
    <a  href='<?php echo $Google->loginUrl() ?>'>Login with Google</a>
    <a href='<?php echo $server->loginUrl() ?>'>Login with LocalServer</a>
    <a  href='<?php echo $discord->loginUrl() ?>'>Login with Discord</a>
    </div>
</div>

</body>
</html>