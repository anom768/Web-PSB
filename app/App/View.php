<?php

namespace Anyar\Web\PSB\App;

class View
{
    public static function render(string $pathFile, $model)
    {
        require __DIR__ . "/../View/css/style.php";
        require __DIR__ . "/../View/" . $pathFile . ".php";
    }

    public static function redirec(string $url)
    {
        header("Location:$url");
        if (getenv("mode") != "test") {exit();}
    }
}