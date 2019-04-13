<?php
require_once './db.php';

function returnDate($tResumed)
{
    if (($tResumed===NULL) || ($tResumed===0) || ($tResumed==="")) {       
        return "-----";
    } else {
        return date("d.m.Y", $tResumed);
    }
}

function returnTime($tResumed)
{
    if (($tResumed===NULL) || ($tResumed===0) || ($tResumed==="")) {       
        return "-----";
    } else {
        return date("H:i:s", $tResumed);
    }
}
 

function secConvert($seconds) {
    $h = floor($seconds / 3600);
    //$h = str_pad($h, 1, "0", STR_PAD_LEFT);
    $m = floor(($seconds / 60) % 60);
    $m = str_pad($m, 2, "0", STR_PAD_LEFT);
    $s = $seconds % 60;
    $s = str_pad($s, 2, "0", STR_PAD_LEFT);
    return $h.':'.$m.':'.$s;
    //return array($h, $m, $s);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Stats</title>
    <link rel="stylesheet" href="./libs/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
    <style>
    th {
        text-align: center!important;
    }
    </style>
</head>

<body>
    <a href="./">Main Page</a><br>
    <?php if($_SESSION['email']) : ?>
    <?="You are using, ". $_SESSION['email'] ." as your e-mail adress.";?>
    <div></div>
    <?php
    $timeNow = time();
    echo '<div>Tracking starts at '.date("H:i:s", time()).'('.time().')</div>';
    echo '<div>Current Time: <span id="current_time"></span></div>';
    $logs = R::find( 'logs', ' user_id = ? ',  [$_SESSION['id']]);
    //echo print_r($logs);
    if(empty($logs)) echo "No activity by ".$_SESSION['email'].".";
        else{
            $dateArray = R::getCol( 'SELECT DISTINCT date FROM logs;' );
            foreach ($dateArray as $logDate) {
                # code...
                
                echo '<div class="container">';
                echo 'Table for '.$logDate.'
                <h6>Current tasks of user <strong><i>'.$_SESSION['email'].'</i></strong></h6>
                <span id="userId" style="display:none;">'.$_SESSION['id'].'</span>
                <table class="table">    
                        <thead>
                        <tr>
                                <th>#</th>
                                <th>User_ID</th>
                                <th>UserName</th>
                                <th>ProjectName</th>
                                <th>TaskName</th>
                                <th>New status</th>
                                <th>Timestamp</th>
                                <th>Time</th>
                                <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>';
                        foreach (array_reverse($logs)as $log) {
                            if ($logDate===$log['date']){
                                echo'<tr>
                                <td class="log_id" style="text-align: center;">'.$log['id'].'</td>
                                <td class="log_user_id" style="text-align: center;">'.$_SESSION['id'].'</td>
                                <td class="username" style="text-align: center;">'.$_SESSION['email'].'</td>
                                <td class="log_pr_name" style="text-align: center;">'.$log['pr_name'].'</td> 
                                <td class="log_t_name" style="text-align: center;">'.$log['t_name'].'</td> 
                                <td class="log_new_status" style="text-align: center;">'.$log['new_status'].'</td>
                                <td class="log_timestamp" style="text-align: center;">'.$log['timestamp'].'</td>
                                <td class="log_time" style="text-align: center;">'.$log['time'].'</td>
                                <td class="log_date" style="text-align: center;">'.$log['date'].'</td>
                                </tr>';
                            }
                        }
                            echo        '</tbody>
                            </table>' ;
                    }
                }
                    ?>
            <?php else: ?>
    <?="You are not autorized. Go to <a href=\"./login\">Login Page.</a> ";?>
    <?php endif; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="./libs/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
    <!--
    window.onload = init();

    function currentTime(info) {
        
        let currentDate = new Date();
        let now = Date.now();
        let date = currentDate.getDate();
        if (date < 10) { date = '0' + date; }
        let month = currentDate.getMonth() + 1; //Be careful! January is 0 not 1
        if (month < 10) { month = '0' + month; }
        return '<span class="' + info + '" style="display: none">' + (((now - now % 1000) / 1000) - 1) + "</span>" + currentDate.toTimeString().substring(0, 8) + " " + date + "." + month + "." + currentDate.getFullYear();
    }

    function hmsToSec(hmsString) {
        
        var q = hmsString.split(':'); // split it at the colons
        return seconds = (+q[0]) * 60 * 60 + (+q[1]) * 60 + (+q[2]);
        
    }

    function timeToSec(i) {
        //counts time_used in secs for easy synchronization
        let timeCounted = document.getElementsByClassName('time_counted_sec');
        timeCounted[i].innerHTML = Number(timeCounted[i].innerHTML) + 1;
    }

    function convertToSync(index) {
        
        let id = document.getElementsByClassName("task_id");
        let userId = document.getElementById("userId");
        let prName = document.getElementsByClassName("project_name");
        let tName = document.getElementsByClassName("task_name");
        let tDesc = document.getElementsByClassName("task_desc");
        let tStatus = document.getElementsByClassName('status_code');
        let timeCounted = document.getElementsByClassName("time_counted_sec");
        let tCreated = document.getElementsByClassName("created_timestamp");
        let tFinished = document.getElementsByClassName("finished_timestamp")
        let tPaused = document.getElementsByClassName("paused_timestamp");
        let tResumed = document.getElementsByClassName("resumed_timestamp");
        let tasksData = [];
        for (let index = 0; index < tName.length; index++) {
            tasksData.push({
                "id" : id[index].innerHTML,
                "userId" : userId.innerHTML,
                "prName" : prName[index].innerHTML,
                "tName" : tName[index].innerHTML,
                "tDesc" : tDesc[index].innerHTML,
                "tCreated" : tCreated[index].innerHTML,
                "tFinished" : tFinished[index].innerHTML,
                "tPaused" : tPaused[index].innerHTML,
                "timeCounted" : timeCounted[index].innerHTML,
                "status" : tStatus[index].innerHTML,    
                "tResumed" : tResumed[index].innerHTML
            });
        }
        return tasksData;
    }

    function convertStatus(i) {
        
        let statusMark = document.getElementsByClassName('tasks_status');
        let statusCode = document.getElementsByClassName('status_code');
        switch (statusMark[i].innerHTML) {
            case 'Running':
                {
                    statusCode[i].innerHTML = 1;
                    break;
                }
            case 'Paused':
                {
                    statusCode[i].innerHTML = 0;
                    break;
                }
            case 'Finished':
                {
                    statusCode[i].innerHTML = 2;
                    break;
                }
        }
    }

    function doSync() {
        let sendData = convertToSync();
        $.ajax({
                method: "POST",
                url: "services/timeTracker",
                data: { data: sendData }
            })
            .done(function(msg) {
                console.log(msg);
        });
        // $.ajax({
        //         method: "POST",
        //         url: "services/sync",
        //         data: { data: logs }
        //     })
        //     .done(function(message) {
        //         console.log(message);
        // });
        
    }

    function createLog(id, newStatus){
        let task_id = document.getElementsByClassName("task_id");
        let user_id = document.getElementById("userId");
        let prName = document.getElementsByClassName("project_name");
        let tName = document.getElementsByClassName("task_name");
        let tDesc = document.getElementsByClassName("task_desc");
        let tStatus = document.getElementsByClassName('status_code');
        let timeCounted = document.getElementsByClassName("time_counted_sec");

        let tCreated = document.getElementsByClassName("created_timestamp");
        let tFinished = document.getElementsByClassName("finished_timestamp")
        let tPaused = document.getElementsByClassName("paused_timestamp");
        let tResumed = document.getElementsByClassName("resumed_timestamp");
        let timestamp;
        switch (newStatus) {
            case 'Running':
                {
                    timestamp = tResumed[id].innerHTML;
                    break;
                }
            case 'Paused':
                {
                    timestamp = tPaused[id].innerHTML;
                    break;
                }
            case 'Finished':
                {
                    timestamp = tFinished[id].innerHTML;
                    break;
                }
        }
        
        let logRecord = {
                "user_id" : user_id.innerHTML,
                "task_id" : task_id[id].innerHTML,
                "prName" : prName[id].innerHTML,
                "tName" : tName[id].innerHTML,
                "newStatus" : newStatus,    
                "timestamp" : timestamp
            }
        return logRecord;
    }

    var logs = [];
    function doSyncLog() {
        //let sendData = convertToSync();
        //console.log(sendData);
        $.ajax({
                method: "POST",
                url: "services/sync",
                data: { data: logs }
            })
            .done(function(message) {
                console.log(message);
        });
    }

    function timer(string) {
        
        //a[2] - sec
        //a[1] - min
        //a[0] - hrs
        var a = string.split(':');
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
        return a[0] + ":" + a[1] + ":" + a[2];
    }

    function init() {
        let ctrlBtns = document.getElementsByClassName('ctrl_btn');
        let status = document.getElementsByClassName('tasks_status');
        //change button label for Start/Pause button from Continue to Pause if task is running
        for (let i = 0; i < status.length; i++) {
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
                    //if task is paused
                    if (ctrlBtns[i].innerHTML === "Continue") {
                        //status review
                        for (let j = 0; j < status.length; j++) {
                            //if task to resume is chosen, skip it
                            if (i === j) continue;
                            else {
                                //else if status is not finished 
                                if (status[j].innerHTML === 'Running') {
                                    //change status of other tasks to Paused and save timestamps
                                    tPaused[j].innerHTML = currentTime('paused_timestamp');
                                    status[j].innerHTML = 'Paused';
                                    ctrlBtns[j].innerHTML = 'Continue';
                                    convertStatus(j);
                                    logs = createLog(j,'Paused');
                                    doSyncLog();
                                }
                            }
                        }
                        //change status of other tasks to Paused and save timestamps
                        ctrlBtns[i].innerHTML = "Pause";
                        status[i].innerHTML = "Running";
                        tResumed[i].innerHTML = currentTime('resumed_timestamp');
                        convertStatus(i);
                        logs = createLog(i,'Running');
                        doSyncLog();
                        //pause other active task, if active
                        // for (let i = 0; i < status.length; i++) {
                        //     if (status[i].innerHTML === "Running") {
                        //         ctrlBtns[i].innerHTML = "Pause";
                        //     }
                        // }
                        //********************************
                        //*СПОРНЫЙ МОМЕНТ ЦИКЛ стр351-355*
                        //********************************
                    } else {
                        //change status of other tasks to Paused and save timestamps
                        ctrlBtns[i].innerHTML = 'Continue';
                        status[i].innerHTML = 'Paused';
                        convertStatus(i);
                        tPaused[i].innerHTML = currentTime("paused_timestamp");

                        logs = createLog(i,'Paused');
                        doSyncLog();
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
                    //change status  to Finished and save timestamps
                    tFinished[i].innerHTML = currentTime("finished_timestamp");
                    status[i].innerHTML = 'Finished';
                    convertStatus(i);
                    
                    logs = createLog(i,'Finished');
                    doSyncLog();

                    endBtns[i].style.display = 'none';
                    ctrlBtns[i].style.display = 'none';

                } catch (e) {
                    console.log(e);
                }
            });
        }

        try {
            let sButton = document.getElementsByClassName('modify-btn');
            for (let c = 0; c < sButton.length; c++) {
                sButton[c].addEventListener('click', () => {
                    //synchronization code...
                    // console.log('listener ' + c + ' created');
                    // console.log(sButton[c].innerHTML + " " + c);
                    //let s = (c - c % 2) / 2;
                    //convertStatus((c - c % 2) / 2);
                    //convertToSync();
                    let sendData = convertToSync();
                    //console.log(sendData);
                    console.log(logs);
                    doSync();
                    //doSyncLog();
                });
            }
            // window.addEventListener('unload', function(event) {
            //     doSync();
            // });
        } catch (e) {
            console.log(e);
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
                timeToSec(i);
            }
        }
        // if ((activeTasks === 0) || (noActiveTasks)) {
        //     document.getElementById('pauseButton').style.display = 'none';
        // } else {
        //     document.getElementById('pauseButton').style.display = 'inline';
        // }
    }, 1000);

    var currentTimeInterval = setInterval(() => {
        let systemTime = document.getElementById('current_time');
        systemTime.innerHTML = currentTime("systemTime");

    }, 1000);

    function pauseTasks() {
        let status = document.getElementsByClassName("tasks_status");
        let ctrlBtns = document.getElementsByClassName("ctrl_btn");
        for (i = 0; i < status.length; i++) {
            status[i].innerHTML = "Paused";
            convertStatus(i);
            ctrlBtns[i].innerHTML = "Continue";
            //     if (ctrlBtns[i].classList.contains('btn-warning')){
            // ctrlBtns[i].classList.remove('btn-warning');
            // ctrlBtns[i].classList.add('btn-info');
            // }
        }
    }
    -->
    </script>
</body>

</html>                        