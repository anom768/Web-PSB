<?php

namespace Anyar\Web\PSB\Service;

require_once __DIR__ . "/../Helper/Helper.php";

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Sessions;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Repository\AdminRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
    private StudentRepository $studentRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;
    private AdminRepository $adminRepository;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->adminRepository = new AdminRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository,$this->studentRepository, $this->adminRepository);

        $this->studentRepository->deleteAll();
        $this->sessionRepository->deleteAll();

        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);
    }

    public function testCreateSession()
    {
       $return = $this->sessionService->createSession("anom@gmail.com");

        self::expectOutputRegex("[X-BAS-SESSION: $return->id_session]");

        $result = $this->sessionRepository->findById($return->id_session);

        self::assertEquals($return->id_session, $result->id_session);
    }

    public function testCurrentSession()
    {
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = "anom@gmail.com";
        $this->sessionRepository->saveSession($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id_session;

        $return = $this->sessionService->currentSession();

        self::assertNotNull($return);
        self::assertEquals($session->email, $return->email);
    }

    public function testDestroySession()
    {
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = "anom@gmail.com";
        $this->sessionRepository->saveSession($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id_session;

        $this->sessionService->destroySession();

        $return = $this->sessionRepository->findById($session->id_session);

        self::assertNull($return);
        $this->expectOutputRegex("[X-BAS-SESSION]");
    }
}