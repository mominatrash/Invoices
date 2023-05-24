<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_attachments extends Model
{
    protected $table = 'invoices_attachments';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
