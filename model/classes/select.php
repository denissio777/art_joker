<?php
namespace Database;
use Settings;
use \PDO;
use \PDOException;

class Select
{
    protected $host = Settings\host;
    protected $dbname = Settings\dbname;
    protected $username = Settings\username;
    protected $password = Settings\password;
    protected $charset = Settings\charset;

    public function connect()
    {
        try {

            $pdo = new PDO("mysql:host=".$this->host.";charset=".$this->charset.";dbname=".$this->dbname, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function select($sql)
    {
        $statement = $this->connect()->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $response = json_encode($result, JSON_UNESCAPED_UNICODE);
        echo $response;
    }

    public function createTable($table)
    {
        $statement = $this->connect()->prepare($table);
        $statement->execute();
    }

    public function check($data, $name, $email, $territory)
    {
        $statement = $this->connect()->prepare($data);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $k => $v) {
            $mail = $v['email'];
        }
        if ($email == $mail) {
            $response = json_encode($result, JSON_UNESCAPED_UNICODE);
            echo $response;
        } else {
            $this->insert($name, $email, $territory);
        }
    }

    public function insert($name, $email, $territory)
    {
            $statement = $this->connect()->prepare("INSERT INTO users (name, email, territory) VALUES (:name, :email, :territory)");
            $statement->bindParam(':name', $name);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':territory', $territory);
            $statement->execute();
    }
}