<?php

namespace Core;

use Exception;

class Apple
{
    private $position;

    public function __construct($mapHeight, $mapWidth)
    {
        $this->mapHeight = $mapHeight;
        $this->mapWidth = $mapWidth;
    }

    public function updateCoords($overPositions)
    {
        $newAppleNotIn = false;
        $newAppleCord = [1, 1];
        if (count($overPositions) == $this->mapWidth * $this->mapHeight)
            return throw new Exception("GAME OVER, YOU WIN");
        while (!$newAppleNotIn)
        {
            $newAppleCord = [rand(1, $this->mapWidth), rand(1, $this->mapHeight)];
            if (array_search($newAppleCord, $overPositions) == false)
                $newAppleNotIn = true;
        }

        $this->position = $newAppleCord;

        return true;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setCoords($coords)
    {
        $this->position = $coords;
    }

    public function render()
    {
        $x = $this->position[0];
        $y = $this->position[1];
        echo chr(27)."[$y;$x"."f";
        echo "0";
    }
}