<?php

namespace de\themarcraft\ggh;

use de\themarcraft\utils\Database;

class EH_Schein
{
    private int $id;
    private string $name;
    private string $datum;
    private string $url;

    public function __construct(int $id, string $name, string $datum, string $url){
        $this->id = $id;
        $this->name = $name;
        $this->datum = $datum;
        $this->url = $url;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDatum(): string
    {
        return $this->datum;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public static function getEH_ScheinById(int $id) : EH_Schein
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("SELECT * FROM `EH-Schein` WHERE id = ?");
        $statement->execute([$id]);
        $result = $statement->fetch();
        return new EH_Schein($result["id"], $result["name"], $result["datum"], $result["url"]);
    }

    public static function getEH_ScheinByUrl(string $url) : ?EH_Schein
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("SELECT * FROM `EH-Schein` WHERE url = ?");
        $statement->execute([$url]);
        $result = $statement->fetch();
        if (is_bool($result)) {
            return null;
        }
        return new EH_Schein($result["id"], $result["name"], $result["datum"], $result["url"]);
    }

    public static function addEH_Schein(EH_Schein $EH_Schein)
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("insert into `EH-Schein` (name, datum, url) values (?, ?, ?)");
        $statement->execute([$EH_Schein->getName(), $EH_Schein->getDatum(), $EH_Schein->getUrl()]);
        return true;
    }

    /**
     * @return EH_Schein[]
     */
    public static function getEH_Scheine(): array
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $res = [];
        $statement = $pdo->prepare("SELECT * FROM `EH-Schein`");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $res[] = new EH_Schein($row["id"], $row["name"], $row["datum"], $row["url"]);
        }
        return $res;
    }

    public static function delEH_Schein(int $id) : bool
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("DELETE FROM `EH-Schein` WHERE id = ?");
        $statement->execute([$id]);
        return true;
    }
}