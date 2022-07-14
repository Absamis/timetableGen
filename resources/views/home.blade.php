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
        <div class="col-md-4">
            <div class="">
                <h4 class="font-weight-bold bg-dark text-white p-3">SETTINGS</h4>
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
                <form class="" action="/session" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="session">Session</label>
                        <input type="text" class="form-control" name="session" value="{{ old('session') }}" placeholder="Session">
                        @error('session')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" class="form-control">
                            <option value="1" @if (old('semester') == '1')
                                selected
                            @endif>1st semester</option>
                            <option value="2" @if (old('semester') == '2')
                                selected
                            @endif>2nd semester</option>
                        </select>
                        @error('semester')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-md-8">
            <h4 class="font-weight-bold bg-dark text-white p-3">SAVED TABLES</h4>
            <div class="row mt-3">
                <?php $sem = array( 1=> "1st", 2 => "2nd");  ?>
                @foreach ($savedtable as $key => $value )
                <div class="col-md-6">
                    <a href="/timetable/show/{{ $value["item_id"] }}" class="d-block text-white">
                        <div class="car rounded bg-brown">
                            <div class="card-body d-flex align-items-center">
                                <span class="">
                                    <i class=" fas fa-table fa-2x"></i>
                                </span>
                                <h5 class="font-weight-bold fa-1x m-0 ml-3">{{ $value["department"]}} {{ $value["session"]}} {{ $sem[$value['semester']] }} semester Timetable</h5>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
