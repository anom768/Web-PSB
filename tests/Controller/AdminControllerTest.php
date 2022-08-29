<?php

namespace Anyar\Web\PSB\Controller;

require_once __DIR__ . "/../Helper/Helper.php";

putenv("mode=test");

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Form;
use Anyar\Web\PSB\Domain\Score;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Repository\FormScoreRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use PHPUnit\Framework\TestCase;

class AdminControllerTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private AdminController $adminController;
    private StudentRepository $studentRepository;
    private FormScoreRepository $formScoreRepository;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->formScoreRepository = new FormScoreRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->adminController = new AdminController();
        
        $this->sessionRepository->deleteAll();
        $this->formScoreRepository->deleteAll();
        $this->studentRepository->deleteAll();
        

        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

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
        $return = $this->formScoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $score->result = "Lulus";
        $score->note = "Sangat bagus"; 
        $score->admin_email = "admin";
        $this->formScoreRepository->saveScore($score);
    }

    public function testViewLoginSuccess()
    {
        $this->adminController->login();

        $this->expectOutputRegex("[Admin Login]");
    }

    public function testViewLoginBlank()
    {
        $_POST["email"] = "";
        $_POST["password"] = "";

        $this->adminController->postLogin();

        $this->expectOutputRegex("[Email and password can not blank]");
    }

    public function testViewLoginNull()
    {
        $_POST["email"] = null;
        $_POST["password"] = null;

        $this->adminController->postLogin();

        $this->expectOutputRegex("[Email and password can not blank]");
    }

    public function testViewLoginWrongEmail()
    {
        $_POST["email"] = "wrong";
        $_POST["password"] = "123";

        $this->adminController->postLogin();

        $this->expectOutputRegex("[Email or password is wrong]");
    }

    public function testViewLoginWrongPassword()
    {
        $_POST["email"] = "bangkitunom87@gmail.com";
        $_POST["password"] = "wrong";

        $this->adminController->postLogin();

        $this->expectOutputRegex("[Email or password is wrong]");
    }

    public function testViewPostLoginSuccess()
    {
        $_POST["email"] = "bangkitunom87@gmail.com";
        $_POST["password"] = "123";

        $this->adminController->postLogin();

        $this->expectOutputRegex("[Location:/]");
    }

    public function testLogout()
    {
        $this->adminController->logout();

        $this->expectOutputRegex("[Location:/]");
    }

    public function testViewStudentsDataNull()
    {
        $this->adminController->studentsData();

        $this->expectOutputRegex("[Student Data]");
    }

    public function testViewStudentDataExist()
    {
        $this->adminController->studentsData();

        $this->expectOutputRegex("[Bangkit]");
    }

    public function testViewPrint()
    {
        $this->adminController->print();

        $this->expectOutputRegex("[Bangkit]");
    }

    public function testViewUpdateData()
    {
        $_GET["email"] = "anom@gmail.com";

        $this->adminController->updateData();

        $this->expectOutputRegex("[Update Data]");
    }

    public function testViewPostStudentDataEmpty()
    {
        $_POST["searching"] = "notfound";
        $this->adminController->studentsData();

        $this->expectOutputRegex("[Student Data]");
    }

    public function testViewPostStudentDataSuccess()
    {
        

        $_POST["search"] = 1;
        $_POST["searching"] = "Bangkit";
        $this->adminController->studentsData();

        $this->expectOutputRegex("[Student Data]");
    }
}