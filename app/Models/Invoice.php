<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    USE SoftDeletes;
    protected $table = 'invoices';
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    

}
