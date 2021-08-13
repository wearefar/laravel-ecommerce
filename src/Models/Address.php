<?php

namespace WeAreFar\Ecommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address_line_1',
        'address_line_2',
        'city',
        'zip',
        'state',
        'country',
        'phone',
    ];

    public $timestamps = false;
}
