<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Buku extends Model
{
    use HasFactory;
    protected $table = "bukus";
    protected $keyType = 'string';
    protected $primaryKey = 'id';protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }
    protected $fillable = ["id", "kategori_id", "name", "image", "price", "created_at", "updated_at"];
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
