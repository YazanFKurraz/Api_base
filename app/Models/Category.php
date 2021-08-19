<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name_en', 'name_ar', 'active', 'created_at', 'updated_at'];

    public static function get_category()
    {
        return Category::select('id', 'name_' . app()->getLocale() . ' as name', 'active');
    }

    /*
//    stander name scope is_active
    public function scopeIsActive(){}
*/
    //get all category is_active
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


}
