<?php

namespace Anyar\Web\PSB\Service;

use Anyar\Web\PSB\Domain\Admin;
use Anyar\Web\PSB\Domain\Sessions;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Repository\AdminRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;

class SessionService
{
    public static $COOKIE_NAME = "X-BAS-SESSION";
    private StudentRepository $studentRepository;
    private SessionRepository $sessionRepository;
    private AdminRepository $adminRepository;

    public function __construct(SessionRepository $sessionRepository, StudentRepository $studentRepository, AdminRepository $adminRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->sessionRepository = $sessionRepository;
        $this->adminRepository = $adminRepository;
    }

    public function createSession(string $email):Sessions
    {
        $session = new Sessions();
        $session->id_session = uniqid();
        $session->email = $email;
        $this->sessionRepository->saveSession($session);

        setcookie(self::$COOKIE_NAME,$session->id_session,time()+(60*60*24),"/");

        return $session;
    }

    public function currentSession():?Students
    {
        $id_session = $_COOKIE[self::$COOKIE_NAME] ?? "";
        $session = $this->sessionRepository->findById($id_session);
        if ($session == null) {return null;}
        else {return $this->studentRepository->findByEmail($session->email);}
    }

    public function currentSessionAdmin():?Admin
    {
        $id_session = $_COOKIE[self::$COOKIE_NAME] ?? "";
        $session = $this->sessionRepository->findById($id_session);
        if ($session == null) {return null;}
        else {return $this->adminRepository->findByEmail($session->email);}
    }

    public function destroySession()
    {
        $id_session = $_COOKIE[self::$COOKIE_NAME] ?? "";
        $this->sessionRepository->deleteById($id_session);

        setcookie(self::$COOKIE_NAME,"",1,"");
    }
}