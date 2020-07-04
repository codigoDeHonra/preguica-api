<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent {

    protected $collection = 'categories';

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'category_id');
    }
}
