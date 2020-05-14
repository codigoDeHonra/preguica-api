<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Trades extends Eloquent {

    protected $collection = 'trades';

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

}
