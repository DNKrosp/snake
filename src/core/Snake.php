<?php


namespace Core;


use Exception;

class Snake
{
    const matrix = [
        "LEFT"=>[-1, 0],
        "RIGHT"=>[1, 0],
        "UP"=>[0, -1],
        "DOWN"=>[0, 1],
    ];

    private $clear;
    public $isEat = false;

    public function __construct($positions, $direction)
    {
        $this->positions = $positions;
        $this->direction = $direction; //[0, 1], [1, 0], [0, -1], [-1, 0]

        $this->stdin = fopen('php://stdin', 'r');
        stream_set_blocking($this->stdin, 0);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function move()
    {
        $this->direction = $this->getDirectionFromChar();
        $head = $lastPosition = $this->positions[0];
        $newHeadPosition = [$head[0] + $this->direction[0], $head[1] + $this->direction[1]];
        foreach ($this->positions as $position)
        {
            if ($position == $newHeadPosition)
                return
                    throw new Exception("you is ate yourself");
        }

        array_unshift($this->positions, $newHeadPosition);

        if (!$this->isEat)
            $this->clear = array_pop($this->positions);

        return true;
    }

    public function getHeadPosition()
    {
        return $this->positions[0];
    }

    public function getPositions()
    {
        return $this->positions;
    }

    public function render()
    {
        foreach ($this->positions as $position)
        {
            $x = $position[0];
            $y = $position[1];
            echo chr(27)."[$y;$x"."f";
            echo "x";
        }

        $x = $this->positions[0][0];
        $y = $this->positions[0][1];
        echo chr(27)."[$y;$x"."f";
        echo "#";
    }

    public function rerender()
    {
        if (!$this->isEat)
        {
            $x = $this->clear[0];
            $y = $this->clear[1];
            echo chr(27)."[$y;$x"."f";
            echo " ";
        } else
            $this->isEat = false;


        $x = $this->positions[1][0];
        $y = $this->positions[1][1];
        echo chr(27)."[$y;$x"."f";
        echo "x";

        $x = $this->positions[0][0];
        $y = $this->positions[0][1];
        echo chr(27)."[$y;$x"."f";
        echo "#";
        echo chr(27)."[$y;$x"."f";
    }

    private function getDirectionFromChar()
    {
        $command = strtolower(trim(stream_get_contents($this->stdin)));

        return match ($command)
        {
            "w", "[a" => $this->direction == self::matrix["DOWN"] ? $this->direction : self::matrix["UP"],
            "a", "[d" => $this->direction == self::matrix["RIGHT"] ? $this->direction : self::matrix["LEFT"],
            "s", "[b" => $this->direction == self::matrix["UP"] ? $this->direction : self::matrix["DOWN"],
            "d", "[c" => $this->direction == self::matrix["LEFT"] ? $this->direction : self::matrix["RIGHT"],
            default => $this->direction,
        };
    }

}