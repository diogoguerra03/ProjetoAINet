<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TshirtImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'category_id',
        'name',
        'description',
        'image_url',
        'extra_info' // JSON
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getImageUrlAttribute($value)
    {
        return Storage::url('tshirt_images/' . $value);

    }

    public function getColorUrlAttribute()
    {
        $selectedColor = request()->input('selectedColor');
        $defaultColorUrl = Storage::url('tshirt_base/e7e0ee.jpg'); // the whitest color
        return $selectedColor ? Storage::url('tshirt_base/' . $selectedColor . '.jpg') : $defaultColorUrl;
    }

    public function getExtraInfoAttribute($value)
    {
        return json_decode($value);
    }

    public function getSlugAttribute($value)
    {
        return $this->id . '-' . Str::slug($this->name);
    }
}
