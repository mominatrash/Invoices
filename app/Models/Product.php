<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;

    public function section(){
        return $this->belongsTo('App\Models\Section');
    }
}

