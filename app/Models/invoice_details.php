<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_details extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';

    protected $fillable = [
        'invoice_numbeer',
        'invoice_id',
        'product',
        'section',
        'status',
        'value_status',
        'Payment_Date',
        'note',
        'user'
    ];
}
