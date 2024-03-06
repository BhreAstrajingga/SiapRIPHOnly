<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BroadcastMessages extends Model
{
    use HasFactory, SoftDeletes, Auditable;

	protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

	protected $fillable = [
        'type',
        'title',
        'messages',
		'status',
		'target',
		'user_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
