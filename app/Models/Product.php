<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function hasStock(int $quantity)
    {
        return $this->stock >= $quantity;
    }
}
