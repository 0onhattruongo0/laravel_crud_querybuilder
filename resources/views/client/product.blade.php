@extends('layout.client')
@section('title')
    Sản phẩm
@endsection
@section('sidebar')
@parent
Child Sidebar
@endsection
@section('content')
<h1>Thêm sản phẩm</h1>
<form action="{{route('add_product')}}" method="POST" id="form_submit">
    @csrf
    {{-- @error('msg')
        <div class='alert alert-danger text-center'>{{$message}}</div>
    @enderror --}}
    <div class='alert alert-danger text-center msg' style="display:none"></div>
    <div class="mb-3">
        <label>Tên sản phẩm</label>
        <input type='text' class="form-control" value="{{old('product_name')}}" name="product_name" placehoder="Tên sản phẩm" />
        {{-- @error('product_name')
            <span class="text-danger">{{$message}}</span>
        @enderror --}}
        <span class="text-danger error product_name_error"></span>
    </div>
    <div class="mb-3">
        <label>Giá</label>
        <input type='text' class="form-control" value="{{old('product_price')}}" name="product_price" placehoder="Giá" />
        {{-- @error('product_price')
        <span class="text-danger">{{$message}}</span>
        @enderror --}}
        <span class="text-danger error product_price_error"></span>
    </div>
    <button type="submit" class="btn btn-primary">Thêm mới</button>
</form>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('#form_submit').on('submit', function(e){
                e.preventDefault();
                
                let product_name = $('input[name=product_name]').val().trim();
                let product_price = $('input[name=product_price]').val().trim();


                let urlAction = $(this).attr('action');
                let csrf_token = $(this).find('input[name=_token]').val();
                $('.error').text(''); // reset lỗi
                $.ajax({
                    url: urlAction,
                    type: 'POST',
                    data: {
                        product_name : product_name,
                        product_price: product_price,
                        _token: csrf_token
                    },
                    dataType: 'json',
                    success: function(res){
                        console.log(res)
                    },
                    error: function(error){
                        let errs= error.responseJSON.errors;
                        // console.log(errs);
                        // console.log(Object.keys(errs).length); // cần thì kiểm tra thêm object có ko?
                        $('.msg').show();

                        $('.msg').text(errs.msg);
                        for(let key in errs){
                            $('.'+key+'_error').text(errs[key][0]);
                        }
                    }
                })
            });
        });
    </script>
@endsection