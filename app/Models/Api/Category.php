<?php

namespace App\Models\Api;

class Category extends \App\Models\Category
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
