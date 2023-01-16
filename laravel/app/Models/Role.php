<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    const AUTHOR = 'author';
    const EDITOR = 'editor';
    const ADMIN  = 'admin';
}
