<?php

require_once(__DIR__.'/vendor/autoload.php');

$scoreFirstUser = '';
$scoreSecondUser = '';
$winner = '';

//cli\out('Enter first player name' . PHP_EOL);
//$firstUserName = cli\input();
//cli\out('Hello '.$firstUserName . '!' . PHP_EOL);
//cli\out('Enter second player name' . PHP_EOL);
//$secondUserName = cli\input();
//cli\out('Hello '.$firstUserName . '!' . PHP_EOL);

$question = 'Start the "noughts and crosses" game';
//$start = cli\choose($question, $choices = 'yn', $default = 'n');

$gamesCount = 0;
$headers = array(' ', 'A', 'B', 'C');
$data = array(
    array('1', '', '', ''),
    array('2', '', '', ''),
    array('3', '', '', ''),
);
//if ($start !== 'n') {
    cli\out('Game ' . $gamesCount . '!' . PHP_EOL);


$table = new \cli\Table();
$table->setHeaders($headers);
$table->setRows($data);
//$table->setRenderer(new \cli\table\Ascii([10, 10, 20, 5]));
$table->display();
//}
