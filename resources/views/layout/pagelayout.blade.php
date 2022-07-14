<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<style>
	</style>
</head>
<body class="bg-light text-dark">
	@include("include/navbar")
	<div class="main">
        <div class="p-2 text-right">
            <span class="p-2 bg-brow text-warning">
                <i class="far fa-calendar"></i>
                <span class="font-weight-bold" style="font-size: 19px;">{{ session('session_date')}} Session</span>
            </span>
            <span class="p-2 bg-brow text-warning">
                <i class="far fa-clock"></i>
                <?php $sem = array(1 => "1st", 2=>"2nd"); ?>
                <span class="font-weight-bold" style="font-size: 19px;">{{ $sem[session('session_term')] }} semester</span>
            </span>
        </div>
        <div class="d-flex align-items-center p-3">
            <h4 class="">@if($title) {{ $title }} @endif</h4>
            {{-- <div class="ml-auto">
                <form class="" action="/admin/transaction" method="post">
                    @csrf
                    <div class="form-input-group">
                        <button type="submit" class="btn input-append">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" class="form-input" name="id" placeholder="search transactions">
                    </div>
                </form>
            </div> --}}
        </div>
		@yield("content")
	</div>
    <script type="text/javascript" src=" {{ asset('assets/js/jquery-3.5.1.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('assets/js/popper.min.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('assets/js/custom-script.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('assets/js/helper-script.js') }}"></script>
</body>
</html>
