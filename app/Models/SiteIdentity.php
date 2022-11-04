<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteIdentity extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'logo', 'tagline', 'footer_copyright'];
}
