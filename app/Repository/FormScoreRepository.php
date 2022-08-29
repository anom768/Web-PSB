<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Domain\Form;
use Anyar\Web\PSB\Domain\Score;
use PDO;

class FormScoreRepository
{
    private PDO $connection;
    private StudentRepository $studentRepository;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->studentRepository = new StudentRepository($this->connection);
    }
    public function saveForm(Form $form):Form
    {
        $statement = $this->connection->prepare("INSERT INTO form(id_registration, email, date_registration,
            school_year, major, name, place_ob, date_ob, gender, religion, phone, address) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute([$form->id_registration, $form->email, $form->date_registration, $form->school_year,
            $form->major, $form->name, $form->place_ob, $form->date_ob, $form->gender, $form->religion, $form->phone, $form->address]);
        return $form;
    }

    public function saveScore(Score $score):Score
    {
        $statement = $this->connection->prepare("INSERT INTO score(student_email, b_indo, b_ing, mtk, result, note, admin_email)
            VALUES(?,?,?,?,?,?,?)");
        $statement->execute([$score->student_email, $score->b_indo, $score->b_ing, $score->mtk, $score->result,
            $score->note, $score->admin_email]);
        return $score;
    }

    public function findFormScoreByStudentEmail(string $email):mixed
    {
        $statement = $this->connection->prepare("SELECT f.id_registration, f.email, f.date_registration,
            f.school_year, f.major,f.name, f.place_ob, f.date_ob, f.gender, f.religion, f.phone, f.address, 
            s.student_email, s.b_indo, s.b_ing, s.mtk, s.result, s.note, s.admin_email FROM form AS f
            JOIN score AS s ON(f.email = s.student_email) WHERE f.email = ?");
        $statement->execute([$email]);
        
        try {
            if ($row = $statement->fetch()) {
                return $row;
            }
            return null;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findFormScoreByAll():mixed
    {
        $statement = $this->connection->prepare("SELECT f.id_registration, f.email, f.date_registration,
            f.school_year, f.major,f.name, f.place_ob, f.date_ob, f.gender, f.religion, f.phone, f.address, 
            s.student_email, s.b_indo, s.b_ing, s.mtk, s.result, s.note, s.admin_email FROM form AS f
            JOIN score AS s ON(f.email = s.student_email)");
        $statement->execute([]);
        
        try {
            if ($row = $statement->fetchAll()) {
                return $row;
            }
            return null;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findFormScoreByKeyWord($keyword)
    {
        $statement = $this->connection->prepare("SELECT f.email, f.id_registration, f.major, f.name, 
            s.b_indo, s.b_ing, s.mtk, s.result, s.note FROM form AS f
            JOIN score AS s ON(f.email = s.student_email)
            WHERE f.id_registration LIKE '%$keyword%' OR f.major LIKE '%$keyword%' OR f.name LIKE '%$keyword%' OR 
            s.b_indo  LIKE '%$keyword%' OR s.b_ing  LIKE '%$keyword%' OR 
            s.mtk LIKE '%$keyword%' OR s.result LIKE '%$keyword%' OR s.note LIKE '%$keyword%'");
        $statement->execute([]);
        
        try {
            if ($row = $statement->fetchAll()) {
                return $row;
            }
            return null;
        } finally {
            $statement->closeCursor();
        }
    }

    public function generateIdRegistration(string $email):string
    {
        $e = $this->studentRepository->generateEmailRegistration($email);
        $n = $this->studentRepository->generateNumberRegistration();
        $id_registration = $e . date("Y") . sprintf("%05s",$n);
        return $id_registration;
    }

    public function updateScore(Score $score): Score
    {
        $statement = $this->connection->prepare("UPDATE score SET result = ?, note = ?, admin_email = ? WHERE student_email = ?");
        $statement->execute([$score->result, $score->note, $score->admin_email, $score->student_email]);
        return $score;
    }

    public function deleteFormScoreByEmail(string $email)
    {
        $this->connection->exec("DELETE FROM form WHERE email = '$email'");
        $this->connection->exec("DELETE FROM score WHERE student_email = '$email'");
    }

    public function deleteAll()
    {
        $this->connection->exec("DELETE FROM form");
        $this->connection->exec("DELETE FROM score");
    }
}