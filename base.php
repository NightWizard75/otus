<?php


namespace Base;


class base
{
    public function whereAmI()
    {
        echo "You are in the block " . get_class($this) . "\n";
    }
}