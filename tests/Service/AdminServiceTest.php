<?php

namespace Anyar\Web\PSB\Service;

use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\AdminLoginRequest;
use PHPUnit\Framework\TestCase;

class AdminServiceTest extends TestCase
{
    private AdminService $adminService;

    protected function setUp(): void
    {
        $this->adminService = new AdminService();
    }
    public function testLoginBlank()
    {
        $this->expectException(ValidationException::class);

        $request = new AdminLoginRequest();
        $request->email = "";
        $request->password = "";
        $this->adminService->login($request);
    }

    public function testLoginNull()
    {
        $this->expectException(ValidationException::class);
        
        $request = new AdminLoginRequest();
        $request->email = null;
        $request->password = null;
        $this->adminService->login($request);
    }

    public function testLoginWrongEmail()
    {
        $this->expectException(ValidationException::class);
        
        $request = new AdminLoginRequest();
        $request->email = "wrong";
        $request->password = "123";
        $this->adminService->login($request);
    }

    public function testLoginWrongPassword()
    {
        $this->expectException(ValidationException::class);
        
        $request = new AdminLoginRequest();
        $request->email = "bangkitunom87@gmail.com";
        $request->password = "wrong";
        $this->adminService->login($request);
    }

    public function testLoginWrongSuccess()
    {
        $request = new AdminLoginRequest();
        $request->email = "bangkitunom87@gmail.com";
        $request->password = "123";
        $return = $this->adminService->login($request);

        self::assertNotNull($return);
        self::assertEquals($request->email, $return->admin->email);
        self::assertEquals($request->password, $return->admin->password);
    }
}