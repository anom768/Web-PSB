<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Form;
use Anyar\Web\PSB\Domain\Score;
use Anyar\Web\PSB\Domain\Students;
use PHPUnit\Framework\TestCase;

class FormScoreRepositoryTest extends TestCase
{
    private StudentRepository $studentRepository;
    private FormScoreRepository $formscoreRepository;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->formscoreRepository = new FormScoreRepository(Database::getConnection());

        $this->studentRepository->deleteAll();
        $this->formscoreRepository->deleteAll();
    }

    public function testGenerateIdRegistration()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $e = $this->studentRepository->generateEmailRegistration($student->email);
        $n = $this->studentRepository->generateNumberRegistration();

        $return = $this->formscoreRepository->generateIdRegistration($student->email);

        self::assertEquals($e.date("Y").sprintf("%05s",$n), $return);
    }
    public function testSaveForm()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $form = new Form();
        $form->id_registration = $this->formscoreRepository->generateIdRegistration($student->email);
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
        $return = $this->formscoreRepository->saveForm($form);

        self::assertEquals($form->id_registration, $return->id_registration);
        self::assertEquals($form->email, $return->email);
        self::assertEquals($form->date_registration, $return->date_registration);
        self::assertEquals($form->school_year, $return->school_year);
        self::assertEquals($form->major, $return->major);
        self::assertEquals($form->name, $return->name);
        self::assertEquals($form->place_ob, $return->place_ob);
        self::assertEquals($form->date_ob, $return->date_ob);
        self::assertEquals($form->gender, $return->gender);
        self::assertEquals($form->religion, $return->religion);
        self::assertEquals($form->phone, $return->phone);
        self::assertEquals($form->address, $return->address);
    }

    public function testSaveScore()
    {
        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $score->result = "Lulus";
        $score->note = "Sangat bagus"; 
        $score->admin_email = "admin";
        $return = $this->formscoreRepository->saveScore($score);

        self::assertEquals($score->student_email, $return->student_email);
        self::assertEquals($score->b_indo, $return->b_indo);
        self::assertEquals($score->b_ing, $return->b_ing);
        self::assertEquals($score->mtk, $return->mtk);
        self::assertEquals($score->result, $return->result);
        self::assertEquals($score->note, $return->note);
        self::assertEquals($score->admin_email, $return->admin_email);
    }

    public function testFndFormScoreByStudentEmailNotFound()
    {
        $return = $this->formscoreRepository->findFormScoreByStudentEmail("notfound");
        
        self::assertNull($return);
    }

    public function testFndFormScoreByStudentEmailSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $form = new Form();
        $form->id_registration = $this->formscoreRepository->generateIdRegistration($student->email);
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
        $return = $this->formscoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $score->result = "Lulus";
        $score->note = "Sangat bagus"; 
        $score->admin_email = "admin";
        $return = $this->formscoreRepository->saveScore($score);

        $return = $this->formscoreRepository->findFormScoreByStudentEmail("anom@gmail.com");
        
        self::assertNotNull($return);
        self::assertEquals($form->id_registration, $return["id_registration"]);
        self::assertEquals($form->email, $return["email"]);
        self::assertEquals($form->date_registration, $return["date_registration"]);
        self::assertEquals($form->school_year, $return["school_year"]);
        self::assertEquals($form->major, $return["major"]);
        self::assertEquals($form->name, $return["name"]);
        self::assertEquals($form->place_ob, $return["place_ob"]);
        self::assertEquals($form->date_ob, $return["date_ob"]);
        self::assertEquals($form->gender, $return["gender"]);
        self::assertEquals($form->religion, $return["religion"]);
        self::assertEquals($form->phone, $return["phone"]);
        self::assertEquals($form->address, $return["address"]);
    }

    public function testUpdateScore()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $form = new Form();
        $form->id_registration = $this->formscoreRepository->generateIdRegistration($student->email);
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
        $return = $this->formscoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $this->formscoreRepository->saveScore($score);

        $score->result = "Lulus";
        $score->note = "Sangat bagus"; 
        $score->admin_email = "admin";
        $return = $this->formscoreRepository->updateScore($score);
       
        self::assertNotNull($return);
        self::assertEquals($score->result, $return->result);
        self::assertEquals($score->note, $return->note);
        self::assertEquals($score->admin_email, $return->admin_email);
    }

    public function testFindFormScoreByKeywordNotFound()
    {
        $return = $this->formscoreRepository->findFormScoreByKeyWord("notfound");

        self::assertNull($return);
    }

    public function testFindFormScoreByKeywordSuccess()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $form = new Form();
        $form->id_registration = $this->formscoreRepository->generateIdRegistration($student->email);
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
        $return = $this->formscoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $this->formscoreRepository->saveScore($score);

        $score->result = "Lulus";
        $score->note = "Sangat bagus"; 
        $score->admin_email = "admin";
        $this->formscoreRepository->updateScore($score);

        $id_registration = $this->formscoreRepository->findFormScoreByKeyWord($form->id_registration);
        $name = $this->formscoreRepository->findFormScoreByKeyWord($form->name);
        $major = $this->formscoreRepository->findFormScoreByKeyWord($form->major);
        $b_indo = $this->formscoreRepository->findFormScoreByKeyWord($score->b_indo);
        $b_ing = $this->formscoreRepository->findFormScoreByKeyWord($score->b_ing);
        $mtk = $this->formscoreRepository->findFormScoreByKeyWord($score->mtk);
        $result = $this->formscoreRepository->findFormScoreByKeyWord($score->result);
        $note = $this->formscoreRepository->findFormScoreByKeyWord($score->note);

        self::assertNotNull($id_registration);
        self::assertNotNull($name);
        self::assertNotNull($major);
        self::assertNotNull($b_indo);
        self::assertNotNull($b_ing);
        self::assertNotNull($mtk);
        self::assertNotNull($result);
        self::assertNotNull($note);
    }

    public function testDeleteFormScoreByEmail()
    {
        $student = new Students();
        $student->email = "anom@gmail.com";
        $student->password = password_hash("anom",PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($student);

        $form = new Form();
        $form->id_registration = $this->formscoreRepository->generateIdRegistration($student->email);
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
        $return = $this->formscoreRepository->saveForm($form);

        $score = new Score();
        $score->student_email = "anom@gmail.com";
        $score->b_indo = 100;
        $score->b_ing = 90;
        $score->mtk = 80;
        $this->formscoreRepository->saveScore($score);

        $score->result = "Lulus";
        $score->note = "Sangat bagus"; 
        $score->admin_email = "admin";
        $this->formscoreRepository->updateScore($score);

        $this->formscoreRepository->deleteFormScoreByEmail($form->email);

        $return = $this->formscoreRepository->findFormScoreByStudentEmail($student->email);

        self::assertNull($return);
    }
}