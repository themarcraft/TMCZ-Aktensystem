<?php

namespace de\themarcraft\ggh;

use de\themarcraft\utils\Database;

class Mitarbeiter
{
    private int $dienstnummer;
    private string $vorname;
    private string $nachname;
    private string $rang;
    private int $rangid;
    private string $passwd;
    private string $anmerkung;
    private string $pb;

    public function __construct(int $dienstnummer, string $vorname, string $nachname, string $rang, int $rangid, string $passwd, $anmerkung = "", $pb = ""){
        $this->dienstnummer = $dienstnummer;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->rang = $rang;
        $this->rangid = $rangid;
        $this->passwd = $passwd;
        $this->anmerkung = $anmerkung;
        $this->pb = $pb;
    }

    public function getDienstnummer(): int
    {
        return $this->dienstnummer;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function getRang(): string
    {
        return $this->rang;
    }

    public function setRang(string $rang): void
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("update Mitarbeiter set Rang = :rang where dienstnummer = :id");
        $statement->bindValue(':rang', $rang);
        $statement->bindValue(':id', $this->dienstnummer);
        if ($statement->execute()){
            $this->rang = $rang;
        }else{
            die("Fehler in der Datenbank");
        }
    }

    /**
     * @return Mitarbeiter[]
     */
    public static function getMitarbeiter() : array
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("select * from Mitarbeiter inner join Rang on Mitarbeiter.rang = Rang.Rang order by Mitarbeiter.rang asc;");
        $statement->execute();
        $result = $statement->fetchAll();
        $returnval = array();
        foreach ($result as $row){
            $returnval[] = Mitarbeiter::getMitarbeiterByArray($row);
        }
        return $returnval;
    }

    public static function getMitarbeiterById(int $id): ?Mitarbeiter
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("select * from Mitarbeiter inner join Rang on Rang.rang = Mitarbeiter.rang where dienstnummer = ?");
        $statement->bindValue(1,$id);
        $statement->execute();
        $result = $statement->fetch();
        if (!is_bool($result)){
            return Mitarbeiter::getMitarbeiterByArray($result);
        }else{
            return null;
        }
    }

    public static function getMitarbeiterByArray(array $array): Mitarbeiter
    {
        return new Mitarbeiter($array["dienstnummer"], $array["vorname"], $array["nachname"], $array["Bezeichnung"] ?? "", $array["rang"], $array['passwort'], $array['anmerkung'], $array['profilbild']);
    }

    public function setVorname(string $vorname): void
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("update Mitarbeiter set vorname = :vorname where dienstnummer = :id");
        $statement->bindValue(':vorname', $vorname);
        $statement->bindValue(':id', $this->dienstnummer);
        if ($statement->execute()){
            $this->vorname = $vorname;
        }else{
            die("Fehler in der Datenbank");
        }
    }

    public function setNachname(string $nachname): void
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("update Mitarbeiter set nachname = :nachname where dienstnummer = :id");
        $statement->bindValue(':nachname', $nachname);
        $statement->bindValue(':id', $this->dienstnummer);
        if ($statement->execute()){
            $this->nachname = $nachname;
        }else{
            die("Fehler in der Datenbank");
        }
    }

    public static function addMitarbeiter(int $dienstnummer, string $vorname, string $nachname, string $rang): bool
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("insert into Mitarbeiter(dienstnummer, vorname, nachname, rang) VALUES (:dienstnummer, :vorname, :nachname, :rang)");
        $statement->bindValue(':dienstnummer', $dienstnummer);
        $statement->bindValue(':vorname', $vorname);
        $statement->bindValue(':nachname', $nachname);
        $statement->bindValue(':rang', $rang);
        if ($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function setDienstnummer(int $dienstnummer): void
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("update Mitarbeiter set dienstnummer = :dienstnummer where dienstnummer = :id");
        $statement->bindValue(':dienstnummer', $dienstnummer);
        $statement->bindValue(':id', $this->dienstnummer);
        if ($statement->execute()){
            $this->dienstnummer = $dienstnummer;
        }else{
            die("Fehler in der Datenbank");
        }
    }

    public function setAnmerkung(string $anmerkung): void
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("update Mitarbeiter set anmerkung = :anmerkung where dienstnummer = :id");
        $statement->bindValue(':anmerkung', $anmerkung);
        $statement->bindValue(':id', $this->dienstnummer);
        if ($statement->execute()){
            $this->anmerkung = $anmerkung;
        }else{
            die("Fehler in der Datenbank");
        }
    }

    public function setProfilbild(string $pb): void
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("update Mitarbeiter set profilbild = :pb where dienstnummer = :id");
        $statement->bindValue(':pb', $pb);
        $statement->bindValue(':id', $this->dienstnummer);
        if ($statement->execute()){
            $this->pb = $pb;
        }else{
            die("Fehler in der Datenbank");
        }
    }

    public function getBehandelteVerletzungen(): int
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("select aerzte from Akteneintrag where patientenId != 2");
        $statement->execute();
        $result = $statement->fetchAll();
        $i = 0;
        foreach ($result as $row){
            $aerzte = @unserialize($row['aerzte']);
            foreach ($aerzte as $a){
                if ($a->getDienstnummer() == $this->dienstnummer){
                    $i++;
                }
            }
        }
        return $i;
    }

    public function getBehandeltePatienten(): int
    {
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("select aerzte, patientenId from Akteneintrag where patientenId != 2");
        $statement->execute();
        $result = $statement->fetchAll();
        $pat = [];
        foreach ($result as $row){
            $aerzte = @unserialize($row['aerzte']);
            foreach ($aerzte as $a){
                if ($a->getDienstnummer() == $this->dienstnummer){
                    if (!in_array($row['patientenId'], $pat)){
                        $pat[] = $row['patientenId'];
                    }
                }
            }
        }
        return count($pat);
    }

    public function getRangId(): int
    {
        return $this->rangid;
    }

    public function getPasswd(): string
    {
        return $this->passwd;
    }

    public function getAnmerkung(): string
    {
        return $this->anmerkung;
    }

    public function getPb(): string
    {
        return $this->pb;
    }

    public function setPasswd(string $passwd): void
    {
        $passwd = password_hash($passwd, PASSWORD_DEFAULT);
        $db = new Database();
        $pdo = $db->getPDO();
        $statement = $pdo->prepare("update Mitarbeiter set passwort = :passwd where dienstnummer = :id");
        $statement->bindValue(':passwd', $passwd);
        $statement->bindValue(':id', $this->dienstnummer);
        if ($statement->execute()){
            $this->passwd = $passwd;
        }else{
            die("Fehler in der Datenbank");
        }
    }

}