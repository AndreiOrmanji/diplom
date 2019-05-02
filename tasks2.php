<?php
require_once './db.php';

function current_time($tResumed)
{
    if (($tResumed === NULL) || ($tResumed === 0) || ($tResumed === "")) {
        return "-----";
    } else {
        return date("H:i:s d.m.Y", $tResumed);
    }
}

function secConvert($seconds)
{
    $h = floor($seconds / 3600);
    $h = str_pad($h, 1, "0", STR_PAD_LEFT);
    $m = floor(($seconds / 60) % 60);
    $m = str_pad($m, 2, "0", STR_PAD_LEFT);
    $s = $seconds % 60;
    $s = str_pad($s, 2, "0", STR_PAD_LEFT);
    return $h . ':' . $m . ':' . $s;
    //return array($h, $m, $s);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Projects and Tasks</title>
    <link rel="stylesheet" href="./libs/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
    <style>
    th {
        text-align: center !important;
    }
    </style>
</head>

<body>

    <a href="./">Main Page</a><br>
    <?php if ($_SESSION['email']) : ?>
    <?= "You are using, " . $_SESSION['email'] . " as your e-mail adress."; ?>
    <div class="container">
        <div class="my-5 mx-auto text-center">
            <!--<button class="btn btn-dark btn-lg" data-toggle="modal" data-target="#exampleModal">Открыть модальное окно</button>-->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModal">Create new
                task!</button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" role="dialog">
        <!-- Modal-->
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
                            <label for="prname">Project:</label>
                            <?php
                                $user_projects = R::findAll('projects');
                                if (empty($user_projects)) {
                                    echo 'No projects added...';
                                } else {
                                    echo '<select name="prname">
                                <option selected="selected">Choose from existing projects</option>';
                                    foreach ($user_projects as $project) {
                                        echo '<option>' . $project['id'] . '. ' . $project['pr_name'] . '</option>';
                                    }
                                    echo '</select>';
                                }
                                ?>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                                data-target="#addProject">Add new project!</button>
                        </div>
                        <div class="form-group">
                            <label for="tname">Task name:</label>
                            <input id="tname" class="form-control" name="tname" required type="text"
                                placeholder="Task name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="tdesc">Task description:</label>
                            <textarea id="tdesc" class="form-control" name="tdesc" rows="4" placeholder="Optional"
                                value=""></textarea>
                        </div>
                        <button id="button" class="btn btn-success btn-block" name="submit" type="submit">Create
                            task!</button>
                        <div class="result">
                            <span id="answer"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addClient" role="dialog">
        <!-- Modal-->
        <!--<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="addProjectLabel" aria-hidden="true" > -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientLabel">Add new client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="contactForm" action="./services/addClient" method="post">
                        <div class="form-group">
                            <label for="clientName">Client name:</label>
                            <input id="clientName" class="form-control" name="clientName" type="text"
                                placeholder="Client name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Client e-mail:</label>
                            <textarea id="email" class="form-control" name="email" rows="4" placeholder="Optional"
                                value=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Client phone number:</label>
                            <textarea id="phone" class="form-control" name="phone" rows="4" placeholder="Optional"
                                value=""></textarea>
                        </div>
                        <button id="button" class="btn btn-success btn-block" name="submit" type="submit">Add new
                            client!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container">
                <div class="my-5 mx-auto text-center">
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addProject">Add new project!</button>
                </div>
            </div> -->
    <!-- Modal -->
    <div class="modal fade" id="addProject" role="dialog">
        <!-- Modal 
                <button name="stopButton'.$t["id"].'" type="button" class="btn btn-info btn-sm">Stop</button></td>-->
        <!--<div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="addProjectLabel" aria-hidden="true" > -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectLabel">Add new project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="contactForm" action="./services/addProject" method="post">
                        <div class="form-group">
                            <label for="prname">ProjectName:</label>
                            <input id="prname" class="form-control" name="prname" type="text" placeholder="Project name"
                                value="" required>
                        </div>
                        <div class="form-group">
                            <label for="prdesc">Project description:</label>
                            <textarea id="prdesc" class="form-control" name="prdesc" rows="4" placeholder="Optional"
                                value=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="client">Client:</label>
                            <!-- <textarea id="client" class="form-control" name="client" rows="4" placeholder="Optional" value=""></textarea> -->
                            <?php
                            $clients = R::findAll('clients');
                                if (empty($clients)) {
                                    echo 'Add client (optional)';
                                } else {
                                    echo '<select name="client_name">
                                <option selected="selected">Choose client (Optional)</option>';
                                    foreach ($clients as $client) {
                                        echo '<option>' . $client['client_name'] . '</option>';
                                    }
                                    echo '</select>';
                                }
                                ?>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                                data-target="#addClient" data-dismiss="modal">Add new client!</button>
                        </div>
                        <button id="button" class="btn btn-success btn-block" name="submit" type="submit">Add new
                            project!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        $timeNow = time();
        echo '<div>Tracking starts at ' . date("H:i:s", time()) . '(' . time() . ')</div>';
        echo '<div>Current Time: <span id="current_time"></span></div>';

        if (empty($user_projects)) echo "No projects were assigned.";
        else {
            foreach ($user_projects as $project) {
                $user_tasks = R::find('tasks', ' user_id = ? AND project_id = ? ',  [$_SESSION['id'], $project["id"]]);
                echo '
                <div class="container">
                <details open>
                <summary> Tasks of ' . $project['pr_name'] . ' project:</summary>
                <table class="table">    
                        <thead>
                        <tr>
                        <th>TaskName</th>
                        <th>Description</th>
                            <th>Status</th>
                            <th>Time used</th>
                            <th>Resumed at:</th>
                            <th>Paused at:</th>
                            <th>Created at:</th>
                            <th>Finished at:</th>
                            <th>Control</th>
                        </tr>
                        </thead>
                        <tbody>';
                foreach (array_reverse($user_tasks) as $t) {
                    switch ($t['status']) {
                        case '1': {
                                $status = "Running";
                                $t['timeCounted'] = $t['timeCounted'] + ($timeNow - $t['tResumed']);
                                break;
                            }
                        case '0': {
                                $status = "Paused";
                                break;
                            }
                        default: {
                                $status = "Finished";
                                break;
                            }
                    }
                    echo '<tr>
                        <span class="task_id" style="display: none">' . $t['id'] . '</span>                        
                        <span class="project_id" style="display: none">' . $project['id'] . '</span>                        
                        <span class="project_name" style="display: none">' . $project['pr_name'] . '</span>
                        <td class="task_name" style="text-align: center;">' . $t['tName'] . '</td>
                        <td class="task_desc">' . $t['tDesc'] . '</td>
                        <td><span class="tasks_status" style="text-align: center;">' . $status . '</span><span class="status_code" style="display: none">' . $t['status'] . '</span></td> 
                        <td><span class="tasks_time" style="text-align: center;">' . secConvert($t['timeCounted']) . '</span><span class="time_counted_sec" style="display: none">' . $t['timeCounted'] . '</span></td>
                        <td class="task_resumed" style="text-align: center;"><span class="resumed_timestamp" style="display: none">' . $t['tResumed'] . '</span>' . current_time($t['tResumed']) . '</td>
                        <td class="task_paused" style="text-align: center;"><span class="paused_timestamp" style="display: none">' . $t['tPaused'] . '</span>' . current_time($t['tPaused']) . '</td>
                        <td class="task_created" style="text-align: center;"><span class="created_timestamp" style="display: none">' . $t['tCreated'] . '</span>' . current_time($t['tCreated']) . '</td>
                        <td class="task_finished" style="text-align: center;"><span class="finished_timestamp" style="display: none">' . $t['tFinished'] . '</span>' . current_time($t['tFinished']) . '</td>
                        <td>
                        ';
                    if ($status !== "Finished") {
                        echo '   <div class="btn-group">
                        <button name="startButton' . $t["id"] . '" type="button" class="ctrl_btn modify-btn btn btn-info btn-sm">Continue</button>
                        <button name="finishButton' . $t["id"] . '" type="button" class="end_btn modify-btn btn btn-secondary btn-sm">Finish</button>
                        </div>';
                    }
                    echo '
                    </td>
                    </tr>';
                }
                echo        '</tbody>
                </table></div></details>';
            }
        }
        ?>
    <?php else : ?>
    <?= "<p>You are not autorized. Go to <a href=\"./login\">Login Page.</a></p>"; ?>
    <?php endif; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="./libs/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
    var logs;
    window.onload = init();
    function currentTime(info) {

        let currentDate = new Date();
        let now = Date.now();
        let date = currentDate.getDate();
        if (date < 10) {
            date = '0' + date;
        }
        let month = currentDate.getMonth() + 1; //Be careful! January is 0 not 1
        if (month < 10) {
            month = '0' + month;
        }
        return '<span class="' + info + '" style="display: none">' + (((now - now % 1000) / 1000)) +
            "</span>" + currentDate.toTimeString().substring(0, 8) + " " + date + "." + month + "." + currentDate
            .getFullYear();
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
        let prName = document.getElementsByClassName("project_name");
        let projectId = document.getElementsByClassName("project_id");
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
                "id": id[index].innerHTML,
                "userId": '<?php echo $_SESSION['id'] ?>',
                "projectId": projectId[index].innerHTML,
                "prName": prName[index].innerHTML,
                "tName": tName[index].innerHTML,
                "tDesc": tDesc[index].innerHTML,
                "tCreated": tCreated[index].innerHTML,
                "tFinished": tFinished[index].innerHTML,
                "tPaused": tPaused[index].innerHTML,
                "timeCounted": timeCounted[index].innerHTML,
                "status": tStatus[index].innerHTML,
                "tResumed": tResumed[index].innerHTML
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
        //console.log(sendData);
        $.ajax({
                method: "POST",
                url: "services/timeTracker",
                data: {
                    data: sendData
                }
            })
            .done(function(msg) {
                console.log(msg);
            });
    }

    function createLog(id, newStatus) {
        let projectId = document.getElementsByClassName("project_id");
      //let prName = document.getElementsByClassName("project_name");
        let task_id = document.getElementsByClassName("task_id");
      //let tName = document.getElementsByClassName("task_name");
        let tDesc = document.getElementsByClassName("task_desc");
        let tStatus = document.getElementsByClassName('status_code');
        let timeCounted = document.getElementsByClassName("time_counted_sec");
        let timestamp;
        switch (newStatus) {
            case 'Running':
                {
                    let tResumed = document.getElementsByClassName("resumed_timestamp");
                    timestamp = tResumed[id].innerHTML;
                    break;
                }
            case 'Paused':
                {
                    let tPaused = document.getElementsByClassName("paused_timestamp");
                    timestamp = tPaused[id].innerHTML;
                    break;
                }
            case 'Finished':
                {
                    let tFinished = document.getElementsByClassName("finished_timestamp")
                    timestamp = tFinished[id].innerHTML;
                    break;
                }
        }

        let logRecord = {
            "user_id": '<?php echo $_SESSION['id'] ?>',
            "task_id": task_id[id].innerHTML,
            "project_id": projectId[id].innerHTML,
          //"prName": prName[id].innerHTML,
          //"tName": tName[id].innerHTML,
            "newStatus": newStatus,
            "timestamp": timestamp
        }
        console.log(logRecord);
        return logRecord;
    }


    function doSyncLog() {
        //let sendData = convertToSync();
        //console.log(sendData);
        //console.log(logs);
        $.ajax({
                method: "POST",
                url: "services/sync",
                data: {
                    data: logs
                }
            })
            .done(function(message) {
                console.log(message);
            });
    }

    function timer(string) {

        //a[0] - hrs, a[1] - min, a[2] - sec
        var a = string.split(':');
        a[2] = Number(a[2]);
        a[1] = Number(a[1]);
        a[0] = Number(a[0]);
        if (a[2] >= 59) {
            a[2] = 0;
            if (a[1] >= 59) {
                a[1] = 0;
                a[0]++;
            } else {
                a[1]++;
            }
        } else {
            a[2] += 1;
        }
        a[2] = ((a[2] < 10) ? "0" : '') + a[2];
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
                                    logs = createLog(j, 'Paused');
                                    doSyncLog();
                                }
                            }
                        }
                        //change status of other tasks to Paused and save timestamps
                        ctrlBtns[i].innerHTML = "Pause";
                        status[i].innerHTML = "Running";
                        tResumed[i].innerHTML = currentTime('resumed_timestamp');
                        convertStatus(i);
                        logs = createLog(i, 'Running');
                        doSyncLog();
                        //pause other active task, if active
                        // for (let i = 0; i < status.length; i++) {
                        //     if (status[i].innerHTML === "Running") {
                        //         ctrlBtns[i].innerHTML = "Pause";
                        //     }
                        // }
                    } else {
                        //change status of other tasks to Paused and save timestamps
                        ctrlBtns[i].innerHTML = 'Continue';
                        status[i].innerHTML = 'Paused';
                        convertStatus(i);
                        tPaused[i].innerHTML = currentTime("paused_timestamp");
                        logs = createLog(i, 'Paused');
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

                    logs = createLog(i, 'Finished');
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
                    //console.log(logs);
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
    </script>
</body>

</html>