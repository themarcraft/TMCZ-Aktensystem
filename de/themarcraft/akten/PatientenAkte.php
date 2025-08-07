<?php

namespace de\themarcraft\ggh;

use de\themarcraft\utils\Database;

class PatientenAkte
{
    private int $id;
    private string $vorname;
    private string $nachname;
    private string $telefonnummer;
    private string $job;
    /**
     * @var Eintrag[] $akteneintraege
     */
    private array $akteneintraege;
    private string $geburtstag;
    private string $anmerkung;

    public function __construct($id, $vorname, $nachname, $telefonnummer, $job, $geburtstag, $anmerkung = ""){
        $this->id = $id;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->telefonnummer = $telefonnummer;
        $this->job = $job;
        $this->geburtstag = $geburtstag;
        $this->anmerkung = $anmerkung;
        $this->akteneintraege = Eintrag::getEintraegeFromPatientId($id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function getTelefonnummer(): string
    {
        return $this->telefonnummer;
    }

    public function getJob(): string
    {
        return $this->job;
    }

    public function setJob(string $job): void
    {
        $this->job = $job;
    }

    public function setTelefonnummer(string $telefonnummer): void
    {
        $this->telefonnummer = $telefonnummer;
    }

    public static function getPatientByArray(array $array): PatientenAkte
    {
        $anmerkung = "";
        if (!is_null($array["anmerkung"])){
            $anmerkung = $array["anmerkung"];
        }
        return new PatientenAkte($array["id"], $array["vorname"], $array["nachname"], $array["telefonnummer"], $array["job"], $array["geburtstag"], $anmerkung);
    }

    public static function getPatientById(int $id): ?PatientenAkte
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("SELECT * FROM Patientenakte WHERE id = ?");
        $statement->execute([$id]);
        $result = $statement->fetch();
        if (!is_bool($result)) {
            return self::getPatientByArray($result);
        }else{
            return null;
        }
    }

    /**
     * @return PatientenAkte[]
     */
    public static function getAllPatients(): array{
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("SELECT * FROM Patientenakte order by vorname asc");
        $statement->execute();
        $result = [];
        foreach ($statement->fetchAll() as $patient){
            $result[] = self::getPatientByArray($patient);
        }
        return $result;
    }

    public static function addPatient(string $vorname, $nachname, $telefonnummer, $geburtstag, $job = "Arbeitslos", $anmerkung = ""): bool
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("insert into Patientenakte (vorname, nachname, telefonnummer, job, geburtstag, anmerkung) VALUES(:vorname, :nachname, :telefonnummer, :job, :geburtstag, :anmerkung)");
        $statement->bindValue(":vorname", $vorname);
        $statement->bindValue(":nachname", $nachname);
        $statement->bindValue(":telefonnummer", $telefonnummer);
        $statement->bindValue(":job", $job);
        $statement->bindValue(":geburtstag", $geburtstag);
        $statement->bindValue(":anmerkung", $anmerkung);
        if ($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getAkteneintraege(): array
    {
        return $this->akteneintraege;
    }

    public function getGeburtstag(): string
    {
        return $this->geburtstag;
    }

    public function getAnmerkung(): string
    {
        return $this->anmerkung;
    }

    public function addEintrag(string $datum, string $zeit, array $verletzungen, array $aerzte, float $preis, string $anmerkung = ""): bool
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("insert into Akteneintrag(patientenId, datum, zeit, verletzungen, anmerkungen, aerzte, preis) VALUES(:patientenId, :datum, :zeit, :verletzungen, :anmerkung, :aerzte, :preis)");
        $statement->bindValue(":patientenId", $this->id);
        $statement->bindValue(":datum", $datum);
        $statement->bindValue(":zeit", $zeit);
        $statement->bindValue(":verletzungen", serialize($verletzungen));
        $statement->bindValue(":anmerkung", $anmerkung);
        $statement->bindValue(":aerzte", serialize($aerzte));
        $statement->bindValue(":preis", $preis);
        if ($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updatePatient(string $vorname, $nachname, $telefonnummer, $geburtstag, $job = "Arbeitslos", $anmerkung = ""): bool
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("UPDATE Patientenakte SET geburtstag = :geb, vorname = :vorname, nachname = :nachname, telefonnummer = :tel, job = :job, anmerkung = :anmerkung WHERE id = :id");
        $statement->bindValue(":vorname", $vorname);
        $statement->bindValue(":nachname", $nachname);
        $statement->bindValue(":tel", $telefonnummer);
        $statement->bindValue(":job", $job);
        $statement->bindValue(":geb", $geburtstag);
        $statement->bindValue(":anmerkung", $anmerkung);
        $statement->bindValue(":id", $this->id);
        if ($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
}