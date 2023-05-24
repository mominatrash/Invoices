<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_details extends Model
{
    protected $table = 'invoices_details';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
