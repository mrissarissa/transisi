<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'roles';
    protected $fillable = ['id','name','display_name','description','created_at','updated_at'];
    protected $dates = ['created_at','update_at'];

    public function permission(){
        return $this->belongsToMany('App\Permission');
    }
}
