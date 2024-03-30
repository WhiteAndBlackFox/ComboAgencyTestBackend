<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_NEW = 0;

    public const STATUS_PENDING = 1;

    public const STATUS_COMPLETED = 2;

    public const STATUS_EXPIRED = 3;

    public const STATUS_REJECTED = 4;

    protected $guarded = false;
}
