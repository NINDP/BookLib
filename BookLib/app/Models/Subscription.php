<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function userSubscription()
    {
        return $this->belongsTo(User_subscription::class, 'subscription_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'subscription_book', 'id_subscription', 'id_book');
    }
}
