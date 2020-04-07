<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Asset extends Eloquent {

    protected $collection = 'assets';

    public function category()
    {
        return $this->hasOne(Category::class, 'category');
    }
}
