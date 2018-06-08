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

$previousDayEnd = clone $start;
$previousDayEnd->sub(new DateInterval("P1D"));
$previousDayEnd->setTime(23, 59, 59);
$previousDayStart = clone $previousDayEnd;
$previousDayStart->setTime(0, 0, 0);

$nextDayStart = clone $end;
$nextDayStart->add(new DateInterval("P1D"));
$nextDayStart->setTime(0, 0, 0);
$nextDayEnd = clone $nextDayStart;
$nextDayEnd->setTime(23, 59, 59);

$todayStart = new DateTime;
$todayStart->setTime(0, 0, 0);

$todayEnd = clone $todayStart;
$todayEnd->setTime(23, 59, 59);

$previousDayUrl = sprintf("?peer=%s&start=%s&end=%s", urlencode($peer), urlencode($previousDayStart->format("c")), urlencode($previousDayEnd->format("c")));
$nextDayUrl = sprintf("?peer=%s&start=%s&end=%s", urlencode($peer), urlencode($nextDayStart->format("c")), urlencode($nextDayEnd->format("c")));
$todayUrl = sprintf("?peer=%s&start=%s&end=%s", urlencode($peer), urlencode($todayStart->format("c")), urlencode($todayEnd->format("c")));

echo Twig::render("page.twig", array(
    "currentPeer" => $peer,
    "start" => $start,
    "end" => $end,
    "jumpTo" => array
    (
        "previousDay" => $previousDayUrl,
        "nextDay" => $nextDayUrl,
        "today" => $todayUrl
    ),
    "peers" => Archive::getPeers(),
    "entries" => $peer ? Archive::getEntriesForPeer($peer, $start, $end) : array()
));