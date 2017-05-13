<?php

namespace MeritocrateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MeritocrateBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}