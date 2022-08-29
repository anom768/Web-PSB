<?php

namespace Anyar\Web\PSB\Controller;

require_once __DIR__ . "/../Helper/Helper.php";

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Form;
use Anyar\Web\PSB\Domain\Score;
use Anyar\Web\PSB\Domain\Sessions;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Repository\FormScoreRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use Anyar\Web\PSB\Service\SessionService;
use PHPUnit\Framework\TestCase;

putenv("mode=test");
class StudentControllerTest extends TestCase
{
    private StudentRepository $studentRepository;
    private StudentController $studentController;
    private SessionRepository $sessionRepository;
    private FormScoreRepository $formScoreRepository;
    private AdminController $adminController;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->studentController = new StudentController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->formScoreRepository = new FormScoreRepository(Database::getConnection());
        $this->adminController = new AdminController();

        $this->studentRepository->deleteAll();
        $this->sessionRepository->deleteAll();
        $this->formScoreRepository->deleteAll();
    }

    public function testViewRegister()
    {
        $this->studentController->register();

        $this->expectOutputRegex("[New Student Register]");
    }
    public function testViewRegisterNull()
    {
        $_POST["email"] = null;
        $_POST["password"] = null;

        $this->studentController->postRegister();

        self::expectOutputRegex("[Email and password can not blank]");
    }

    public function testViewRegisterBlank()
    {
        $_POST["email"] = "";
        $_POST["password"] = "";

        $this->studentController->postRegister();

        self::expectOutputRegex("[Email and password can not blank]");
    }

    public function testViewRegisterDuplicate()
    {
        $student = new Students();
        $student->email = "bangkit@gmail.com";
        $student->password = password_hash("bangkit",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);
        
        $_POST["email"] = "bangkit@gmail.com";
        $_POST["password"] = "bangkit";

        $this->studentController->postRegister();

        self::expectOutputRegex("[Email already exist]");
    }

    public function testViewRegisterSuccess()
    {
        $_POST["email"] = "bangkit@gmail.com";
        $_POST["password"] = "bangkit";

        $this->studentController->postRegister();

        self::expectOutputRegex("[Location:/students/login]");
    }

    public function testViewLogin()
    {
        $this->studentController->login();

        self::expectOutputRegex("[Student Login]");
    }

    public function testViewLoginNull()
    {
        $_POST["email"] = null;
        $_POST["password"] = null;

        $this->studentController->postLogin();

        self::expectOutputRegex("[Email and password can not blank]");
    }

    public function testViewLoginBlank()
    {
        $_POST["email"] = "";
        $_POST["password"] = "";

        $this->studentController->postLogin();

        self::expectOutputRegex("[Email and password can not blank]");
    }

    public function testViewLoginWrongEmail()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $_POST["email"] = "wrong";
        $_POST["password"] = "anom";

        $this->studentController->postLogin();

        self::expectOutputRegex("[Email or password is wrong]");
    }

    public function testViewLoginWrongPassword()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $_POST["email"] = "anom@gmail.com";
        $_POST["password"] = "wrong";

        $this->studentController->postLogin();

        self::expectOutputRegex("[Email or password is wrong]");
    }

    public function testViewLoginSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $_POST["email"] = "anom@gmail.com";
        $_POST["password"] = "anom";

        $this->studentController->postLogin();

        self::expectOutputRegex("[Location:/]");
    }

    public function testViewFormScoreRegistration()
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

        $this->studentController->formScoreRegistration();

        $this->expectOutputRegex("[Form Registration]");
    }

    public function testViewFormScoreRegistered()
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
        
        $form = new Form();
        $form->id_registration = $this->formScoreRepository->generateIdRegistration($student->email);
        $form->email = "anom@gmail.com";
        $form->date_registration = date("Y-m-d H:i:s");
        $form->school_year = "2022/2023";
        $form->major = "Multimedia";
        $form->name = "Bangkit Anom Sedhayu";
        $form->place_ob = "Cilacap";
        $form->date_ob = date("Y-m-d");
        $form->gender = "Laki-Laki";
        $form->religion = "Islam";
        $form->phone = "089";
        $form->address = "Jln Tangkuban Perahu";
        $this->formScoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $this->formScoreRepository->saveScore($score);

        $this->studentController->formScoreRegistration();

        $this->expectOutputRegex("[Registered]");
    }

    public function testViewPostFormScoreRegistrationSuccess()
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

        $_POST["school_year"] = "2022/2023";
        $_POST["major"] = "Multimedia";
        $_POST["name"] = "Bangkit";
        $_POST["place_ob"] = "Cilacap";
        $_POST["date_ob"] = date("Y-m-d");
        $_POST["gender"] = "Laki-laki";
        $_POST["religion"] = "Islam";
        $_POST["phone"] = "089";
        $_POST["address"] = "Jln";

        $_POST["b_indo"] = 100;
        $_POST["b_ing"] = 100;
        $_POST["mtk"] = 90;

        $this->studentController->postFormScoreRegistration();

        $this->expectOutputRegex("[Location:/students/registration]");
    }

    public function testViewPostFormScoreRegistrationBlankForm()
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

        $_POST["school_year"] = "2022/2023";
        $_POST["major"] = "Multimedia";
        $_POST["name"] = "";
        $_POST["place_ob"] = "";
        $_POST["date_ob"] = date("Y-m-d");
        $_POST["gender"] = "Laki-laki";
        $_POST["religion"] = "Islam";
        $_POST["phone"] = "";
        $_POST["address"] = "";

        $_POST["b_indo"] = 100;
        $_POST["b_ing"] = 100;
        $_POST["mtk"] = 90;

        $this->studentController->postFormScoreRegistration();

        $this->expectOutputRegex("[Form can not blank]");
    }

    public function testLogout()
    {
        $this->studentController->logout();

        $this->expectOutputRegex("[Location:/]");
    }

    public function testViewPostStudentRegistrationCard()
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

        $form = new Form();
        $form->id_registration = $this->formScoreRepository->generateIdRegistration($student->email);
        $form->email = "anom@gmail.com";
        $form->date_registration = date("Y-m-d H:i:s");
        $form->school_year = "2022/2023";
        $form->major = "Multimedia";
        $form->name = "Bangkit Anom Sedhayu";
        $form->place_ob = "Cilacap";
        $form->date_ob = date("Y-m-d");
        $form->gender = "Laki-Laki";
        $form->religion = "Islam";
        $form->phone = "089";
        $form->address = "Jln Tangkuban Perahu";
        $this->formScoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $score->result = "Lulus";
        $score->note = "Sangat bagus"; 
        $score->admin_email = "admin";
        $this->formScoreRepository->saveScore($score);

        $this->studentController->postRegistrationCard();

        $this->expectOutputRegex("[Student Registration Card]");
    }

    public function testViewAnnouncementReviewingData()
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

        $form = new Form();
        $form->id_registration = $this->formScoreRepository->generateIdRegistration($student->email);
        $form->email = "anom@gmail.com";
        $form->date_registration = date("Y-m-d H:i:s");
        $form->school_year = "2022/2023";
        $form->major = "Multimedia";
        $form->name = "Bangkit Anom Sedhayu";
        $form->place_ob = "Cilacap";
        $form->date_ob = date("Y-m-d");
        $form->gender = "Laki-Laki";
        $form->religion = "Islam";
        $form->phone = "089";
        $form->address = "Jln Tangkuban Perahu";
        $this->formScoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $this->formScoreRepository->saveScore($score);

        $this->studentController->announcement();

        $this->expectOutputRegex("[Kami masih meninjau datamu]");
    }

    public function testViewAnnouncementNotPassed()
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

        $form = new Form();
        $form->id_registration = $this->formScoreRepository->generateIdRegistration($student->email);
        $form->email = "anom@gmail.com";
        $form->date_registration = date("Y-m-d H:i:s");
        $form->school_year = "2022/2023";
        $form->major = "Multimedia";
        $form->name = "Bangkit Anom Sedhayu";
        $form->place_ob = "Cilacap";
        $form->date_ob = date("Y-m-d");
        $form->gender = "Laki-Laki";
        $form->religion = "Islam";
        $form->phone = "089";
        $form->address = "Jln Tangkuban Perahu";
        $this->formScoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $score->result = "Tidak Lulus";
        $score->note = "Nilai kurang";
        $score->admin_email = "bangkit";
        $this->formScoreRepository->saveScore($score);

        $this->studentController->announcement();

        $this->expectOutputRegex("[Maaf kamu tidak lulus, karena Nilai kurang]");
    }

    public function testViewAnnouncementPassed()
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

        $form = new Form();
        $form->id_registration = $this->formScoreRepository->generateIdRegistration($student->email);
        $form->email = "anom@gmail.com";
        $form->date_registration = date("Y-m-d H:i:s");
        $form->school_year = "2022/2023";
        $form->major = "Multimedia";
        $form->name = "Bangkit Anom Sedhayu";
        $form->place_ob = "Cilacap";
        $form->date_ob = date("Y-m-d");
        $form->gender = "Laki-Laki";
        $form->religion = "Islam";
        $form->phone = "089";
        $form->address = "Jln Tangkuban Perahu";
        $this->formScoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $score->result = "Lulus";
        $score->note = "Selamat ya";
        $score->admin_email = "bangkit";
        $this->formScoreRepository->saveScore($score);

        $this->studentController->announcement();

        $this->expectOutputRegex("[Selamat kamu lulus]");
    }

    // public function testAccessAdminPage()
    // {
    //     $student = new Students();
    //     $student->email = "anom@gmail.com";
    //     $student->password = password_hash("anom",PASSWORD_BCRYPT);
    //     $this->studentRepository->saveStudent($student);

    //     $session = new Sessions();
    //     $session->id_session = uniqid();
    //     $session->email = $student->email;
    //     $this->sessionRepository->saveSession($session);

    //     $_COOKIE[SessionService::$COOKIE_NAME] = $session->id_session;

    //     $this->adminController->
    // }
}