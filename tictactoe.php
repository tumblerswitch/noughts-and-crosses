<?php

require_once(__DIR__ . '/vendor/autoload.php');

//Запуск игры ("Начать игру?"):
$question = 'Start the "noughts and crosses" game';
$start = cli\choose($question, $choices = 'yn', $default = 'n');
if ($start == 'n') {
    exit('If you don\'t want to, well, don\'t. Leave.' . PHP_EOL);
}

//1-2) введите username для 1 и 2 players
$activeUser = changeActiveUser('second');
$firstUserName = enterUserName(($activeUser));
$secondUserName = enterUserName(changeActiveUser($activeUser));
$usersArray = [$firstUserName, $secondUserName];
$firstPlayer = randomFirstPlayer($usersArray);
$activeFigure = 'O';

//4) Выводится номер раунда и игрового поля
$gamesCount = 1;
$firstUserScore = 0;
$secondUserScore = 0;
cli\out('Game ' . $gamesCount . '!' . PHP_EOL);
showScoreboard($firstUserName, $firstUserScore, $secondUserName, $secondUserScore);

$headers = array(' \ ', 'A', 'B', 'C');
$playingField = array(
    array('1', '1A', '1B', '1C'),
    array('2', '2A', '2B', '2C'),
    array('3', '3A', '3B', '3C'),
);
displayNewPlayingField($headers, $playingField);

//5-7) Игрок делает ход (заполняет клетку), и ход передается другому игроку. Вывод username победителя или "Ничья"
cli\out('Enter 2 symbols. First is string number, second is row letter. Example "2b" is centre of field.' . PHP_EOL);
cli\out($resultMatch = makeMove($playingField, $activeFigure, $firstPlayer, $usersArray, $headers));

//8) Обновление таблицы со счетом и ее вывод.
$activePlayer = 'Tagir';
$resultMatch = $activePlayer . ' won! Congratulations!' . PHP_EOL;
$winner = implode(explode(" ", $resultMatch, -2));
if ($winner == $firstUserName) {
    $firstUserScore++;
} elseif ($winner == $secondUserName) {
    $secondUserScore++;
}
showScoreboard($firstUserName, $firstUserScore, $secondUserName, $secondUserScore);
$gamesCount++;

function showScoreboard($firstUserName, $firstUserScore, $secondUserName, $secondUserScore)
{
    $scoreBoard = $firstUserName . ' - ' . $firstUserScore . PHP_EOL .
        $secondUserName . ' - ' . $secondUserScore . PHP_EOL;
    cli\out($scoreBoard);
}

function winCheck($activeFigure, $playingField, $activePlayer)
{
    //winHorizontal1
    if ($playingField[0][1] == $activeFigure &&
        $playingField[0][2] == $activeFigure &&
        $playingField[0][3] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
    //winHorizontal2
    if ($playingField[1][1] == $activeFigure &&
        $playingField[1][2] == $activeFigure &&
        $playingField[1][3] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
    //winHorizontal3
    if ($playingField[2][1] == $activeFigure &&
        $playingField[2][2] == $activeFigure &&
        $playingField[2][3] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
    //winVerticalA
    if ($playingField[0][1] == $activeFigure &&
        $playingField[1][1] == $activeFigure &&
        $playingField[2][1] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
    //winVerticalB
    if ($playingField[0][2] == $activeFigure &&
        $playingField[1][2] == $activeFigure &&
        $playingField[2][2] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
    //winVerticalC
    if ($playingField[0][3] == $activeFigure &&
        $playingField[1][3] == $activeFigure &&
        $playingField[2][3] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
    //winDiagonal1
    if ($playingField[0][1] == $activeFigure &&
        $playingField[1][2] == $activeFigure &&
        $playingField[2][3] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
    //winDiagonal2
    if ($playingField[0][3] == $activeFigure &&
        $playingField[1][2] == $activeFigure &&
        $playingField[2][1] == $activeFigure) {
        return $activePlayer . ' won! Congratulations!' . PHP_EOL;
    }
}

function makeMove($playingField, $activeFigure, $firstPlayer, $usersArray, $headers)
{
    $resultDraw = 'The game ended in a draw.' . PHP_EOL;
    $counter = 0;
    $newPlayingField = $playingField;
    $newActivePlayer = $firstPlayer;
    $newActiveFigure = $activeFigure;
    while ($counter < 9) {
        $newActivePlayer = reverseActivePlayer($newActivePlayer, $usersArray);
        $newActiveFigure = reverseActiveFigure($newActiveFigure);
        showWhoseMove($newActivePlayer, $newActiveFigure);
        $playerInput = mb_strtoupper(str_replace(' ', '', cli\input()));
        $newPlayingField = insertSymbolToPlayingField($newPlayingField, $newActiveFigure, $playerInput);
        displayNewPlayingField($headers, $newPlayingField);
        $win = winCheck($newActiveFigure, $newPlayingField, $newActivePlayer);
        if ($win == true) {
            return $win;
        }
        $counter++;
    }
    return $resultDraw;
}

function reverseActivePlayer($activePlayer, $usersArray)
{
    if ($activePlayer === $usersArray[0]) {
        return $activePlayer = $usersArray[1];
    } elseif ($activePlayer === $usersArray[1]) {
        return $activePlayer = $usersArray[0];
    }
}

function reverseActiveFigure($activeFigure)
{
    if ($activeFigure == 'X') {
        return 'O';
    } elseif ($activeFigure == 'O') {
        return 'X';
    }
}

function displayNewPlayingField($headers, $newPlayingField)
{
    $table = new \cli\Table();
    $table->setHeaders($headers);
    $table->setRows($newPlayingField);
    $table->display();
}

function showWhoseMove($activeUser, $activeFigure)
{
    cli\out($activeUser . ' is your move. You - ' . $activeFigure . PHP_EOL . PHP_EOL);
}

function randomFirstPlayer($usersArray)
{
    $indexPlayer = array_rand($usersArray, 1);
    return $usersArray[$indexPlayer];
}

function changeActiveUser($activeUser)
{
    if ($activeUser === 'second') {
        return 'first';
    } elseif ($activeUser === 'first') {
        return 'second';
    }
}

function enterUserName($activePlayer)
{
    cli\out('Enter ' . $activePlayer . ' player name' . PHP_EOL);
    $userName = cli\input();
    cli\out('Hello ' . $userName . '!' . PHP_EOL . PHP_EOL);
    return $userName;
}

function insertSymbolToPlayingField($playingField, $newActiveFigure, $playerInput)
{
    $newPlayingField = $playingField;
    $replaceCount = 0;
    $searchCount = 0;

    while ($newPlayingField === $playingField) {
        foreach ($newPlayingField as &$array) {
            if (!empty($playerInput) && (strlen($playerInput) == 2) && in_array($playerInput, $array)) {
                foreach ($array as &$value) {
                    $value = str_replace($playerInput, $newActiveFigure, $value);
                    $replaceCount++;
                }
            }
            $searchCount++;
        }
        if ($replaceCount >= 1) {
            break;
        }
        if ($searchCount >= 3) {
            cli\out('Values not found. Insert 2 symbols. First is string number, second is row letter.' . PHP_EOL);
            $playerInput = mb_strtoupper(str_replace(' ', '', cli\input()));
        }
    }
    return $newPlayingField;
}
