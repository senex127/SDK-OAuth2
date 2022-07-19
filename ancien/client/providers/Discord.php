<?php 

namespace App\Providers;

use App\AbstractClass;

require_once("AbstractClass.php");


class Discord extends AbstractClass
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
        ];

        function result($user){ 
            echo "Hello {$user['user_name']}
            <br/>
            <iframe src=\"https://giphy.com/embed/kqGp0mQGvdsg2MEiEr\" width=\"480\" height=\"480\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>";
        }
       
       return result($user); 
    }

}


?>