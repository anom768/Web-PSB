<?php

namespace Anyar\Web\PSB\Controller;

use Anyar\Web\PSB\App\View;
use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\FormRegistrationRequest;
use Anyar\Web\PSB\Model\ScoreRegistrationRequest;
use Anyar\Web\PSB\Model\StudentLoginRequest;
use Anyar\Web\PSB\Model\StudentRegistrationRequest;
use Anyar\Web\PSB\Repository\AdminRepository;
use Anyar\Web\PSB\Repository\FormScoreRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use Anyar\Web\PSB\Service\FormScoreService;
use Anyar\Web\PSB\Service\SessionService;
use Anyar\Web\PSB\Service\StudentService;

class StudentController
{
    private StudentRepository $studentRepository;
    private StudentService $studentService;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;
    private FormScoreRepository $formScoreRepository;
    private FormScoreService $formScoreService;
    private AdminRepository $adminRepository;

    public function __construct()
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->studentService = new StudentService($this->studentRepository);
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->adminRepository = new AdminRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->studentRepository, $this->adminRepository);
        $this->formScoreRepository = new FormScoreRepository(Database::getConnection());
        $this->formScoreService = new FormScoreService();

        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin != null) { View::redirec("/");}
    }
    public function register()
    {
        View::render("Student/register",[
            "title" => "New Student Register"
        ]);
    }

    public function postRegister()
    {
        $request = new StudentRegistrationRequest();
        $request->email = $_POST["email"];
        $request->password = $_POST["password"];
        
        try {
            $this->studentService->register($request);
            View::redirec("/students/login");
        } catch (ValidationException $e) {
            View::render("Student/register",[
                "title" => "New Student Register",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function login()
    {
        View::render("Student/login",[
            "title" => "Student Login"
        ]);
    }

    public function postLogin()
    {
        $request = new StudentLoginRequest();
        $request->email = $_POST["email"];
        $request->password = $_POST["password"];

        try {
            $this->studentService->login($request);
            $this->sessionService->createSession($request->email);
            View::redirec("/");
        } catch (ValidationException $e) {
            View::render("Student/login",[
                "title" => "Student Login",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function formScoreRegistration()
    {
        $student = $this->sessionService->currentSession();

        $formScore = $this->formScoreRepository->findFormScoreByStudentEmail($student->email);
        if ($formScore == null) {
            View::render("Student/registration",[
                "title" => "Form Registration",
                "email" => $student->email
            ]);
        } else {
            View::render("Student/registered",[
                "title" => "Registered",
                "email" => $student->email
            ]);
        }
    }

    public function postFormScoreRegistration()
    {
        $student = $this->sessionService->currentSession();

        $formRequest = new FormRegistrationRequest();
        $formRequest->id_registration = $this->formScoreRepository->generateIdRegistration($student->email);
        $formRequest->email = $student->email;
        $formRequest->date_registration = date("Y-m-d H:i:s");
        $formRequest->school_year = $_POST["school_year"];
        $formRequest->major = $_POST["major"];
        $formRequest->name = $_POST["name"];
        $formRequest->place_ob = $_POST["place_ob"];
        $formRequest->date_ob = $_POST["date_ob"];
        $formRequest->gender = $_POST["gender"];
        $formRequest->religion = $_POST["religion"];
        $formRequest->phone = $_POST["phone"];
        $formRequest->address = $_POST["address"];

        $scoreRequest = new ScoreRegistrationRequest();
        $scoreRequest->student_email = $student->email;
        $scoreRequest->b_indo = $_POST["b_indo"];
        $scoreRequest->b_ing = $_POST["b_ing"];
        $scoreRequest->mtk = $_POST["mtk"];

        try {
            $this->formScoreService->formScoreRegistration($formRequest, $scoreRequest);
            View::redirec("/students/registration");
        } catch (ValidationException $e) {
            View::render("Student/registration",[
                "title" => "Form Registration",
                "email" => $student->email,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        $this->sessionService->destroySession();
        View::redirec("/");
    }

    public function postRegistrationCard()
    {
        $student = $this->sessionService->currentSession();
        $formScore = $this->formScoreRepository->findFormScoreByStudentEmail($student->email);

        View::render("Student/card",[
            "title" => "Student Registration Card",
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
            "mtk" => $formScore["mtk"]
        ]);
    }

    public function announcement()
    {
        $student = $this->sessionService->currentSession();
        $formScore = $this->formScoreRepository->findFormScoreByStudentEmail($student->email);

        $note = "";
        if ($formScore["result"] == null) {
            $note = "Kami masih meninjau datamu";
        } elseif ($formScore["result"] == "Lulus") {
            $note = "Selamat kamu lulus";
        } else {
            $note = "Maaf kamu tidak lulus, karena ". $formScore['note'];
        }

        View::render("Student/announcement",[
            "title" => "Announcement",
            "note" => $note,
            "admin" => $formScore["admin_email"]
        ]);
    }
}