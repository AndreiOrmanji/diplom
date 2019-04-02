<?php
require_once 'db.php';
try{
    ob_start();
    if ( isset($_POST['submit']) ) {
        //echo '<pre>'.var_dump($_POST['submit']).'</pre>';
        $task = R::dispense ('tasks');
        $task->prName = (empty($_POST['prname']))?'Others tasks':$_POST['prname'];    //project name
        $task->tName = $_POST['tname'];                                         //task name
        $task->tDesc = $_POST['tdesc'];                                         //description
        $task->userId = $_SESSION['id'];                                        //user id
        $task->tCreated=time();                                                 //task created
        $task->tFinished=NULL;                                                  //task finished
        $task->tPaused=NULL;
        $task->timeCounted = 0;                                                 //time already counted

        if (isset($_POST['check'])) {
            $task->status = 1; //task is running
            $task->tResumed = time();
        }
        else{
            $task->status = 0; //task is stopped
            $task->tResumed = NULL;
        }
        R::store( $task );
        //echo '<meta http-equiv="Refresh" content="2; url=./tasks">';
        //echo '';
        header("Location: ./tasks");
        exit;
        // foreach($_POST as $key => $value){
        //     $_POST[$key]='';
        // }        
        //var_dump($task);
    }
}
catch(Exception $e){
    echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
    var_dump($task);
    echo "$e";
}

function time_counted($timeCounted)
{
    # code...
    //$current_time=time();
    return date("r", $timeCounted);
}

function time_resumed($tResumed)
{
    # code...
    //$current_time=time();
    if (($tResumed===NULL)|| ($tResumed===0)) {
        # code...
        return "Not started yet";
    } else {
        # code...
        return date("l jS \of F Y H:i:s", $tResumed);
    }
    
}

