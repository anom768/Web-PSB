<?php

namespace Anyar\Web\PSB\Config;

use Exception;
use PDO;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private PDO $connection;
    protected function setUp(): void
    {
        $this->connection = Database::getConnection();
        $this->connection->exec("DELETE FROM students");
        
    }
    public function testGetConnection()
    {
        
        self::assertNotNull($this->connection);
    }

    public function testTransactionSuccess()
    {
        Database::startTransaction();
        $statement = $this->connection->prepare("INSERT INTO students(email,password) VALUES(?,?)");
        $statement->execute(["anom","anom"]);
        Database::commitTransaction();

        $statement = $this->connection->prepare("SELECT id_student,email,password FROM students WHERE email = ?");
        $statement->execute(["anom"]);
        $email = null;
        if ($row = $statement->fetch()) {
            $email = $row["email"];
        }
        self::assertEquals("anom",$email);
    }

    public function testTransactionFailed()
    {
        Database::startTransaction();
        $statement = $this->connection->prepare("INSERT INTO students(email,password) VALUES(?,?)");
        $statement->execute(["anom","anom"]);
        Database::rollbackTransaction();

        $statement = $this->connection->prepare("SELECT id_student,email,password FROM students WHERE email = ?");
        $statement->execute(["anom"]);

        $email = null;
        if ($row = $statement->fetch()) {
            $email = $row["email"];
        }
        self::assertNull($email);
    }
}