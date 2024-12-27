<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Kategori extends Model
{
    use HasFactory;

    protected $table = "kategoris";
    protected $keyType = 'string';
    protected $primaryKey = 'id';protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
    protected $fillable = ["id", "name", "created_at", "updated_at"];
}
