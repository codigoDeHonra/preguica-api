<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Wallet extends Eloquent {

    protected $collection = 'wallets';

    public function categories()
    {
        return $this->hasMany(Category::class, 'wallet');
    }
}
