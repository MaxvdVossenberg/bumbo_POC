<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $primaryKey = 'id';

    protected $timeStamps = true;

    protected $fillable = [
        'department_id',
        'title',
        'start',
        'end',
        'url',
        'allDay',
    ];

    protected $attributes = [
        'url' => '#',
        'allDay' => false,
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'end' => 'datetime',
        'start' => 'datetime',
        'allDay' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
}
