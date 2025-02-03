<?php

namespace App\Models;

use App\Models\Scopes\LatestFirstScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestFirstScope::class])]
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
