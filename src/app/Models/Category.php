<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//従側モデルクラスのインポート
use App\Models\Contact;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];

    public function contacts()
    {
        // hasMany(コネクトする従側モデル名）
        return $this->hasMany(Contact::class);
    }
}
