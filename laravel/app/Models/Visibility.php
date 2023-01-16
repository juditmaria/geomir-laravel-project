<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visibility extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    
    const PUBLIC   = 1;
    const CONTACTS = 2;
    const PRIVATE  = 3;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];
}
