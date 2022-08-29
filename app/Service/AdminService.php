<?php

namespace Anyar\Web\PSB\Service;

use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Exception\ValidationException;
use Anyar\Web\PSB\Model\AdminLoginRequest;
use Anyar\Web\PSB\Model\AdminLoginResponse;
use Anyar\Web\PSB\Model\ScoreRegistrationRequest;
use Anyar\Web\PSB\Model\ScoreUpdateRequest;
use Anyar\Web\PSB\Model\ScoreUpdateResponse;
use Anyar\Web\PSB\Repository\AdminRepository;

class AdminService
{
    private AdminRepository $adminRepository;

    public function __construct()
    {
        $this->adminRepository = new AdminRepository(Database::getConnection());
    }

    public function login(AdminLoginRequest $request): AdminLoginResponse
    {
        $this->validateAdminLoginRequest($request);

        $admin = $this->adminRepository->findByEmail($request->email);
        if ($admin == null) {
            throw new ValidationException("Email or password is wrong");
        }

        if ($request->password != $admin->password) {
            throw new ValidationException("Email or password is wrong");
        } else {
            $response = new AdminLoginResponse();
            $response->admin = $admin;
            return $response;
        }
    }

    public function validateAdminLoginRequest(AdminLoginRequest $request)
    {
        if ($request->email == null || $request->password == null ||
            trim($request->email) == "" || trim($request->password) == "") {
                throw new ValidationException("Email and password can not blank");
            }
    }
}