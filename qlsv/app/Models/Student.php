<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public $timestamps = false;
    function getGendername()
    {
        $genderMap=[0=>"Nam",1=>"Nữ",2=>"Khác"];
        return $genderMap[$this->gender];
    }
}
