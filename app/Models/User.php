<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'user';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'user_type',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_author_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($oUser) {
            $oUser->blogs()->each(function ($oBlog) {
                $oBlog->delete();
            });
            $oUser->blogs()->delete();
            $oUser->comments()->delete();
            return true;
        });
    }
}
