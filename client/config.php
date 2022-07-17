<?php
$config = [
    "discord" => [
    "client_id" => "client_id",
    "client_secret" => "client_secret",
    "redirect_uri" => "http://localhost:port/discordAuth",
    "scope" => "identify guilds email",
     "params" => []   
],
    "Google" => [
        "client_id" => "client_id",
        "client_secret" => "client_secret",
        "redirect_uri" => "http://localhost:port/GoogleAuth",
        "scope" => "user_read",
        "params" => []   
    ],
    "server" => [
        "client_id" => "client_id",
        "client_secret" => "client_secret",
        "redirect_uri" => "http://localhost:port/serverAuth",
        "scope" => "t",
        "params" => []  
    ],
    "facebook" => [
        "client_id" => "client_id",
        "client_secret" => "client_secret",
        "redirect_uri" => "http://localhost:port/fbAUth",
        "scope" => "publish_actions, public_profile,email",
        "params" => ["fields" => "name, email, first_name, last_name"]
    ]
    ];