<?php
$config = [
    "facebook" => [
        "client_id" => "2329530167216445",
        "client_secret" => "c5a9b7db815e9fcda4d363a351cfecc7",
        "redirect_uri" => "http://localhost:8084/fb_callback",
        "scope" => "public_profile,email",
        "params" => ["fields" => "name"]
    ],


    "discord" => [
        "client_id" => "988757754296561704",
        "client_secret" => "_43o9fV1w0XxnPtOfgedeogag-U51lDR",
        "redirect_uri" => "http://localhost:8084/ds_callback",
        "scope" => "identify email",
        "params" => []
    ],

    "server" => [
        "client_id" => "621e3b8d1f964",
        "client_secret" => "621e3b8d1f966",
        "redirect_uri" => "http://localhost:8084/callback",
        "scope" => "t",
        "params" => []  
    ],

    "google" => [
        "client_id" => "327719897197-bvauroi6rmsecn9fakolaeti6c8ilv8j.apps.googleusercontent.com",
        "client_secret" => "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",
        "redirect_uri" => "http://localhost:8084/gg_callback",
        "scope" => "",
        "params" => []   
    ],

    ];

    