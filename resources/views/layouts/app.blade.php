

<!DOCTYPE html>
<html lang="en">

<head>

    @include('panel.head')


</head>

<body>

<div id="wrapper">

    @include('panel.navbar')

    @include('panel.sidebar')

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page title')</h1>
                </div>
            </div>

            @if(session()->get('errors'))
                <div class="alert alert-danger" id="alert-danger" role="alert">
                    {{session()->get('errors')->first()}}
                </div>
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-primary" role="alert">
                    <ul>
                        {!! \Session::get('success') !!}
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>
    </div>

</div>

@include('panel.script')

</body>

</html>
