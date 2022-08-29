<?php

namespace Anyar\Web\PSB\Service;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Form;
use Anyar\Web\PSB\Domain\Score;
use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\FormRegistrationRequest;
use Anyar\Web\PSB\Model\FormRegistrationResponse;
use Anyar\Web\PSB\Model\ScoreRegistrationRequest;
use Anyar\Web\PSB\Model\ScoreRegistrationResponse;
use Anyar\Web\PSB\Repository\FormScoreRepository;
use Anyar\Web\PSB\Repository\SessionRepository;
use Anyar\Web\PSB\Repository\StudentRepository;

class FormScoreService
{
    private StudentRepository $studentRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;
    private FormScoreRepository $formScoreRepository;

    public function __construct()
    {
        $this->formScoreRepository = new FormScoreRepository(Database::getConnection());
    }
    public function formScoreRegistration(FormRegistrationRequest $formRequest, ScoreRegistrationRequest $scoreRequest):array
    {
        $this->validateFormScoreRegistration($formRequest,$scoreRequest);;

        try {
            Database::startTransaction();

            $form = new Form();
            $form->id_registration = $formRequest->id_registration;
            $form->email = $formRequest->email;
            $form->date_registration = $formRequest->date_registration;
            $form->school_year = $formRequest->school_year;
            $form->major = $formRequest->major;
            $form->name = $formRequest->name;
            $form->place_ob = $formRequest->place_ob;
            $form->date_ob = $formRequest->date_ob;
            $form->gender = $formRequest->gender;
            $form->religion = $formRequest->religion;
            $form->phone = $formRequest->phone;
            $form->address = $formRequest->address;
            $this->formScoreRepository->saveForm($form);

            $score = new Score();
            $score->student_email = $scoreRequest->student_email;
            $score->b_indo = $scoreRequest->b_indo;
            $score->b_ing = $scoreRequest->b_ing;
            $score->mtk = $scoreRequest->mtk;
            $this->formScoreRepository->saveScore($score);

            Database::commitTransaction();

            $formResponse = new FormRegistrationResponse();
            $formResponse->form = $form;
            $scoreResponse = new ScoreRegistrationResponse();
            $scoreResponse->score = $score;

            return [$formResponse,$scoreResponse];

        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    private function validateFormScoreRegistration(FormRegistrationRequest $formRequest, ScoreRegistrationRequest $scorenRequest)
    {
        if ($formRequest->name == null || $formRequest->place_ob == null || $formRequest->date_ob == null || $formRequest->phone == null || $formRequest->address == null ||
            trim($formRequest->name) == "" || trim($formRequest->place_ob) == "" || trim($formRequest->date_ob) == "" || trim($formRequest->phone) == "" || trim($formRequest->address) == "" ||
            $scorenRequest->b_indo == null || $scorenRequest->b_ing == null || $scorenRequest->mtk == null ||
            trim($scorenRequest->b_indo) == "" || trim($scorenRequest->b_ing) == "" || trim($scorenRequest->mtk) == "") {
                throw new ValidationException("Form can not blank");
            }
    }
}