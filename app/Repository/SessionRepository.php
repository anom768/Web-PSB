<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Domain\Sessions;
use PDO;

class SessionRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
    public function saveSession(Sessions $session): Sessions
    {
        $statement = $this->connection->prepare("INSERT INTO sessions(id_session,email) VALUES(?,?)");
        $statement->execute([$session->id_session,$session->email]);
        return $session;
    }

    public function findById(string $id): ?Sessions
    {
        $statement = $this->connection->prepare("SELECT id_session,email FROM sessions WHERE id_session = ?");
        $statement->execute([$id]);
        
        try {
            if ($row = $statement->fetch()) {
                $session = new Sessions();
                $session->id_session = $row["id_session"];
                $session->email = $row["email"];
                return $session;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(string $id)
    {
        $statement = $this->connection->prepare("DELETE FROM sessions WHERE id_session = ?");
        $statement->execute([$id]);
    }

    public function deleteAll()
    {
        $this->connection->exec("DELETE FROM sessions");
    }
}