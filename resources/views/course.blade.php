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
                <h4 class="font-weight-bold bg-dark text-white p-3">ADD NEW COURSE</h4>
                <div class="card-body bg-white">
                    <form class="" action="/course" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 p-1 mt-2 m-0">
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
                            <div class="form-group col-md-6 p-1 m-0 mt-2">
                                <label for="level">Level</label>
                                <select name="level" class="form-control">
                                    <option value="">Select level</option>
                                    <option value="nd1" @if (old('level') == 'nd1')
                                            selected
                                        @endif>ND I</option>
                                    <option value="nd2" @if (old('level') == 'nd2')
                                            selected
                                        @endif>ND II</option>
                                    <option value="hnd1" @if (old('level') == 'hnd1')
                                            selected
                                        @endif>HND I</option>
                                    <option value="hnd2" @if (old('level') == 'hnd2')
                                            selected
                                        @endif>HND II</option>
                                </select>
                                @error('level')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8 p-1 mt-2 m-0">
                                <label for="title">Course Title</label>
                                <input type="text" name="title" value="{{ old("title") }}" class="form-control" placeholder="Title">
                                @error('title')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 p-1 mt-2 m-0">
                                <label for="code">Course Code</label>
                                <input type="text" name="code" value="{{ old("code") }}" class="form-control" placeholder="Code">
                                @error('code')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8 p-1 mt-2 m-0">
                                <label for="lecturer">Lecturer name</label>
                                <input type="text" name="lecturer" value="{{ old("lecturer") }}" class="form-control" placeholder="Lecturer">
                                @error('lecturer')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 p-1 mt-2 m-0">
                                 <label for="type">Course Type</label>
                                <select name="type" class="form-control">
                                    <option value="">Select type</option>
                                    <option value="theory" @if (old('type') == 'theory')
                                            selected
                                        @endif>Theory</option>
                                    <option value="practical" @if (old('tpe') == 'practical')
                                            selected
                                        @endif>Practical</option>
                                </select>
                                @error('type')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-7 p-1 mt-2 m-0">
                                 <label for="room">Select Room <small>(special for course)</small></label>
                                <select name="room" class="form-control">
                                    <option value="">Select Room</option>
                                    @foreach ($room as $item)
                                        <option value="{{ $item["room_name"] }}" @if (old('room') == $item["room_name"])
                                            selected
                                        @endif>{{ $item["room_name"] }}</option>
                                    @endforeach
                                </select>
                                @error('room')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group m-0 mt-2 p-1">
                            <button type="submit" class="btn btn-outline-warning">
                                <i class="fas fa-plus"></i> Add Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="d-flex align-items-center p-2 bg-dark">
                <h4 class="font-weight-bold text-white m-0">ALL COURSES</h4>
                <div class="ml-auto">
                    <form class="" action="/course/show" id="fiter-form" method="get">
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
                            <th>Course Code</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course as $ke => $value)
                             <tr>
                                <td>{{ $value->department}}</td>
                                <td>{{ Str::upper($value->course_code) }}</td>
                                <td>{{ Str::upper($value->level) }}</td>
                                <td>
                                    <a href="" class="btn btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="course/delete/{{ $value->course_id }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick='return confirm("Are you sure to delete course?")'>
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
