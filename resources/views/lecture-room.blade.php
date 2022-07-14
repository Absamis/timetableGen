@extends('layout.pagelayout')
@section('content')
<style>
    a:hover{
        text-decoration: none;
    }
    .form-group label{
        font-weight: 600;
        font-size: 17px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="">
                 @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif
                <h4 class="font-weight-bold bg-dark text-white p-3">{{ Str::upper($act["text"]) }} NEW ROOM</h4>
                <div class="card-body bg-white">
                    <form class="" action="{{ $act["url"] }}" method="post">
                        @csrf
                        <div class="form-group p-1 m-0">
                            <label for="department">Department</label>
                            <select name="department" class="form-control">
                                <option value="">Select department</option>
                                @foreach ($department as $item)
                                    <option value="{{ $item["name"] }}" @if (old('department') == $item["name"])
                                        selected
                                    @endif>{{ $item["name"] }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row m-0 p-0">
                            <div class="form-group col-md-7 p-1 mt-2 m-0">
                                <label for="name">Room Name</label>
                                <input type="text" name="name" value="{{ old("name") }}" class="form-control" placeholder="Name">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-5 p-1 mt-2 m-0">
                                <label for="rtype">Room Type</label>
                                <select name="rtype" class="form-control">
                                    <option value="regular" @if (old('rtype') == "regular")
                                        selected
                                    @endif>Regular</option>
                                    <option value="special" @if (old('rtype') == "special")
                                        selected
                                    @endif>Special</option>
                                </select>
                                @error('rtype')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group m-0 mt-2 p-1">
                            <button type="submit" class="btn btn-outline-warning">
                                <i class="fas fa-plus"></i> {{ $act["text"]}} Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="d-flex align-items-center p-2 bg-dark">
                <h4 class="font-weight-bold text-white m-0">ALL ROOMS</h4>
                <div class="ml-auto">
                    <form class="" action="/room/show" method="get">
                        <div class="form-input-group">
                            <button type="submit" id="filter-btn" class="btn input-append">
                                <i class="fas fa-search"></i>
                            </button>
                            <select class="form-input" id="filter" name="filter">
                                <option value="all">All</option>
                                @foreach ($department as $item)
                                    <option value="{{ $item["name"] }}" @if ($filter == $item["name"])
                                        selected
                                    @endif>{{ $item["name"] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-wrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Room Name</th>
                            <th>Room Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($room as $key => $value)
                            <tr>
                                <td>{{ $value->department }}</td>
                                <td>{{ $value->room_name }}</td>
                                <td>{{ $value->room_type }}</td>
                                <td>
                                    <a href="/room/edit/{{ $value->room_id }}" class="btn btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/room/delete/{{ $value->room_id }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick='return confirm("Are you sure to delete room?")'>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector("#filter").onchange = function(){
        document.querySelector("#filter-btn").click();
    }
</script>
@endsection
