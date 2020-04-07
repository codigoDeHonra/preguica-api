<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent {

    protected $collection = 'categories';

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'category');
    }
}
