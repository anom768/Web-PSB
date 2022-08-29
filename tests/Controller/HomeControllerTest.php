<?php

namespace Anyar\Web\PSB\Controller;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Sessions;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use Anyar\Web\PSB\Service\SessionService;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    private HomeController $homeController;
    private StudentRepository $studentRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->homeController = new HomeController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->studentRepository = new StudentRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->studentRepository->deleteAll();
    }
    public function testGuest()
    {
        $this->homeController->index();

        $this->expectOutputRegex("[Penerimaan Siswa Baru]");
    }

    public function testStudent()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);
        
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = $student->email;
        $this->sessionRepository->saveSession($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id_session;

        $this->homeController->index();

        $this->expectOutputRegex("[$session->email]");
    }

    public function testAdmin()
    {
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = "bangkitunom87@gmail.com";
        $this->sessionRepository->saveSession($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id_session;

        $this->homeController->index();

        $this->expectOutputRegex("[Selamat datang bangkitunom87@gmail.com]");
    }
}