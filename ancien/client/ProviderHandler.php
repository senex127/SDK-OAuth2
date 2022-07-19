<?php

namespace App;

use App\ProviderHandler;

use App\providers\Facebook;
use App\providers\Discord;
use App\providers\Google;
use App\providers\server;




class ProviderHandler {

    protected $providers = [];
    protected $configs = [];


    public function __construct($configs)
    {
        $this->providers = [
            "facebook" => Facebook::class,
            "discord" => Discord::class,
            "google" => Google::class,
            "server" => Server::class,
        ];

        $this -> configs = $configs;

    }


    public function factory($name, $config): AbstractClass
    {
        $class = $this->providers[$name];
        return new $class($config["client_id"], $config["client_secret"], $config["redirect_uri"], $config["scope"], $config["params"]);
    }


    public function getProvider($name): AbstractClass
    {
        return $this->factory($name, $this->configs[$name]);
    }

    
}
