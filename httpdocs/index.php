<?php
use com\selfcoders\ejabberdarchiveviewer\Archive;
use com\selfcoders\ejabberdarchiveviewer\Twig;

require_once __DIR__ . "/../bootstrap.php";

$peer = $_GET["peer"] ?? null;
$start = $_GET["start"] ?? null;
$end = $_GET["end"] ?? null;

if ($end === null) {
    $end = new DateTime;
} else {
    $end = new DateTime($end);
}

if ($start === null) {
    $start = clone $end;
    $start->sub(new DateInterval("P1D"));
} else {
    $start = new DateTime($start);
}

if ($end < $start) {
    $end = clone $start;
    $end->add(new DateInterval("P1D"));
}

echo Twig::render("page.twig", array(
    "currentPeer" => $peer,
    "start" => $start,
    "end" => $end,
    "peers" => Archive::getPeers(),
    "entries" => $peer ? Archive::getEntriesForPeer($peer, $start, $end) : array()
));