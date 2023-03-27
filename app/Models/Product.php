<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $guarded = ['id'];

    protected $attributes = [
        'price' => 0,
        'quantity' => 0
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_id');
    }
}
