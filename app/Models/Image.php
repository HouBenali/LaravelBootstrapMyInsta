<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table='images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'image_path',
        'description',
    ];

    public function comments(){
        return $this->hasMany('\App\Models\Comment')->orderBy('id','desc');
    }

    public function likes(){
        return $this->hasMany('\App\Models\Like');
    }

    public function user(){
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
}
