<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Domain\Admin;
use PDO;

class AdminRepository
{
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findByEmail(string $email):?Admin
    {
        $statement = $this->connection->prepare("SELECT email, password FROM admin WHERE email = ?");
        $statement->execute([$email]);
        
        try {
            if ($row = $statement->fetch()) {
                $admin = new Admin();
                $admin->email = $row["email"];
                $admin->password = $row["password"];
    
                return $admin;
            }
            return null;
        } finally {
            $statement->closeCursor();
        }
    }
}