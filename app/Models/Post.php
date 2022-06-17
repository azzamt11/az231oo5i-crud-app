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
        'post_atribute_1',
        'post_atribute_2',
        'post_atribute_3',
        
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function subpost() {
        return $this->hasMany(SubPost::class);
    } 

}
