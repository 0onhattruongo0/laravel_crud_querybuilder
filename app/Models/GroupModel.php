<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupModel extends Model
{
    use HasFactory;

    protected $table="groups";

    public function AllGroup(){
        $allGroup = DB::table($this->table)->get();
        return $allGroup;
    }


}
