<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/client/css/bootstrap.min.css')}}"/>
</head>
<body>
    @include('blocks.header')
    <div class="container">
        <main class="row mt-5">
            <aside class="col-3">
                @section('sidebar')
                @include('blocks.sidebar')
                @show
            </aside>
            <div class="content col-9">
                @yield('content')
            </div>
        </main>
    @include('blocks.footer')
    </div>
    <script src="{{asset('assets/client/js/bootstrap.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @yield('js')
</body>
</html>