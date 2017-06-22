<?php

$date = "2017-06-22T07:11:43.229Z";

$datetime = new DateTime($date);
echo $datetime->format('Y-m-d H:i:s') . "\n";
$dbTimeZone = new DateTimeZone('Europe/Kiev');
$datetime->setTimezone($dbTimeZone);
echo $datetime->format('Y-m-d H:i:s') . "\n";