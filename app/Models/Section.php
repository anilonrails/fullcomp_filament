<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'name'];


    public function classes() : BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
}
