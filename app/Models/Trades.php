<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Trades extends Eloquent {

    protected $collection = 'trades';
    protected $dates = ['date'];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

}
