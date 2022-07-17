<?php 

namespace App\Providers;

use App\AbstractAuthProvider;

require_once("AbstractAuthProvider.php");


class Google extends AbstractAuthProvider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope, array $params)
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $params);
    }
   
    public function getRequestTokenUri()
    {
        return "https://oauth2.googleapis.com/token";
    }

    public function getAuthorizeUri()
    {
        return "https://oauth2.googleapis.com/authorize";
    }

    public function getBaseUri()
    {
        return "https://www.googleapis.com/oauth2/v1/userinfo";
    }


    public function getUser(): array {

        $data = $this->getData();

        $user = [
            "user_name" => $data["login"] ?? "",
            "first_name" => $data["first_name"] ?? "",
            "last_name" => $data["last_name"] ?? "",
            "email" => $data["email"] ?? "",
            "provider_id" => $data["id"] ?? "",
            "provider_name" => "google",
        ];

        function result($user){ 
            echo "Hello {$user['email']}
            <br/>
            <iframe src=\"https://giphy.com/embed/cp9mafwcwRCkU\" width=\"480\" height=\"246\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>"; 
            }

       return $user; 
    }


}


?>