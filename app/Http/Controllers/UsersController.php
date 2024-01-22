<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UsersModel;
use App\Models\GroupModel;
use App\Http\Requests\UsersRequestt;

class UsersController extends Controller
{

    private $users;
    private $groups;
    const _PER_PAGE = 10;

    public function __construct(){
        $this->users = new UsersModel();
        $this->groups = new GroupModel();
    }

    public function index(Request $request){
        $title = 'Danh sách người dùng';

        $filters = [];
        $keyword =null;
        if(!empty($request->status)){
            if($request->status == 'Active'){
                $status = 1;
            }else{
                $status = 0;
            }

            $filters[] = ['users.status','=',$status];
        }

        if(!empty($request->group_id)){
            $groupId = $request->group_id;

            $filters[] = ['users.status','=',$groupId];
        }
        if(!empty($request->search)){
            $keyword = $request->search;
        }


        $sortBy= $request->sort_by;
        $sortType = $request->sort_type;
        $allow_sort= ['desc','asc'];
        if($sortType && in_array($sortType,$allow_sort)){
            if($sortType == 'desc'){
                $sortType = 'asc';
            }else{
                $sortType = 'desc';
            }
        }else{
            $sortType = 'asc';
        }

        $sortArr = [
            'sortBy' => $sortBy,
            'sortType' => $sortType,
        ];


        $usersList = $this->users->getAllUsers($filters,$keyword,$sortArr,self::_PER_PAGE);
        $allGroup= $this->groups->allGroup();
        return view('client.users.list', compact('title','usersList','allGroup','sortType'));
    }

    public function add(){
        $title = "Thêm người dùng";
        $allGroup= $this->groups->allGroup();
        return view('client.users.add', compact('title','allGroup'));
    }

    public function postAdd(UsersRequestt $request){
        // $request->validate([
        //     'fullname' => 'required|min:5',
        //     'email' => 'required|email|unique:users',
        //     'group_id' => ['required','integer', function($attribute,$value,$fail){
        //         if($value == 0){
        //             $fail('Vui lòng chọn nhóm');
        //         }
        //     }],
        //     'status' => 'required|integer',
        // ],[
        //     'fullname.required' => 'Họ tên không được để trống',
        //     'fullname.min' => 'Họ tên ít nhất phải 5 ký tự',
        //     'email.required' => 'Email không được để trống',
        //     'email.email' => 'Định dạng email không đúng',
        //     'email.unique' => 'Email đã tồn tại',
        //     'group_id.required' => 'Vui lòng chọn nhóm...',
        //     'group_id.integer' => 'Kiểu định dạng nhóm không phù hợp',
        //     'status.required' => 'Trạng thái không được để trống',
        //     'status.integer' => 'Kiểu định dạng trạng thái không phù hợp',
        // ]);

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'status' => $request->status,
            'create_at' => date('Y-m-d H:i:s')
        ];
        
        $this->users->addUser($data);

        return redirect()->route('users.index')->with('msg','Đã thêm thành công');

    }

    public function edit(Request $request, $id){
        $title = "Cập nhật người dùng";
        
        if(!empty($id)){
            $data = $this->users->userDetail($id);
            if(!empty($data[0])){
                $request->session()->put('id',$id);
                $dataDetail = $data[0];
            }
        }else{
            return redirect()->route('users.index')->with('err','Liên kết không tồn tại');
        }
        $allGroup= $this->groups->allGroup();
        return view('client.users.edit', compact('title','allGroup','dataDetail'));
    }

    public function postEdit(UsersRequestt $request){

        $id = session('id'); //Cách này để bảo mật ko cho phép dùng người này chỉnh sửa người kia
        if(empty($id)){
            return back()->with('err','Liên kết không tồn tại');
        }
        // $request->validate([
        //     'fullname' => 'required|min:5',
        //     'email' => 'required|email|unique:users,email,'.$id,
        //     'group_id' => ['required','integer', function($attribute,$value,$fail){
        //         if($value == 0){
        //             $fail('Vui lòng chọn nhóm');
        //         }
        //     }],
        //     'status' => 'required|integer',
        // ],[
        //     'fullname.required' => 'Họ tên không được để trống',
        //     'fullname.min' => 'Họ tên ít nhất phải 5 ký tự',
        //     'email.required' => 'Email không được để trống',
        //     'email.email' => 'Định dạng email không đúng',
        //     'email.unique' => 'Email đã tồn tại',
        //     'group_id.required' => 'Vui lòng chọn nhóm...',
        //     'group_id.integer' => 'Kiểu định dạng nhóm không phù hợp',
        //     'status.required' => 'Trạng thái không được để trống',
        //     'status.integer' => 'Kiểu định dạng trạng thái không phù hợp',
        // ]);

        $dataUpdate = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'status' => $request->status,
            'update_at' => date('Y-m-d H:i:s')
        ];

        $this->users->updateUser($dataUpdate,$id);

        return redirect()->route('users.index')->with('msg','Cập nhật thành công');
        
    }

    public function delete($id){
        if(!empty($id)){
            $userDetail = $this->users->userDetail($id);
            if(!empty($userDetail[0])){
                $deleteStatus = $this->users->deleteUser($id);
                if($deleteStatus){
                    $msg = "Xóa người dùng thành công";
                }else{
                    $msg = "Bạn không thể xóa lúc này";
                }
            }else{
                $msg = "Người dùng không tồn tại";
            }
        }else{
            $msg = "Liên kết không tồn tại";
        }

        return redirect()->route('users.index')->with('msg',$msg);
    }
}
