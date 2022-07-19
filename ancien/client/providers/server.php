<?php 

namespace App\Providers;

use App\AbstractClass;

use function App\Providers\result as ProvidersResult;

require_once("AbstractClass.php");


class Server extends AbstractClass
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope, array $params)
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $params);
    }
   
    public function getRequestTokenUri()
    {
        return "http://host.docker.internal:8085/token";
    }

    public function getAuthorizeUri()
    {
        return "http://localhost:8085/auth";
    }

    public function getBaseUri()
    {
        return "http://host.docker.internal:8085/me";
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
            <iframe src=\"https://giphy.com/embed/ule4vhcY1xEKQ\" width=\"480\" height=\"480\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>";
            }

       return result($user); 
    }

}


?>