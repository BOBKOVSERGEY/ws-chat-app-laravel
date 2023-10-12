<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'users'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
          related: User::class,
          table: 'chat_user',
          foreignPivotKey: 'chat_id',
          relatedPivotKey: 'user_id'
        );
    }

    public function messages(): HasMany
    {
        return $this->hasMany(
            related: Message::class,
            foreignKey: 'chat_id',
            localKey: 'id'
        );
    }

}
