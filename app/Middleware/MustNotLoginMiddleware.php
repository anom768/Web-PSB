<?php

namespace Anyar\Web\PSB\Middleware;

use Anyar\Web\PSB\App\View;
use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Repository\AdminRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use Anyar\Web\PSB\Service\SessionService;

class MustNotLoginMiddleware implements Middleware
{
    private StudentRepository $studentRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;
    private AdminRepository $adminRepository;

    public function __construct()
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->adminRepository = new AdminRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->studentRepository, $this->adminRepository);
    }
    public function before()
    {
        $student = $this->sessionService->currentSession();
        $admin = $this->sessionService->currentSessionAdmin();

        if ($student != null || $admin != null) {
            View::redirec("/");
        }
    }
}