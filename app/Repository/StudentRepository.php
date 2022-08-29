<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Domain\Students;
use PDO;

class StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function saveStudent(Students $student): Students
    {
        $statement = $this->connection->prepare("INSERT INTO students(email,password) VALUES(?,?)");
        $statement->execute([$student->email,$student->password]);
        return $student;
    }

    public function findByEmail(string $email): ?Students
    {
        $statement = $this->connection->prepare("SELECT id_student,email,password FROM students WHERE email = ?");
        $statement->execute([$email]);
        
        try {
            if ($row = $statement->fetch()) {
                $student = new Students();
                $student->id_student = $row["id_student"];
                $student->email = $row["email"];
                $student->password = $row["password"];
                return $student;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function generateNumberRegistration(): ?int
    {
        $statement = $this->connection->prepare("SELECT MAX(id_student) AS max FROM students");
        $statement->execute();

        try {
            $number = $statement->fetch();
            return $number["max"];
        } finally {
            $statement->closeCursor();
        }
    }

    public function generateEmailRegistration(string $email):?string
    {
        $statement = $this->connection->prepare("SELECT UPPER(LEFT(email,3)) as mail FROM students WHERE email = ?");
        $statement->execute([$email]);

        try {
            $e = $statement->fetch();
            return $e["mail"];
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll()
    {
        $this->connection->exec("DELETE FROM students");
    }
}