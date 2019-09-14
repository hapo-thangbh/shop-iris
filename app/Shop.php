<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
      'name', 'address', 'phone', 'facebook', 'shoppe', 'note_1', 'note_2',
    ];
}
