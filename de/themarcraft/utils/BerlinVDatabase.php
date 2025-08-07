<?php
namespace de\themarcraft\utils;
use PDO;

class BerlinVDatabase
{
    private string $DB_Host = "";
    private string $DB_Database = "";
    private string $DB_User = "";
    private string $DB_Passwd = "";

    private PDO $pdo;

    /**
     * Stelle eine PDO (MySQL) verbindung her
     */
    function __Construct()
    {
        $this->pdo = new PDO('mysql:host='. $this->DB_Host .';dbname='. $this->DB_Database, $this->DB_User, $this->DB_Passwd);
    }

    /**
     * Gebe die PDO (MySQL) verbindung zurück
     * @return PDO
     */
    public function getPdo() : PDO
    {
        return $this->pdo;
    }
}