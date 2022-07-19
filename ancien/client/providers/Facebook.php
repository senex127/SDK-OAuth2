<?php 

namespace App\Providers;

use App\AbstractClass;

require_once("AbstractClass.php");


class Facebook extends AbstractClass
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope, array $params)
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $params);
    }
   
    public function getRequestTokenUri()
    {
        return "https://graph.facebook.com/v2.10/oauth/access_token";
    }

    public function getAuthorizeUri()
    {
        return "https://www.facebook.com/v2.10/dialog/oauth";
    }

    public function getBaseUri()
    {
        return "https://graph.facebook.com/v2.10/me";
    }

    public function getUser(): array {

        $data = $this->getData();

        $user = [
            "first_name" => $data["first_name"] ?? "",
            "last_name" => $data["last_name"] ?? "",
            "email" => $data["email"] ?? "",
            "provider_id" => $data["id"] ?? "",
            "provider_name" => "facebook",
        ];

        function result($user){ 
            echo "Hello {$user['first_name']}";
        }
       
       return $user; 
    }

}


?>