<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'departments';

    protected $primaryKey = 'id';

    protected $timeStamps = true;

    protected $fillable = [
        'title',
        'color'
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function users()
    {
        return $this->hasMany(User::class );
    }
}
