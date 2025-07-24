<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//主モデルクラスのインポート
use App\Models\Category;


class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'content',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
