<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $guarded = [];
    //muchos a muchos con usuarios
    public function users(){
        return $this->belongsToMany(User::class);
    }
    //muchos a muchos con permisos
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
}
