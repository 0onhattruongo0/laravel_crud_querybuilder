@extends('layout.client')
@section('title')
    {{$title}}
@endsection
@section('content')
@if(session('msg'))
<div class="alert alert-success">{{session('msg')}}</div>
@endif
@if(session('err'))
<div class="alert alert-danger">{{session('err')}}</div>
@endif
<h1>{{$title}}</h1>
<a href='{{route('users.add')}}' class='btn btn-primary mb-3'>Thêm người dùng</a>
<hr/>
<form action="" method="GET">
    <div class="row mb-3">
        <div class="col-3">
            <select name="status" id="" class="form-control text-center">
                <option value="0" selected class=''>Tất cả trạng thái</option>
                <option value="Active" {{request()->status == 'Active' ? 'selected' : false }}>Kích hoạt</option>
                <option value="Inative" {{request()->status == 'Inative' ? 'selected' : false }}>Chưa kích hoạt</option>
            </select>
        </div>
        <div class="col-3">
            <select name="group_id" id="" class="form-control text-center">
                <option value="" selected class=''>Tất cả nhóm</option>
                @if(!empty($allGroup))
                @foreach($allGroup as $key=>$item)
                <option value="{{$item->id}}" {{request()->group_id == $item->id ? 'selected' : false }}>{{$item->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-4">
            <input type="search" name='search' value='{{request()->search}}' class="form-control" placeholder='Từ tìm kiếm...'>
        </div>
        <div class="col-2">
            <button type='submit' class="btn btn-primary">Tìm kiếm</button>
        </div>
    </div>
</form>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="5%">STT</th>
            <th><a href="?sort_by=fullname&sort_type={{$sortType}}">Tên</a></th>
            <th><a href="?sort_by=email&sort_type={{$sortType}}">Email</a></th>
            <th><a href="?sort_by=group_id&sort_type={{$sortType}}">Nhóm</a></th>
            <th>Trạng thái</th>
            <th width="15%"><a href="?sort_by=create_at&sort_type={{$sortType}}">Thời gian</a></th>
            <th width="5%">Sửa</th>
            <th width="5%">Xóa</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($usersList))
        @foreach($usersList as $key=>$user)
        <tr>
            <td>{{$key +1}}</td>
            <td>{{$user->fullname}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->name}}</td>
            <td>{!!$user->status == 0 ? '<button class="btn btn-danger btn-sm">Chưa kích hoạt</button>':'<button class="btn btn-success btn-sm">Đã kích hoạt</button>'!!}</td>
            <td>{{$user->create_at}}</td>
            <td>
                <a href="{{route('users.edit',$user->id)}}" class="btn btn-warning">Sửa</a>
            </td>
            <td>
                <a onclick="return confirm('Bạn chắc chắn muốn xóa không?')" href="{{route('users.delete',$user->id)}}" class="btn btn-danger">Xóa</a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan='8' class='text text-center'>Không có dữ liệu</td>
        </tr>
        @endif
    </tbody>
</table>
<div>
    {{ $usersList->links() }}
</div>
@endsection
