<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Download extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'url',
        'download_type',
        'selected_format',
        'status',
        'message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
