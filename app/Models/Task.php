<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    protected $fillable = ['title', 'description', 'completed'];
    protected $casts = [
        'completed' => 'boolean',
    ];
    public function scopeWhereDone($query)
    {
        return $query->where('completed', true);
    }

    public function scopeWhereNotDone($query)
    {
        return $query->where('completed', false);
    }
}
