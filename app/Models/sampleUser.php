<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sampleUser extends Model
{
    use HasFactory;

    protected $table = 'sample_users';
    protected $guarded = [];
}
