<?php

use Anyar\Web\PSB\App\Router;
use Anyar\Web\PSB\Config\Database;
use Anyar\Web\PSB\Controller\AdminController;
use Anyar\Web\PSB\Controller\HomeController;
use Anyar\Web\PSB\Controller\StudentController;
use Anyar\Web\PSB\Middleware\MustLoginMiddleware;
use Anyar\Web\PSB\Middleware\MustNotLoginMiddleware;

require_once __DIR__ . "/../vendor/autoload.php";

Database::getConnection("prod");

// home
Router::add("GET","/",HomeController::class,"index",[]);
// student
Router::add("GET","/students/register",StudentController::class,"register",[MustNotLoginMiddleware::class]);
Router::add("POST","/students/register",StudentController::class,"postRegister",[MustNotLoginMiddleware::class]);
Router::add("GET","/students/login",StudentController::class,"login",[MustNotLoginMiddleware::class]);
Router::add("POST","/students/login",StudentController::class,"postLogin",[MustNotLoginMiddleware::class]);
Router::add("GET","/students/logout",StudentController::class,"logout",[MustLoginMiddleware::class]);
Router::add("GET","/students/registration",StudentController::class,"formScoreRegistration",[MustLoginMiddleware::class]);
Router::add("POST","/students/registration",StudentController::class,"postFormScoreRegistration",[MustLoginMiddleware::class]);
Router::add("POST","/students/registration/card",StudentController::class,"postRegistrationCard",[MustLoginMiddleware::class]);
Router::add("POST","/students/announcement",StudentController::class,"announcement",[MustLoginMiddleware::class]);

// admin
Router::add("GET","/admin/login",AdminController::class,"login",[MustNotLoginMiddleware::class]);
Router::add("POST","/admin/login",AdminController::class,"postLogin",[MustNotLoginMiddleware::class]);
Router::add("GET","/students/data",AdminController::class,"studentsData",[MustLoginMiddleware::class]);
Router::add("POST","/students/data",AdminController::class,"studentsData",[MustLoginMiddleware::class]);
Router::add("GET","/admin/logout",AdminController::class,"logout",[MustLoginMiddleware::class]);
Router::add("GET","/print/students",AdminController::class,"print",[MustLoginMiddleware::class]);
Router::add("GET","/admin/update",AdminController::class,"updateData",[MustLoginMiddleware::class]);
Router::add("GET","/admin/delete",AdminController::class,"delete",[MustLoginMiddleware::class]);
Router::add("POST","/admin/save",AdminController::class,"postUpdateData",[MustLoginMiddleware::class]);

Router::run();