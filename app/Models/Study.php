<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Study extends Eloquent {

    protected $collection = 'studies';

    /* public function category() */
    /* { */
    /*     return $this->belongsTo(Category::class, 'category_id'); */
    /* } */
}
