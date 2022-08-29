<?php

namespace Anyar\Web\PSB\Service;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Domain\Students;
use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\StudentLoginRequest;
use Anyar\Web\PSB\Model\StudentLoginResponse;
use Anyar\Web\PSB\Model\StudentRegistrationRequest;
use Anyar\Web\PSB\Model\StudentRegistrationResponse;
use Anyar\Web\PSB\Repository\StudentRepository;

class StudentService
{
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function register(StudentRegistrationRequest $request): StudentRegistrationResponse
    {
        $this->validateStudentRegstrationRequest($request);

        try {
            Database::startTransaction();

            $student = new Students();
            $student->email = $request->email;
            $student->password = password_hash($request->password,PASSWORD_BCRYPT);

            $this->studentRepository->saveStudent($student);

            Database::commitTransaction();

            $response = new StudentRegistrationResponse();
            $response->student = $student;
            return $response;
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    private function validateStudentRegstrationRequest(StudentRegistrationRequest $request)
    {
        if ($request->email == null || $request->password == null ||
            trim($request->email) == "" || trim($request->password) == "") {
                throw new ValidationException("Email and password can not blank");
        }
        
        $return = $this->studentRepository->findByEmail($request->email);
        if ($return != null) {
            throw new ValidationException("Email already exist");
        }
    }

    public function login(StudentLoginRequest $request): StudentLoginResponse
    {
        $this->validateStudentLoginRequest($request);

        $return = $this->studentRepository->findByEmail($request->email);
        if ($return == null) {throw new ValidationException("Email or password is wrong");}

        if (password_verify($request->password,$return->password)) {
            $response = new StudentLoginResponse();
            $response->student = $return;
            return $response;
        } else {
            throw new ValidationException("Email or password is wrong");
        }
    }

    private function validateStudentLoginRequest(StudentLoginRequest $request)
    {
        if ($request->email == null || $request->password == null ||
            trim($request->email) == "" || trim($request->password) == "") {
                throw new ValidationException("Email and password can not blank");
        }
    }
}