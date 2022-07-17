<?php 

namespace App\Providers;

use App\AbstractAuthProvider;

require_once("AbstractAuthProvider.php");


class Discord extends AbstractAuthProvider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope, array $params)
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $params);
    }
   
    public function getRequestTokenUri()
    {
        return "https://discord.com/api/oauth2/token";
    }

    public function getAuthorizeUri()
    {
        return "https://discord.com/api/oauth2/authorize";
    }

    public function getBaseUri()
    {
        return "https://discord.com/api/users/@me";
    }

    public function getUser(): array {

        $data = $this->getData();
 

        $user = [
            "user_name" => $data["username"] ?? "",
            "first_name" => $data["first_name"] ?? "",
            "last_name" => $data["last_name"] ?? "",
            "email" => $data["email"] ?? "",
            "provider_id" => $data["id"] ?? "",
            "provider_name" => "discord",
        ];

       return $user; 
    }

}

?>