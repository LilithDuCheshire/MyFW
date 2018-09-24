<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 19/09/2018
 * Time: 17:47
 */

namespace MyFW\app;


use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany('MyFW\App\Users');
    }
}
