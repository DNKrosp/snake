<?php

namespace Core;

use Exception;

class Apple
{
    private array $position;

    public function __construct(private $mapHeight, private $mapWidth) {}

    /**
     * @param $overPositions
     * @return bool
     * @throws Exception
     */
    public function updateCoords($overPositions): bool
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

    public function getPosition(): array
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