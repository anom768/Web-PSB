<?php

namespace Anyar\Web\PSB\Service;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\StudentLoginRequest;
use Anyar\Web\PSB\Model\StudentRegistrationRequest;
use Anyar\Web\PSB\Repository\StudentRepository;
use PHPUnit\Framework\TestCase;

class StudentServiceTest extends TestCase
{
    private StudentRepository $studentRepository;
    private StudentService $studentService;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->studentService = new StudentService($this->studentRepository);

        $this->studentRepository->deleteAll();
    }

    public function testRegisterNull()
    {
        $this->expectException(ValidationException::class);

        $request = new StudentRegistrationRequest();
        $request->email = null;
        $request->password = null;
        $this->studentService->register($request);
    }

    public function testRegisterEmpty()
    {
        $this->expectException(ValidationException::class);
        
        $request = new StudentRegistrationRequest();
        $request->email = "   ";
        $request->password = "  ";
        $this->studentService->register($request);
    }

    public function testRegisterDuplicat()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $this->expectException(ValidationException::class);
        
        $request = new StudentRegistrationRequest();
        $request->email = "anom@gmail.com";
        $request->password = "anom";
        $this->studentService->register($request);
    }

    public function testRegisterSuccess()
    {
        $request = new StudentRegistrationRequest();
        $request->email = "anom@gmail.com";
        $request->password = "anom";
        $return = $this->studentService->register($request);

        self::assertEquals($request->email, $return->student->email);
        self::assertTrue(password_verify($request->password, $return->student->password));
    }

    public function testLoginNull()
    {
        $this->expectException(ValidationException::class);

        $request = new StudentLoginRequest();
        $request->email = null;
        $request->password = null;
        $this->studentService->login($request);
    }

    public function testLoginBlank()
    {
        $this->expectException(ValidationException::class);

        $request = new StudentLoginRequest();
        $request->email = "";
        $request->password = "";
        $this->studentService->login($request);
    }

    public function testLoginWrongEmail()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $this->expectException(ValidationException::class);

        $request = new StudentLoginRequest();
        $request->email = "wrong";
        $request->password = "anom";
        $this->studentService->login($request);
    }

    public function testLoginWrongPassword()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $this->expectException(ValidationException::class);

        $request = new StudentLoginRequest();
        $request->email = "anom@gmail.com";
        $request->password = "wrong";
        $this->studentService->login($request);
    }

    public function testLoginSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $request = new StudentLoginRequest();
        $request->email = "anom@gmail.com";
        $request->password = "anom";
        $response = $this->studentService->login($request);

        self::assertEquals($request->email,$response->student->email);
        self::assertTrue(password_verify($request->password, $response->student->password));
    }
}