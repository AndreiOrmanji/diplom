<?php
require_once 'db.php';

function time_counted($timeCounted)
{
    # code...
    //$current_time=time();
    return date("r", $timeCounted);
}

function current_time($tResumed)
{
    # code...
    //$current_time=time();
    if (($tResumed===NULL)|| ($tResumed===0)) {
        # code...
        return "-----";
    } else {
        # code...
        return date("H:i:s d.m.Y", $tResumed);
    }
    
}

function secConvert($seconds) {
    $h = floor($seconds / 3600);
    $h = str_pad($h, 1, "0", STR_PAD_LEFT);
    $m = floor(($seconds / 60) % 60);
    $m = str_pad($m, 2, "0", STR_PAD_LEFT);
    $s = $seconds % 60;
    $s = str_pad($s, 2, "0", STR_PAD_LEFT);
    return $h.':'.$m.':'.$s;
    //return array($h, $m, $s);
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
    <?php ?>
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
                    <form id="contactForm" action="./services/addTask" method="post">
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
    //$zzz = time();
    echo time();
    echo '<div>Current Time:<span class="current_time"> '.date("H:i:s", time()).'</span></div>';
    $user_tasks = R::find( 'tasks', ' user_id = ? ',  [$_SESSION['id']]);
    if(empty($user_tasks)) echo "No tasks were created.";
        else{
            echo '<div class="container">
                    <h6>Current tasks of user <strong><i>'.$_SESSION['email'].',</i></strong></h6>
                    <table class="table">    
                        <thead>
                            <tr>
                                <th>Projectname</th>
                                <th>Taskname</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Time used</th>
                                <th>Time resumed</th>
                                <th>Time paused</th>
                                <th>Time finished</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($user_tasks as $t) {
                switch ($t['status']) {
                    case '1':
                        # code...
                        $status="Running";
                        break;
                    
                    case '0':
                        # code...
                        $status="Paused";
                        break;
                    default:
                        $status="Finished";
                        break;
                }
                //date("H:i:s", time()-$t['time_resume']).'</td>secConvert($zzz-$t['time_resume'])    date("d.m.Y H:i:s",$t['time_resume'])
                //.secConvert(time()-$t['time_resume'])[0].':'.secConvert(time()-$t['time_resume'])[1].':'.secConvert(time()-$t['time_resume'])[2].

                echo'<tr>
                    <td>'.$t['prName'].'</td>
                    <td>'.$t['tName'].'</td>
                    <td>'.$t['tDesc'].'</td>
                    <td class="tasks_status">'.$status.'</td> 
                    <td class="tasks_time">'.secConvert($t['timeCounted']).'</td>
                    <td class="task_resumed">'.current_time($t['tResumed']).'</td>
                    <td class="task_paused">'.current_time($t['tPaused']).'</td>
                    <td class="task_finished">'.current_time($t['tFinished']).'</td>
                    <td><div class="btn-group">
                        <button name="startButton'.$t["id"].'" type="button" class="ctrl_btn btn btn-info btn-sm">Continue</button>
                        <button name="finishButton'.$t["id"].'" type="button" class="end_btn btn btn-secondary btn-sm">Finish</button>
                    </div></td>
                    </tr>';
            }
            echo        '</tbody>
                    </table>' ;
        }
        // echo'<div>
        //         <button name="stopResponseButton" type="button" class="btn btn-warning btn-lg" 
        //         <!--onclick="stopIntervalResponse();"-->>Stop response</button></td>
        //     </div>';
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
    function currentTime() {
        // body...
        let currentDate = new Date();
        let date = currentDate.getDate();
        if (date < 10) { date = '0' + date; }
        let month = currentDate.getMonth() + 1; //Be careful! January is 0 not 1
        if (month < 10) { month = '0' + month; }
        return dateString = currentDate.toTimeString().substring(0, 8) + " " + date + "." + month + "." + currentDate.getFullYear();
    }

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
        let status = document.getElementsByClassName('tasks_status');
        for (var i = 0; i < status.length; i++) {
            if (status[i].innerHTML === "Running") {
                ctrlBtns[i].innerHTML = "Pause";
            }
        }
        for (let i = 0; i < ctrlBtns.length; i++) {
            ctrlBtns[i].addEventListener('click', () => {
                try {
                    let status = document.getElementsByClassName('tasks_status');
                    let tResumed = document.getElementsByClassName('task_resumed');
                    let tPaused = document.getElementsByClassName('task_paused');
                    if (ctrlBtns[i].innerHTML === "Continue") { //task is paused
                        for (let j = 0; j < status.length; j++) { //status review
                            if (i === j) continue; //if task to resume is chosen, skip it
                            else {
                                if (status[j].innerHTML !== 'Finished') { //else if status is not finished 
                                    status[j].innerHTML = 'Paused'; //change status of other tasks to Paused
                                    ctrlBtns[j].innerHTML = 'Continue';
                                }
                            }
                        }
                        ctrlBtns[i].innerHTML = "Pause";
                        status[i].innerHTML = "Running";
                        tResumed[i].innerHTML = currentTime();
                        for (let i = 0; i < status.length; i++) {
                            if (status[i].innerHTML === "Running") {
                                ctrlBtns[i].innerHTML = "Pause";
                            }
                        }

                    } else {
                        //clearInterval(timeInterval);
                        ctrlBtns[i].innerHTML = "Continue";
                        status[i].innerHTML = "Paused";
                        tPaused[i].innerHTML = currentTime();
                    }
                } catch (e) {
                    console.log(e);
                }
            });
        }
        let endBtns = document.getElementsByClassName("end_btn");
        for (let i = 0; i < endBtns.length; i++) {
            endBtns[i].addEventListener('click', () => {
                try {
                    let status = document.getElementsByClassName('tasks_status');
                    let ctrlBtns = document.getElementsByClassName("ctrl_btn");
                    let tFinished = document.getElementsByClassName('task_finished');
                    tFinished[i].innerHTML = currentTime();
                    status[i].innerHTML = "Finished";
                    endBtns[i].style.display = 'none';
                    ctrlBtns[i].style.display = 'none';
                } catch (e) {
                    console.log(e);
                }
            });
        }
    }
    //var noActiveTasks = <?php if(empty($user_tasks)) echo "true"; else echo "false"; ?>

    var timeInterval = setInterval(() => {
        let status = document.getElementsByClassName('tasks_status');
        let timers = document.getElementsByClassName("tasks_time");
        let ctrlBtns = document.getElementsByClassName("ctrl_btn");
        //let activeTasks = 0;

        for (var i = 0; i < status.length; i++) {
            if (status[i].innerHTML === "Running") {
                //activeTasks++;
                timers[i].innerHTML = timer(timers[i].innerHTML);

            }
        }
        // if ((activeTasks === 0) || (noActiveTasks)) {
        //     document.getElementById('pauseButton').style.display = 'none';
        // } else {
        //     document.getElementById('pauseButton').style.display = 'inline';
        // }
    }, 1000);

    var currentTimeInterval = setInterval(() => {
        let currentTime = document.getElementsByClassName("current_time");
        currentTime[0].innerHTML = timer(currentTime[0].innerHTML);
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

    function pauseTasks() {
        let status = document.getElementsByClassName("tasks_status");
        let ctrlBtns = document.getElementsByClassName("ctrl_btn");
        for (i = 0; i < status.length; i++) {
            status[i].innerHTML = "Paused";
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