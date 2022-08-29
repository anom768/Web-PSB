<?php

namespace Anyar\Web\PSB\Middleware;

require_once __DIR__ . "/../Helper/Helper.php";

putenv("mode=test");

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Sessions;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Repository\AdminRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use Anyar\Web\PSB\Service\SessionService;
use PHPUnit\Framework\TestCase;

class MustNotLoginMiddlewareTest extends TestCase
{
    private MustNotLoginMiddleware $middleware;
    private StudentRepository $studentRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;
    private AdminRepository $adminRepository;

    protected function setUp(): void
    {
        $this->middleware = new MustNotLoginMiddleware();
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->adminRepository = new AdminRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->studentRepository, $this->adminRepository);

        $this->studentRepository->deleteAll();
        $this->sessionRepository->deleteAll();
    }

    public function testBeforeGuest()
    {
        $this->middleware->before();
        $this->expectOutputRegex("[]");
    }

    public function testBeforStudent()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom", PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = $student->email;
        $this->sessionRepository->saveSession($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id_session;

        $this->middleware->before();

        $this->expectOutputRegex("[Location:/]");
    }

    public function testBeforAdmin()
    {
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = "bangkitunom87@gmail.com";
        $this->sessionRepository->saveSession($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id_session;

        $this->middleware->before();

        $this->expectOutputRegex("[Location:/]");
    }
}