<?php

namespace de\themarcraft\ggh;

use de\themarcraft\utils\Database;
use mysql_xdevapi\DocResult;

class Eintrag
{
    private int $id;
    private int $patientenId;
    private string $datum;
    private string $uhrzeit;
    /**
     * @var Verletzung[] $verletzungen
     */
    private array $verletzungen;
    /**
     * @var Mitarbeiter[] $aerzte
     */
    private array $aerzte;
    private string $anmerkungen;
    private float $preis;

    public function __construct(int $id, int $patientenId, string $datum, string $uhrzeit, array $verletzungen, array $aerzte, string $anmerkungen = "", float $preis = 0){
        $this->id = $id;
        $this->patientenId = $patientenId;
        $this->datum = $datum;
        $this->uhrzeit = $uhrzeit;
        $this->verletzungen = $verletzungen;
        $this->aerzte = $aerzte;
        $this->anmerkungen = $anmerkungen;
        $this->preis = $preis;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDatum(): string
    {
        return $this->datum;
    }

    public function getUhrzeit(): string
    {
        return $this->uhrzeit;
    }

    /**
     * @return array|Verletzung[]
     */
    public function getVerletzungen(): array
    {
        return $this->verletzungen;
    }

    public function getVerletzungenString(): string
    {
        $ortval = [
            "Cranium", "Thorax",
            "Brachium R", "Antebrachium R", "Brachium L", "Antebrachium L",
            "Zeugopodium R", "Stylopodium R", "Zeugopodium L", "Stylopodium L",
        ];
        $result = "";
        foreach ($this->getVerletzungen() as $verletzung){
            if ($verletzung->getOrt() != -1) {
                $result.= $verletzung->getAnzahl()."x ".$verletzung->getBezeichnung()." | <span style='color: #0dcaf0'>".$ortval[intval($verletzung->getOrt())]."</span><br>\n";
            }else{
                $result.= $verletzung->getAnzahl()."x ".$verletzung->getBezeichnung()."<br>\n";
            }
        }
        return $result;
    }

    public function getAerzte(): array
    {
        return $this->aerzte;
    }

    public function getAerzteString(): string
    {
        $result = "";
        foreach ($this->getAerzte() as $arzt){
            $result.= substr($arzt->getVorname(), 0, 1).".".substr($arzt->getNachname(), 0, 1).". ";
        }
        return $result;
    }

    public function getAnmerkungen(): string
    {
        return $this->anmerkungen;
    }

    public function getPreis(): float
    {
        return $this->preis;
    }

    public function getPatientenId(): int
    {
        return $this->patientenId;
    }

    public static function addEintrag(int $patientenId, string $datum, string $uhrzeit, array $verletzungen, array $aerzte, string $anmerkungen = "", float $preis = 0): void
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("insert into Akteneintrag(datum, zeit, verletzungen, anmerkungen, aerzte, patientenId, preis) values (:datum, :zeit, :verletzungen, :anmerkungen ,:aerzte, :patientenId, :preis)");
        $statement->bindValue(':datum', $datum);
        $statement->bindValue(':zeit', $uhrzeit);
        $statement->bindValue(':verletzungen', serialize($verletzungen));
        $statement->bindValue(':aerzte', $aerzte);
        $statement->bindValue(':anmerkungen', $anmerkungen);
        $statement->bindValue(':patientenId', $patientenId);
        $statement->bindValue(':preis', $preis);
        $statement->execute();
    }

    public static function getEintragFromArray(array $array): Eintrag
    {
        return new Eintrag(id: $array["id"], patientenId: $array["patientenId"], datum: $array["datum"], uhrzeit: $array["zeit"], verletzungen: unserialize($array["verletzungen"]), aerzte: unserialize($array["aerzte"]), anmerkungen: $array["anmerkungen"], preis: $array["preis"]);
    }

    /**
     * @param int $patientId
     * @return Eintrag[]
     */
    public static function getEintraegeFromPatientId(int $patientId): array
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("select * from Akteneintrag where patientenId = :patientId");
        $statement->bindValue(':patientId', $patientId);
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $eintrag) {
            $result[] = self::getEintragFromArray($eintrag);
        }
        return $result;
    }

    public static function deleteEintragById(int $id)
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("delete from Akteneintrag where id = :id");
        $statement->bindValue(':id', $id);
        if ($statement->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public static function getEintragById(int $id): Eintrag
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("select * from Akteneintrag where id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return self::getEintragFromArray($result);
    }

    public function setDatum(string $datum): void
    {
        $db = new Database();
        $pdo = $db->getPdo();
        $statement = $pdo->prepare("update Akteneintrag set datum = :val where id = :id");
        $statement->bindValue(':val', $datum);
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $this->datum = $datum;
    }

    public function setUhrzeit(string $uhrzeit): void
    {
        $db = new Database();
        $pdo = $db->getPdo();
        $statement = $pdo->prepare("update Akteneintrag set zeit = :val where id = :id");
        $statement->bindValue(':val', $uhrzeit);
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $this->uhrzeit = $uhrzeit;
    }

    public function setVerletzungen(array $verletzungen): void
    {
        $db = new Database();
        $pdo = $db->getPdo();
        $statement = $pdo->prepare("update Akteneintrag set verletzungen = :val where id = :id");
        $statement->bindValue(':val', serialize($verletzungen));
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $this->verletzungen = $verletzungen;
    }

    public function setAerzte(array $aerzte): void
    {
        $db = new Database();
        $pdo = $db->getPdo();
        $statement = $pdo->prepare("update Akteneintrag set aerzte = :val where id = :id");
        $statement->bindValue(':val', serialize($aerzte));
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $this->aerzte = $aerzte;
    }

    public function setAnmerkungen(string $anmerkungen): void
    {
        $db = new Database();
        $pdo = $db->getPdo();
        $statement = $pdo->prepare("update Akteneintrag set anmerkungen = :val where id = :id");
        $statement->bindValue(':val', $anmerkungen);
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $this->anmerkungen = $anmerkungen;
    }

    public function setPreis(float $preis): void
    {
        $db = new Database();
        $pdo = $db->getPdo();
        $statement = $pdo->prepare("update Akteneintrag set preis = :val where id = :id");
        $statement->bindValue(':val', $preis);
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $this->preis = $preis;
    }
}