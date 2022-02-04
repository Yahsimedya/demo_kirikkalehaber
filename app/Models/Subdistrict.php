<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;
    protected $fillable = [
        'district_id',
        'subdistrict_en',
        'subdistrict_tr',
        'subdistrict_keywords',
        'subdistrict_description',
        'subdistrict_status',
        'subdistrict_order',

    ];
    public function scopeStatus($query) {
        return $query->where('subcategory_status',1);
    }
    public function scopeDrafted($query) {
        return $query->where('subcategory_status',0);
    }
}
