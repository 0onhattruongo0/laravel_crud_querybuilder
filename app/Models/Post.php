<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Quy ước:
    // Tên model : Post -> Tên table : posts
    // Tên model : ProductCategory -> Tên table : product_categories

    // protected $table = "posts"; //Trường hợp khi tên bảng khác với quy ước thì cài đặt bằng cách này

    // protected $primaryKey = 'id'; //Trường hợp khóa chính ko phải là id thì cài đặt bằng cách này
    
    // public $incrementing = false; //Trường hợp khóa chính không tự động tăng

    // protected $keyType = 'string'; //Trường hợp khóa chính không phải kiểu integer

    // CONST CREATED_AT = 'create_at'; //Trường hợp thay đổi tên ngày tạo
    // CONST UPDATED_AT = 'update_at'; //Trường hợp thay đổi tên ngày update

    // public $timeStamps = false; //Trường hợp không muốn thêm ngày tạo và ngày update

    // protected $attributes = [ //Trường hợp thêm mặc định trường này vào mà cơ sở dữ liệu tạo ko phải dạng default
    //     'status' => 1
    // ];
}
