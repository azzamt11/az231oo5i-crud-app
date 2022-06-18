<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Models\Post;

class SubPost extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'subpost_body',
        'subpost_type',
        'subpost_user',
        'subpost_parent',
        'subpost_attribute_1',
        'subpost_attribute_2',
        'subpost_attribute_3',
        
    ];
}
