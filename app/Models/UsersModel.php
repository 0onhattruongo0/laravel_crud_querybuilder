<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class UsersModel extends Model
{
    use HasFactory;

    protected $table="users";

    public function getAllUsers($filters = [],$keyword = null,$sortArr=[],$per_page = null){
        $users = DB::table($this->table)->select('users.*','groups.name')
        ->join('groups','users.group_id','=','groups.id');

        $sortBy = 'users.create_at';
        $sortType = 'DESC';

        if(!empty($sortArr) && is_array($sortArr)){
            if(!empty($sortArr['sortBy']) && !empty($sortArr['sortType'])){
                $sortBy = 'users.'.trim($sortArr['sortBy']);
                $sortType = trim($sortArr['sortType']);
            }
        }

        $users = $users->orderBy($sortBy,$sortType);


        if(!empty($filters)){
            $users = $users->where($filters);
        }
        if(!empty($keyword)){
            $users = $users->where(function($query) use ($keyword){
                $query->orwhere('fullname','like','%'.$keyword.'%');
                $query->orwhere('email','like','%'.$keyword.'%');
            });
        }
        if(!empty($per_page)){
            $users= $users->paginate($per_page)->withQueryString();
        }else{
            $users= $users->get();
        }
       
        return $users;
    }

    public function addUser($data){
        return DB::table($this->table)->insert($data);
    }

    public function userDetail($id){
        return DB::table($this->table)->select('users.*','groups.name')
        ->join('groups','users.group_id','=','groups.id')->where('users.id','=',$id)->get();
    }

    public function updateUser($data,$id){
        return DB::table($this->table)->where('id',$id)->update($data);
    }

    public function deleteUser($id){
        return DB::table($this->table)->where('id',$id)->delete();
    }
}