<?php
$config = [
    "discord" => [
    "client_id" => "client_id",
    "client_secret" => "client_secret",
    "redirect_uri" => "http://localhost:8083/discord_callback",
    "scope" => "identify guilds email",
     "params" => []   
],
    "google" => [
        "client_id" => "327719897197-bvauroi6rmsecn9fakolaeti6c8ilv8j.apps.googleusercontent.com",
        "client_secret" => "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",
        "redirect_uri" => "http://localhost:8083/gg_callback",
        "scope" => "",
        "params" => []   
    ],
    "server" => [
        "client_id" => "621e3b8d1f964",
        "client_secret" => "621e3b8d1f966",
        "redirect_uri" => "http://localhost:8083/callback",
        "scope" => "t",
        "params" => []  
    ],
    "facebook" => [
        "client_id" => "2329530167216445",
        "client_secret" => "c5a9b7db815e9fcda4d363a351cfecc7",
        "redirect_uri" => "http://localhost:8083/fb_callback",
        "scope" => "publish_actions, public_profile,email",
        "params" => ["fields" => "name, email, first_name, last_name"]
    ]
    ];