<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name'];

    public function tshirtImages(): HasMany
    {
        return $this->hasMany(TshirtImage::class);
    }
}