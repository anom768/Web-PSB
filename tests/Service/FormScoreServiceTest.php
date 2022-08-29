<?php

namespace Anyar\Web\PSB\Service;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Form;
use Anyar\Web\PSB\Domain\Sessions;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\FormRegistrationRequest;
use Anyar\Web\PSB\Model\ScoreRegistrationRequest;
use Anyar\Web\PSB\Repository\FormScoreRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;
use PHPUnit\Framework\TestCase;

class FormScoreServiceTest extends TestCase
{
    private Students $student;
    private Sessions $session;
    private StudentRepository $studentRepository;
    private SessionRepository $sesssionRepository;
    private FormScoreRepository $formScoreRepository;
    private FormScoreService $formScoreService;

    protected function setUp(): void
    {
        $this->studentRepository = new StudentRepository(Database::getConnection());
        $this->sesssionRepository = new SessionRepository(Database::getConnection());
        $this->formScoreRepository = new FormScoreRepository(Database::getConnection());
        $this->formScoreService = new FormScoreService();

        $this->studentRepository->deleteAll();
        $this->sesssionRepository->deleteAll();
        $this->formScoreRepository->deleteAll();

        $this->student = new Students();
        $this->student->email = "anom@gmail.com";
        $this->student->password = password_hash("anom", PASSWORD_BCRYPT);
        $this->studentRepository->saveStudent($this->student);

        $this->session = new Sessions();
        $this->session->id_session = uniqid();
        $this->session->email = $this->student->email;
        $this->sesssionRepository->saveSession($this->session);
    }
    public function testFormScoreRegistrationNull()
    {
        $this->expectException(ValidationException::class);

        $formRequest = new FormRegistrationRequest();
        $formRequest->id_registration = null;
        $formRequest->email = null;
        $formRequest->date_registration = null;
        $formRequest->school_year = null;
        $formRequest->major = null;
        $formRequest->name = null;
        $formRequest->place_ob = null;
        $formRequest->date_ob = null;
        $formRequest->gender = null;
        $formRequest->religion = null;
        $formRequest->phone = null;
        $formRequest->address = null;

        $scoreRequest = new ScoreRegistrationRequest();
        $scoreRequest->student_email = null;
        $scoreRequest->b_indo = null;
        $scoreRequest->b_ing = null;
        $scoreRequest->mtk = null;

        $this->formScoreService->formScoreRegistration($formRequest,$scoreRequest);
    }

    public function testFormScoreRegistrationBlank()
    {
        $this->expectException(ValidationException::class);

        $formRequest = new FormRegistrationRequest();
        $formRequest->id_registration = "";
        $formRequest->email = "";
        $formRequest->date_registration = "";
        $formRequest->school_year = "";
        $formRequest->major = "";
        $formRequest->name = "";
        $formRequest->place_ob = "";
        $formRequest->date_ob = "";
        $formRequest->gender = "";
        $formRequest->religion = "";
        $formRequest->phone = "";
        $formRequest->address = "";

        $scoreRequest = new ScoreRegistrationRequest();
        $scoreRequest->student_email = "";
        $scoreRequest->b_indo = null;
        $scoreRequest->b_ing = null;
        $scoreRequest->mtk = null;

        $this->formScoreService->formScoreRegistration($formRequest,$scoreRequest);
    }

    public function testFormScoreRegistrationSuccess()
    {
        $formRequest = new FormRegistrationRequest();
        $formRequest->id_registration = $this->formScoreRepository->generateIdRegistration($this->session->email);
        $formRequest->email = $this->session->email;
        $formRequest->date_registration = date("Y-m-d H:i:s");
        $formRequest->school_year = "2022/2023";
        $formRequest->major = "Multimedia";
        $formRequest->name = "Bangkit Anom Sedhayu";
        $formRequest->place_ob = "Cilacap";
        $formRequest->date_ob = date("Y-m-d");
        $formRequest->gender = "Laki-Laki";
        $formRequest->religion = "Islam";
        $formRequest->phone = "089";
        $formRequest->address = "Jln Tangkuban";

        $scoreRequest = new ScoreRegistrationRequest();
        $scoreRequest->student_email = $this->session->email;
        $scoreRequest->b_indo = 100;
        $scoreRequest->b_ing = 90;
        $scoreRequest->mtk = 80;

        $return = $this->formScoreService->formScoreRegistration($formRequest,$scoreRequest);

        $arrayFormRequest = [];
        foreach ($formRequest as $key) {
            $arrayFormRequest[] = $key;
        }

        $arrayFormResponse = [];
        foreach($return[0] as $values) {
            foreach ($values as $value) {
                $arrayFormResponse[] = $value;
            }
        }

        for($i=0; $i<=sizeof($arrayFormRequest)-1; $i++) {
            self::assertEquals($arrayFormRequest[$i], $arrayFormResponse[$i]);
        }
    }
}