<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'original_url',
        'short_code',
        'title',
        'clicks',
    ];

    protected $appends = ['short_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getShortUrlAttribute()
    {
        return url('/s/' . $this->short_code);
    }

    public function incrementClicks()
    {
        $this->increment('clicks');
    }
}