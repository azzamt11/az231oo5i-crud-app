<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SubPost;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_body',
        'post_type',
        'post_user',
        'post_id',
        'post_attribute_1',
        'post_attribute_2',
        'post_attribute_3',
        
    ];
}
