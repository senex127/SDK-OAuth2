<?php 

namespace App\Providers;

use App\AbstractAuthProvider;

require_once("AbstractAuthProvider.php");


class Server extends AbstractAuthProvider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope, array $params)
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $params);
    }
   
    public function getRequestTokenUri()
    {
        return "http://host.docker.internal:port/token";
    }

    public function getAuthorizeUri()
    {
        return "http://localhost:port/auth";
    }

    public function getBaseUri()
    {
        return "http://host.docker.internal:port/me";
    }

    public function getUser(): array {

        $data = $this->getData();

        $user = [
            "first_name" => $data["firstname"] ?? "",
            "last_name" => $data["lastname"] ?? "",
            "provider_id" => $data["user_id"] ?? "",
        ];

        function result($user){ 
            echo "Hello {$user['first_name']} {$user['last_name']} <br>
            <iframe src=\"https://giphy.com/embed/dSdvPrKU0w8WGo4c9L\" width=\"480\" height=\"269\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>";
        }

       return $user; 
    }

}


?>