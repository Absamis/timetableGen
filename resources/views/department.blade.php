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
        <div class="col-md-5">
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
            <h4 class="font-weight-bold bg-dark text-white p-3">ADD DEPARTMENT</h4>
            <form class="" action="/department" method="post">
                @csrf
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" name="department" value="{{ old('department') }}" placeholder="Department">
                    @error('department')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-warning">
                        <i class="fas fa-plus"></i> Submit
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <h4 class="font-weight-bold bg-dark text-white p-3">ALL DEPARTMENTS</h4>
            <div class="table-wrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($department as $key => $value)
                            <tr>
                                <td>{{ $value["name"] }}</td>
                                <td>
                                    <form action="/department/delete/{{ $value["dept_id"] }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick='return confirm("Are you sure to delete department?")'>
                                            <i class="fas fa-trash"></i> Remove
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
@endsection
