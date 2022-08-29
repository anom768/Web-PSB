<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Sessions;
use Anyar\Web\PSB\Domain\Students;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
    private StudentRepository $studentRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->studentRepository->deleteAll();
        $this->sessionRepository->deleteAll();
    }

    public function testSave()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);
        
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = $student->email;
        $return = $this->sessionRepository->saveSession($session);

        self::assertEquals($session->id_session, $return->id_session);
        self::assertEquals($session->email, $return->email);
    }

    public function testFindByIdNotFound()
    {
        $return = $this->sessionRepository->findById("notfound");

        self::assertNull($return);
    }

    public function testFindByIdSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);
        
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = $student->email;
        $this->sessionRepository->saveSession($session);

        $return = $this->sessionRepository->findById($session->id_session);

        self::assertEquals($session->email, $return->email);
    }

    public function testDeleteByIdSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);
        
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = $student->email;
        $this->sessionRepository->saveSession($session);
        $this->sessionRepository->deleteById($session->id_session);
        $return = $this->sessionRepository->findById($session->id_session);

        self::assertNull($return);
    }
}