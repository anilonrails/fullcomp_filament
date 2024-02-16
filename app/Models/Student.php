<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends \Illuminate\Foundation\Auth\User
{
    use HasFactory;

    protected $guard = 'student';

    protected $fillable = [
        'class_id',
        'section_id',
        'name',
        'email',
        'password'
    ];

    protected $casts = [
        'password'=>'hashed'
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
