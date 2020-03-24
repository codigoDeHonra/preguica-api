<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Broker extends Eloquent {

    protected $collection = 'brokers';
}
