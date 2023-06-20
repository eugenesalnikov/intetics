<?php

namespace ESalnikov\Intetics\Core;

use PDO;
use PDOStatement;

class Database
{
    private PDO $connection;

    private ConfigParser $configParser;

    public function __construct(ConfigParser $configParser)
    {
        $this->configParser = $configParser;

        $config = $this->configParser->parse();
        $host = $config['host'];
        $dbname = $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];
        $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query(string $query): PDOStatement
    {
        return $this->connection->query($query);
    }
}
