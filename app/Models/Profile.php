<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Profile extends Eloquent {

    protected $collection = 'profiles';

    public function user()
    {
        return $this->belongsTo(Category::class, 'user_id');
    }
}
