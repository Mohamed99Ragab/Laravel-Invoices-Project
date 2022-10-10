<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_attachement extends Model
{
    use HasFactory;
    protected $table = 'invoice_attachements';

    protected $fillable = [
        'file_name',
        'invoice_number',
        'invoice_id',
        'user'
    ];

}
