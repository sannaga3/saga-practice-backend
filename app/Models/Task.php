<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'purpose',
        'action',
        'target_times',
        'times_unit',
        'schedule_start',
        'schedule_end',
        'remarks',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function executed_tasks()
    {
        return $this->hasMany('App\Models\ExecutedTask');
    }
}