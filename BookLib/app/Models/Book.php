<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'title',
        'content',
        'description',
        'path_to_image',
        'path_to_audio',
        'type'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_book', 'book_id', 'user_id');
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'subscription_book', 'id_book', 'id_subscription');
    }

    public function reviews()
    {
        return $this->hasMany(Book_review::class);
    }
}
