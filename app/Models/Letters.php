<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letters extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'letter_type_id',
        'letter_perihal',
        'content',
        'recipients',
        'attachment',
        'notulis',
    ];

    protected $casts = [
        'recipients' => 'array',
        
    ];

    public function letterType()
    {
        return $this->belongsTo(LetterTypes::class, 'letter_type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'notulis', 'id');
    }

    public function result()
    {
        return $this->hasMany(Results::class, 'letter_id', 'id');
    }
}
