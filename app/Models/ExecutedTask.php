<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutedTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'times',
        'date',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}