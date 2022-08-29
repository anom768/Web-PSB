<?php

function getDatabaseConfig()
{
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306;dbname=new_psb_test",
                "username" => "root",
                "password" => ""
            ],
            "prod" => [
                "url" => "mysql:host=localhost:3306;dbname=new_psb",
                "username" => "root",
                "password" => ""
            ]
        ]
            ];
}