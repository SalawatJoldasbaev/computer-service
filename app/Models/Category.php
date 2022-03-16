<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function children(){
        return $this->hasMany(Category::class,'parent_id')->with('children')->select('id', 'parent_id', 'name', 'min_percent', 'max_percent', 'whole_percent');
    }

    public function parents(){
        return $this->hasMany(Category::class,'parent_id')->with('parents')->select('id', 'parent_id');
    }
}
