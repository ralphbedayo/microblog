<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'comment';

    protected $fillable = [
        'blog_id',
        'comment_author_id',
        'content'
    ];


    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    public function commentAuthor()
    {
        return $this->belongsTo(User::class, 'comment_author_id', 'id');
    }

}
