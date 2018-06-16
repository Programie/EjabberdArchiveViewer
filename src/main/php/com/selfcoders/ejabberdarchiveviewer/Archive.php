<?php
namespace com\selfcoders\ejabberdarchiveviewer;

use DateTime;
use PDO;

class Archive
{
    /**
     * @return string[]
     */
    public static function getPeers()
    {
        $peers = array();

        $query = Database::getPdo()->query("SELECT `bare_peer` FROM `archive` GROUP BY `bare_peer` ORDER BY `bare_peer`");

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $peers[] = $row["bare_peer"];
        }

        return $peers;
    }

    /**
     * @param string $peer
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @return Entry[]
     */
    public static function getEntriesForPeer(string $peer, DateTime $startTime, DateTime $endTime)
    {
        $query = Database::getPdo()->prepare("
            SELECT *
            FROM `archive`
            WHERE `bare_peer` = :peer AND `timestamp` BETWEEN :startTime AND :endTime
            ORDER BY `timestamp` ASC
        ");

        $query->bindValue(":peer", $peer);
        $query->bindValue(":startTime", $startTime->getTimestamp() * 1000000, PDO::PARAM_INT);
        $query->bindValue(":endTime", $endTime->getTimestamp() * 1000000 + 999999, PDO::PARAM_INT);

        $query->execute();

        $entries = array();

        while ($entry = $query->fetchObject(Entry::class)) {
            $entries[] = $entry;
        }

        return $entries;
    }

    /**
     * @param string $peer
     * @param string $search
     * @return Entry[]
     */
    public static function findEntriesForPeer(string $peer, string $search)
    {
        $query = Database::getPdo()->prepare("
            SELECT *
            FROM `archive`
            WHERE `bare_peer` = :peer AND INSTR(`txt`, :txt) > 0
            ORDER BY `timestamp` ASC
        ");

        $query->bindValue(":peer", $peer);
        $query->bindValue(":txt", $search);

        $query->execute();

        $entries = array();

        while ($entry = $query->fetchObject(Entry::class)) {
            $entries[] = $entry;
        }

        return $entries;
    }
}