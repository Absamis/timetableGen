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
        <div class="col-md-3">
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
            <h4 class="font-weight-bold bg-dark text-white p-3">DEPARTMENTS</h4>
            <form class="" action="/timetable" method="post">
                @csrf
                <div class="form-group">
                    <label for="department">Department</label>
                    <select name="department" class="form-control">
                    @foreach ($department as $item)
                        <option value="{{ $item["name"] }}" @if ($filter == $item["name"])
                            selected
                        @endif>{{ $item["name"] }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-warning">
                        <i class="fas fa-table"></i> Generate
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-9">
            <h4 class="font-weight-bold bg-dark text-white p-3">Results</h4>
                <?php
                if(session('table')){ ?>
                <div class="table-wrap">
                <?php
                    $sem = array(1 => "1st", 2 => "2nd");
                    $department = session('department');
                    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
                    $table = json_decode(session('table'), true);
                    $levels = array("nd1", "nd2", "hnd1", "hnd2");
                    $time = json_decode(session('time'), true);
                    $timing = json_decode(session('class_no'), true);
                    $tabledata = session('tabledata');
                    foreach($levels as $level){
                    ?>
                    <h6 class="text-center">Timetable for {{ Str::upper($level) }} {{ $department }} {{ session('session_date') }} session {{ $sem[session('session_term')] }} semester</h6>
                    <table class="table table-bordered">
                        <thead>
                            <th>Days/Time</th>
                            <?php
                                $classno = $timing[$level]["no_class"];
                                $classinterval = $timing[$level]["interval"];
                                $start = 8;
                                for($a = 0; $a < $classno; $a++){
                                    ?>
                                    <th><?= $time[$start].'-'.$time[$start + $classinterval] ?></th>
                                    <?php
                                    $start = $start + $classinterval;
                                }
                            ?>
                        </thead>
                        <tbody>
                            <?php
                            $cnt = 0;
                            for($i = 0; $i < 5; $i++){
                                ?>
                                <tr>
                                <td class="font-weight-bold"><?= $days[$i] ?></td>
                                <?php
                                for($a = $cnt; $a < ($cnt + $timing[$level]["no_class"]); $a++){
                                    if(isset($table[$level][$a])){
                                        if($table[$level][$a] == '-'){
                                            echo '<td>-</td>';
                                        }
                                        else{
                                    ?>
                                <td>
                                    <span class="d-block text-center font-weight-bold">{{ Str::upper($table[$level][$a]["course_code"]) }}</span>
                                    <span class="d-block text-center text-capitalize">{{ $table[$level][$a]["lecturer"] }}</span>
                                    <span class="d-block text-center">{{ $table[$level][$a]["lecture_room"] }}</span>
                                </td>
                            <?php
                                        }
                                    }
                                    else
                                        echo '<td>-</td>';
                                }
                                $cnt = $cnt + $timing[$level]["no_class"];
                                ?>
                                </tr>
                                <?php
                            } ?>
                        </tbody>
                    </table>
                    <?php
                    } ?>
                    </div>
                    <div class="">
                        <form action="/timetable/save" method="post">
                            @csrf
                            <input type="hidden" value="{{ $department }}" name="department" />
                            <input type="hidden" value="{{ $tabledata }}" name="data" />
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </form>
                    </div>
                    <?php
                }
                ?>
        </div>
    </div>
</div>
@endsection
