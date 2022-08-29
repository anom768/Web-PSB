<?php

namespace Anyar\Web\PSB\Controller;

use Anyar\Web\PSB\App\View;
use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Score;
use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\AdminLoginRequest;
use Anyar\Web\PSB\Repository\AdminRepository;
use Anyar\Web\PSB\Repository\FormScoreRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use Anyar\Web\PSB\Service\AdminService;
use Anyar\Web\PSB\Service\SessionService;

class AdminController
{
    private StudentRepository $studentRepository;
    private FormScoreRepository $formScoreRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;
    private AdminRepository $adminRepository;
    private AdminService $adminService;

    public function __construct()
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->formScoreRepository = new FormScoreRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->adminRepository = new AdminRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->studentRepository, $this->adminRepository);
        $this->adminService = new AdminService();

        $student = $this->sessionService->currentSession();
        if ($student != null) { View::redirec("/");}
    }

    public function login()
    {
        View::render("Admin/login",[
            "title" => "Admin Login"
        ]);
    }

    public function postLogin()
    {
        $request = new AdminLoginRequest();
        $request->email = $_POST["email"];
        $request->password = $_POST["password"];
        
        try {
            $this->adminService->login($request);
            $this->sessionService->createSession($request->email);
            View::redirec("/");
        } catch (ValidationException $e) {
            View::render("Admin/login",[
                "title" => "Admin Login",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function studentsData()
    {
        if (isset($_POST["search"])) {
            $formScore = $this->formScoreRepository->findFormScoreByKeyWord($_POST["searching"]);
        } else {
            $formScore = $this->formScoreRepository->findFormScoreByAll();
        }

        View::render("Student/data",[
            "title" => "Student Data",
            "formScore" => $formScore
        ]);
    }

    public function logout()
    {
        $this->sessionService->destroySession();
        View::redirec("/");
    }

    public function print()
    {
        $formScore = $this->formScoreRepository->findFormScoreByAll();
        View::render("Admin/print",[
            "title" => "Print Student Data",
            "formScore" => $formScore
        ]);
    }

    public function updateData()
    {
        $formScore = $this->formScoreRepository->findFormScoreByStudentEmail($_GET["email"]);
        View::render("Admin/update",[
            "title" => "Update Data",
            "id_registration" => $formScore["id_registration"],
            "school_year" => $formScore["school_year"],
            "major" => $formScore["major"],
            "name" => $formScore["name"],
            "place_ob" => $formScore["place_ob"],
            "date_ob" => $formScore["date_ob"],
            "gender" => $formScore["gender"],
            "religion" => $formScore["religion"],
            "phone" => $formScore["phone"],
            "address" => $formScore["address"],
            "b_indo" => $formScore["b_indo"],
            "b_ing" => $formScore["b_ing"],
            "mtk" => $formScore["mtk"],
            "email" => $formScore["email"]
        ]);
    }

    public function postUpdateData()
    {
        $admin = $this->sessionService->currentSessionAdmin();

        $score = new Score();
        $score->student_email = $_GET["email"];
        $score->result = $_POST["result"];
        $score->note = $_POST["note"];
        $score->admin_email = $admin->email;
        $this->formScoreRepository->updateScore($score);

        View::redirec("/students/data");
    }

    public function delete()
    {
        $this->formScoreRepository->deleteFormScoreByEmail($_GET["email"]);

        View::redirec("/students/data");
    }
}