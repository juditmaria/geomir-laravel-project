<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    const CONTENT_ADMINISTRATION = 'content.admin';
    const CONTENT_MODERATION     = 'content.moderate';
    
    const USERS        = 'users.*';
    const USERS_LIST   = 'users.list';
    const USERS_CREATE = 'users.create';
    const USERS_READ   = 'users.read';
    const USERS_UPDATE = 'users.update';
    const USERS_DELETE = 'users.delete';
    
    const FILES        = 'files.*';
    const FILES_LIST   = 'files.list';
    const FILES_CREATE = 'files.create';
    const FILES_READ   = 'files.read';
    const FILES_UPDATE = 'files.update';
    const FILES_DELETE = 'files.delete';
    
    const POSTS        = 'posts.*';
    const POSTS_LIST   = 'posts.list';
    const POSTS_CREATE = 'posts.create';
    const POSTS_READ   = 'posts.read';
    const POSTS_UPDATE = 'posts.update';
    const POSTS_DELETE = 'posts.delete';

    const PLACES        = 'places.*';
    const PLACES_LIST   = 'places.list';
    const PLACES_CREATE = 'places.create';
    const PLACES_READ   = 'places.read';
    const PLACES_UPDATE = 'places.update';
    const PLACES_DELETE = 'places.delete';
}
