<?php
namespace Vehicles;
use Base\base;

class plane extends base
{
    public function whereAmI()
    {
        echo "I can fly and ";
        parent::whereAmI();
    }
}