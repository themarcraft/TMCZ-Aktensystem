<?php

namespace de\themarcraft\ggh;

use de\themarcraft\utils\Database;
use PDO;

class Verletzung
{
    private int $id;
    private string $bezeichnung;
    private int $anzahl;
    private float $preis;
    private string $ort;

    public function __construct(string $bezeichnung, int $anzahl, float $preis = 0.0, int $id = -1, string $ort = ''){
        $this->bezeichnung = $bezeichnung;
        $this->anzahl = $anzahl;
        $this->preis = $preis;
        $this->id = $id;
        $this->ort = $ort;
    }

    public function getBezeichnung(): string
    {
        return $this->bezeichnung;
    }

    public function getAnzahl(): int
    {
        return $this->anzahl;
    }

    public function getPreis(): float
    {
        return $this->preis;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrt(): string
    {
        return $this->ort ?? -1;
    }

    public static function fromArray(array $array): Verletzung{
        return new self($array['bezeichnung'], 0, $array['preis'], $array['id'], $array['ort'] ?? "");
    }

    public static function getVerletzungById(int $id): Verletzung
    {
        $db = new Database();
        $pdo = $db->getPdo();

        $statement = $pdo->prepare("SELECT * FROM Verletzung WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $verletzung = $statement->fetch();
        return self::fromArray($verletzung);
    }

    /**
     * @return Verletzung[]
     */
    public static function getAll(): array
    {
        $db = new Database();
        $pdo = $db->getPdo();

        $statement = $pdo->prepare("SELECT * FROM Verletzung");
        $statement->execute();
        $verletzungen = [];

        foreach ($statement->fetchAll() as $verletzung) {
            $verletzungen[] = self::fromArray($verletzung);
        }

        return $verletzungen;
    }

    public static function add(self $verletzung): bool
    {
        $db = new Database();
        $pdo = $db->getPdo();

        $statement = $pdo->prepare("insert into Verletzung(bezeichnung, preis) values(:bezeichnung, :preis)");
        $bezeichnung = $verletzung->getBezeichnung();
        $statement->bindParam(":bezeichnung", $bezeichnung);
        $preis = $verletzung->getPreis();
        $statement->bindParam(":preis", $preis);
        return $statement->execute();
    }

    public function setBezeichnung(string $bezeichnung): void
    {
        $db = new Database();
        $pdo = $db->getPdo();

        $statement = $pdo->prepare("update Verletzung set bezeichnung = :val where id = :id");
        $statement->bindParam(":val", $bezeichnung);
        $statement->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($statement->execute()){
            $this->bezeichnung = $bezeichnung;
        }
    }

    public function setPreis(float $preis): void
    {
        $db = new Database();
        $pdo = $db->getPdo();

        $statement = $pdo->prepare("update Verletzung set preis = :val where id = :id");
        $statement->bindParam(":val", $preis);
        $statement->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($statement->execute()){
            $this->preis = $preis;
        }
    }

    /**
     * @return Verletzung[]
     */
    public static function getAllToArray(): array
    {
        $db = new Database();
        $pdo = $db->getPdo();

        $statement = $pdo->prepare("SELECT * FROM Verletzung");
        $statement->execute();
        $verletzungen = [];

        foreach ($statement->fetchAll() as $verletzung) {
            $verletzungen[$verletzung['bezeichnung']] = $verletzung['preis'];
        }

        return $verletzungen;
    }
}