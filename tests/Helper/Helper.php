<?php

namespace Anyar\Web\PSB\App
{
    function header(string $value)
    {
        echo $value;
    }
}

namespace Anyar\Web\PSB\Service 
{
    function setcookie(string $name, string $value)
    {
        echo "$name: $value";
    }
}