<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Students;
use PHPUnit\Framework\TestCase;

class StudentRepositoryTest extends TestCase
{
    private StudentRepository $studentRepository;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());

        $this->studentRepository->deleteAll();
    }

    public function testSaveStudentSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $return = $this->studentRepository->saveStudent($student);

        self::assertEquals($student->email, $return->email);
        self::assertTrue(password_verify("anom",$student->password));
    }

    public function testFindByEmailSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $return = $this->studentRepository->findByEmail($student->email);

        self::assertNotNull($return->id_student);
        self::assertEquals($student->email, $return->email);
        self::assertTrue(password_verify("anom",$return->password));
    }

    public function testFindByEmailNotFound()
    {
        $return = $this->studentRepository->findByEmail("notfound");

        self::assertNull($return);
    }

    public function testGenerateNumberRegistration()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $return = $this->studentRepository->findByEmail($student->email);

        $number = $this->studentRepository->generateNumberRegistration();

        self::assertEquals($return->id_student,$number);
    }

    public function testGenerateEmailRegistration()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $return = $this->studentRepository->generateEmailRegistration($student->email);

        self::assertEquals("ANO", $return);
    }
}