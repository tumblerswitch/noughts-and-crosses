<?php

require_once(__DIR__ . '/vendor/autoload.php');

$scoreFirstUser = '';
$scoreSecondUser = '';
$winner = '';

function enterUserName()
{
    cli\out('Enter first player name' . PHP_EOL);
    $firstUserName = cli\input();
    cli\out('Hello ' . $firstUserName . '!' . PHP_EOL);
    cli\out('Enter second player name' . PHP_EOL);
    $secondUserName = cli\input();
    cli\out('Hello ' . $secondUserName . '!' . PHP_EOL);
}

$question = 'Start the "noughts and crosses" game';
//$start = cli\choose($question, $choices = 'yn', $default = 'n');

$gamesCount = 1;
$headers = array(' \ ', 'A', 'B', 'C');
$playingField = array(
    array('1', '1A', '1B', '1C'),
    array('2', '2A', '2B', '2C'),
    array('3', '3A', '3B', '3C'),
);
//if ($start !== 'n') 
cli\out('Game ' . $gamesCount . '!' . PHP_EOL);

$table = new \cli\Table();
$table->setHeaders($headers);
$table->setRows($playingField);
$table->display();


cli\out('Enter 2 symbols. First is string number, second is row letter. Example "2b" is centre of field.' . PHP_EOL);
$playerInput = mb_strtoupper(str_replace(' ', '', cli\input()));
$newPlayingField = makeMove($playingField, $activePlayer = 'X', $playerInput);
$table->setRows($newPlayingField);
$table->display();

function makeMove($playingField, $activePlayer = 'X', $playerInput) {
    $newPlayingField = [];
    $replaceCount = 0;
    $searchCount = 0;
    do {
        foreach ($playingField as $array){
            if (!empty($playerInput) && in_array($playerInput, $array)) {
                $newPlayingField[] = str_replace ( $playerInput , $activePlayer , $array);
                $replaceCount++;
            } else {
                $newPlayingField[] = $array;
                $searchCount++;
            }
        }
        if ($replaceCount >= 1) {
            break;
        }
        if ($searchCount >= 3) {
            cli\out('Values not found. Insert 2 symbols. First is string number, second is row letter.' . PHP_EOL);

            $playerInput = mb_strtoupper(str_replace(' ', '', cli\input()));
            print_r('search count = '.$searchCount);
        }
    } while ($replaceCount < 1);
    return $newPlayingField;
}