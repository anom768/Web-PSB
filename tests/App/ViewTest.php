<?php

namespace Anyar\Web\PSB\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        View::render("Home/index",[
            "title" => "Penerimaan Siswa Baru"
        ]);

        $this->expectOutputRegex("[Penerimaan Siswa Baru]");
    }

    public function testRedirect()
    {
        require_once __DIR__ . "/../Helper/Helper.php";
        putenv("mode=test");
        View::redirec("/");

        $this->expectOutputRegex("[Location:/]");
    }
}