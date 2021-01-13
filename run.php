<?php

use Core\Apple;
use Core\Snake;

require_once("vendor/autoload.php");

system("stty -icanon -echo");
system("clear");

//todo: создть сущность map и делать ограничения по размеру карты
system("stty cols 24 rows 24");

//todo: перенести в map
$snake = new Snake([[3, 1], [2, 1], [1, 1]], [1, 0]);
$snake->render();
$apple = new Apple(24, 24);
try {
    $apple->updateCoords($snake->getPositions());
} catch (Exception $e) {
    echo "Не существующая ситуация";
}
$apple->setCoords([5,1]);
$apple->render();

while (true)
{
    try {
        //todo: Также в сущности map проверять столкновения сос тенами и взаимодействия с прочими объектами
        if ($snake->getHeadPosition() == $apple->getPosition())
        {
            $snake->isEat = true;
            $apple->updateCoords($snake->getPositions());
            $apple->render();
        }
        $snake->move();
        $snake->rerender();

        usleep(100000);
    } catch (Exception $exception) {

        //todo: создть сущность game и встроить это в нее
        $y = 1;
        while (true)
        {
            echo chr(27)."[$y;1"."f";
            echo $exception->getMessage();
            $y++;

            usleep(1000000/$y);
            system("clear");
        }

    }
}