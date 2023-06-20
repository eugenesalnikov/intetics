<?php

namespace ESalnikov\Intetics\Repository;

use ESalnikov\Intetics\Core\Database;
use ESalnikov\Intetics\Entity\Message;
use PDO;

class MessageRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param int $id
     * @return Message|null
     */
    public function findOneById(int $id): ?Message
    {
        $query     = 'SELECT * FROM message WHERE id=:id';
        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return !is_null($row) ? $this->create($row) : null;
    }

    public function create(array $data): Message
    {
        return new Message($data);
    }

    /**
     * @return Message[]
     */
    public function findAll(): array
    {
        $result = $this->database->query('SELECT * FROM post');

        $messages = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $messages[] = $this->create($row);
        }

        return $messages;
    }

    public function insert(array $params): int
    {
        $query     = 'INSERT INTO message (text) VALUES (:text)';
        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindValue(':text', $params['text']);
        $statement->execute();

        return $this->database->getConnection()->lastInsertId();
    }
}