function secConvert($seconds) {
    $h = floor($seconds / 3600);
    $h = str_pad($h, 1, "0", STR_PAD_LEFT);
    $m = floor(($seconds / 60) % 60);
    $m = str_pad($m, 2, "0", STR_PAD_LEFT);
    $s = $seconds % 60;
    $s = str_pad($s, 2, "0", STR_PAD_LEFT);
    //return array($h, $m, $s);
    return $h.':'.$m.':'.$s;
    //
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tasks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
</head>

<body onload="init()">
    <a href="./">Main Page</a><br>
    <? if($_SESSION["email"]) : ?>
    <?="You are using, ". $_SESSION["email"] . " as your e-mail adress."; ?>
    <div class="container">
        <div class="my-5 mx-auto text-center">
            <!--<button class="btn btn-dark btn-lg" data-toggle="modal" data-target="#exampleModal">Открыть модальное окно</button>-->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModal">Open!</button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" role="dialog">
        <!-- Modal 
        <button name="stopButton'.$t["id"].'" type="button" class="btn btn-info btn-sm">Stop</button></td>-->
        <!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" > -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="contactForm" action="./tasks" method="post">
                        <div class="form-group">
                            <label for="prname">ProjectName:</label>
                            <input id="prname" class="form-control" name="prname" type="text" placeholder="Project name" value="">
                        </div>
                        <div class="form-group">
                            <label for="tname">Task:</label>
                            <input id="tname" class="form-control" name="tname" required type="text" placeholder="Task name" value="">
                        </div>
                        <div class="form-group">
                            <label for="tdesc">Task description:</label>
                            <textarea id="tdesc" class="form-control" name="tdesc" rows="4" placeholder="Optional" value=""></textarea>
                        </div>
                        <div class="form-group form-check">
                            <input id="check" class="form-check-input" name="check" type="checkbox">
                            <label class="form-check-label" for="check">Start tracking after creation.</label>
                        </div>
                        <button id="button" class="btn btn-success btn-block" name="submit" type="submit">Create task!</button>
                        <div class="result">
                            <span id="answer"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php 
    $zzz = time();
    echo "$zzz<br/>";
    echo date("H:i:s", time());
    $user_tasks = R::find( 'tasks', ' user_id = ? ',  [$_SESSION['id']]);
    if(empty($user_tasks)) echo "No tasks were created.";
        else{
            echo '<div class="container">
                    <h6>Current tasks of user @'.$_SESSION['email'].'</h6>
                    <table class="table">    
                        <thead>
                            <tr>
                                <th>Projectname</th>
                                <th>Taskname</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Time used</th>
                                <th>Time resumed</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($user_tasks as $t) {
                if ($t['status']==1) {
                    $status="Running";
                    $time_c=time_counted($t['tResumed'])+$t['time_counted'];
                }
                else{
                    $status="Stopped";
                    $time_c=$t['time_counted'];
                }//date("H:i:s", time()-$t['time_resume']).'</td>secConvert($zzz-$t['time_resume'])    date("d.m.Y H:i:s",$t['time_resume'])
                //.secConvert(time()-$t['time_resume'])[0].':'.secConvert(time()-$t['time_resume'])[1].':'.secConvert(time()-$t['time_resume'])[2].

                echo'<tr>
                    <td>'.$t['prName'].'</td>
                    <td>'.$t['tName'].'</td>
                    <td>'.$t['tDesc'].'</td>
                    <td class="tasks_status">'.$status.'</td> 
                    <td class="tasks_time" id="task_id_'.$t["id"].'">'.secConvert($t['timeCounted']).'</td>
                    <td>'.time_resumed($t['TResumed']).'</td>
                    <td><button name="startButton'.$t["id"].'" type="button" class="ctrl_btn btn btn-info btn-sm">Continue</button></td>
                    <td><button name="finishButton'.$t["id"].'" type="button" class="end_btn btn btn-info btn-sm">Finish</button></td>
                    </tr>';
            }
            echo        '</tbody>
                    </table>' ;
        }
        echo'<div>
                <button id="stopButton" name="stopButton" type="button" class="btn btn-danger btn-lg" style="display:none;" onclick="stopTasks();">Stop</button>
                <button name="stopResponseButton" type="button" class="btn btn-warning btn-lg" <!--onclick="stopIntervalResponse();"-->>Stop response</button></td></div>
            </div>';
    ?>
    <? else : ?>
    <?="You are not autorized. Go to <a href=\"./login\">Login Page.</a> ";?>
    </script>
    <? endif; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="./libs/jquery-3.3.1.min.js"></body\/script>')
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
    <!--
    function hmsToSec(hmsString) {
        // body...
        var q = hmsString.split(':'); // split it at the colons
        var seconds = (+q[0]) * 60 * 60 + (+q[1]) * 60 + (+q[2]);
    }

    function timer(string) {
        // body...
        //a[2] - sec
        //a[1] - min
        //a[0] - hrs
        //console.log(string);
        var a = string.split(':');
        //alert(a);
        a[2] = Number(a[2]);
        a[1] = Number(a[1]);
        a[0] = Number(a[0]);
        if (a[2] >= 59) {
            a[2] = 0;
            if (a[1] >= 59) {
                a[1] = 0;
                a[0]++;
            } else { a[1]++; }
        } else { a[2] += 1; }
        a[2] = ((a[2] < 10) ? "0" : "") + a[2];
        a[1] = ((a[1] < 10) ? "0" : "") + a[1];
        a[0] = (a[0] == 0) ? "0" : a[0];
        var b = a[0] + ":" + a[1] + ":" + a[2];
        return b;
    }

    let counters = [];
    let intervals = [];

    function init() {
        let ctrlBtns = document.getElementsByClassName("ctrl_btn");
        let timers = document.getElementsByClassName("tasks_time");
        for (let i = 0; i < ctrlBtns.length; i++) {
            ctrlBtns[i].addEventListener('click', () => {
                try {
                    if (ctrlBtns[i].innerHTML === "Continue") {
                        ctrlBtns[i].innerHTML = "Stop";

                        let status = document.getElementsByClassName('tasks_status');
                        status[i].innerHTML = "Running";
                    } else {
                        ctrlBtns[i].innerHTML = "Continue";
                        let status = document.getElementsByClassName('tasks_status');
                        status[i].innerHTML = "Stopped";
                    }
                } catch (e) {
                    console.log(e);
                }
            });
        }
    }
    var noActiveTasks = <?php if(empty($user_tasks)) echo "true"; else echo "false"; ?>


    var timeInterval = setInterval(() => {
        let status = document.getElementsByClassName('tasks_status');
        let timers = document.getElementsByClassName("tasks_time");
        let activeTasks = 0;
        for (var i = 0; i < status.length; i++) {
            if (status[i].innerHTML == "Running") {
                activeTasks++;
                timers[i].innerHTML = timer(timers[i].innerHTML);
            }
        }
        if ((activeTasks === 0) || (noActiveTasks)) {
            document.getElementById('stopButton').style.display = 'none';
        } else {
            document.getElementById('stopButton').style.display = 'inline';
        }
    }, 1000);
    // var responseInterval = setInterval(() => {
    // $.ajax({
    // method: "POST",
    // url: "services/timeTracker",
    // data: { name: "John", location: "Boston" }
    // })
    // .done(function(msg) {
    // console.log("Data Saved: " + msg);
    // });
    // }, 1000);

    function stopTasks() {
        let status = document.getElementsByClassName("tasks_status");
        let ctrlBtns = document.getElementsByClassName("ctrl_btn");
        for (i = 0; i < status.length; i++) {
            status[i].innerHTML = "Stopped";
            ctrlBtns[i].innerHTML = "Continue";
            //     if (ctrlBtns[i].classList.contains('btn-warning')){
            // ctrlBtns[i].classList.remove('btn-warning');
            // ctrlBtns[i].classList.add('btn-info');
            // }
        }
    }

    // function stopIntervalResponse() {
    //     // body...
    //     clearInterval(responseInterval);
    // }

    -->
    </script>
</body>

</html>