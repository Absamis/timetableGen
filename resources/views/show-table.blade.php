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
    <div class="col-md-9 mx-auto">
            <?php
            if($data){ ?>
            <div class="table-wrap">
            <?php
                $info = json_decode($data, true);
                $sem = array(1 => "1st", 2 => "2nd");
                $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
                $table = json_decode($info["table"], true);
                $levels = array("nd1", "nd2", "hnd1", "hnd2");
                $time = json_decode($info["time"], true);
                $timing = json_decode($info["class_no"], true);
                // $tabledata = session('tabledata');
                foreach($levels as $level){
                ?>
                <h6 class="text-center">Timetable for {{ Str::upper($level) }} {{ $department }} {{ $session }} session {{ $sem[$semester] }} semester</h6>
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
                                <span class="d-block text-center">{{ $table[$level][$a]["lecturer"] }}</span>
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
                {{-- <div class="">
                    <form action="/timetable/save" method="post">
                        @csrf
                        <input type="hidden" value="{{ $department }}" name="department" />
                        <input type="hidden" value="{{ $tabledata }}" name="data" />
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </form>
                </div> --}}
                <?php
            }
            ?>
    </div>
</div>
@endsection
