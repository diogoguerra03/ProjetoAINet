<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];

    public function orderItems(): HasMany
    {
        return $this->hasMany(TshirtImage::class, 'color_code', 'code');
    }

    
}
