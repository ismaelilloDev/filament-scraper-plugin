<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebScraper extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'selectors' => 'array'
    ];
}
