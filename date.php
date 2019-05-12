<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./libs/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>GraphTest1</title>
    <script src="./libs/Chart.min.js"></script>
    <!-- link rel="stylesheet" type="text/css" href="./css/style.css"-->
    <link rel="stylesheet" type="text/css" href="./css/layout.css" />
    <link rel="stylesheet" type="text/css" href="./css/datepicker.css" />
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./js/datepicker.js"></script>
    <script type="text/javascript" src="./js/eye.js"></script>
    <script type="text/javascript" src="./js/utils.js"></script>
    <script type="text/javascript" src="./js/layout.js"></script>
    <style>
    th {
        text-align: center !important;
    }

    #pie-chart-all-tasks,
    #pie-chart-all-projects,
    #bar-chart-by-week,
    #bar-chart-by-pauses {
        width: 790px;
        height: 470px;
    }
    </style>
</head>

<body>
    <a href="./">Main Page</a><br>
    <div class="container">You are using andrew_ormanzhi@mail.ru as your e-mail adress.</div>
    <div class="container">Tracking starts at 18:42:37(1557502957)</div>
    <div>Current Time: <span id="current_time"></span></div>
    <div class="container">
        <details>
            <summary>Tables for andrew_ormanzhi@mail.ru</summary>
            <details>
                <summary>Table for 2019-04-29</summary>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User_ID</th>
                            <th>UserName</th>
                            <th>ProjectName</th>
                            <th>TaskName</th>
                            <th>New status</th>
                            <th>Time</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">1st task</td>
                            <td class="log_new_status" style="text-align: center;">Running</td>
                            <td class="log_time" style="text-align: center;">00:59:28</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">1st task</td>
                            <td class="log_new_status" style="text-align: center;">Paused</td>
                            <td class="log_time" style="text-align: center;">00:59:38</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">2ndTask</td>
                            <td class="log_new_status" style="text-align: center;">Running</td>
                            <td class="log_time" style="text-align: center;">01:00:10</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">2ndTask</td>
                            <td class="log_new_status" style="text-align: center;">Paused</td>
                            <td class="log_time" style="text-align: center;">01:00:21</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">1st task</td>
                            <td class="log_new_status" style="text-align: center;">Running</td>
                            <td class="log_time" style="text-align: center;">03:06:50</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">1st task</td>
                            <td class="log_new_status" style="text-align: center;">Paused</td>
                            <td class="log_time" style="text-align: center;">03:07:43</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">2ndTask</td>
                            <td class="log_new_status" style="text-align: center;">Running</td>
                            <td class="log_time" style="text-align: center;">14:11:52</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                            <td class="log_t_name" style="text-align: center;">2ndTask</td>
                            <td class="log_new_status" style="text-align: center;">Paused</td>
                            <td class="log_time" style="text-align: center;">14:13:02</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Test Project</td>
                            <td class="log_t_name" style="text-align: center;">1stCreatedTask</td>
                            <td class="log_new_status" style="text-align: center;">Running</td>
                            <td class="log_time" style="text-align: center;">01:01:34</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Test Project</td>
                            <td class="log_t_name" style="text-align: center;">1stCreatedTask</td>
                            <td class="log_new_status" style="text-align: center;">Paused</td>
                            <td class="log_time" style="text-align: center;">03:06:50</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Test Project</td>
                            <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                            <td class="log_new_status" style="text-align: center;">Created</td>
                            <td class="log_time" style="text-align: center;">17:18:29</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Test Project</td>
                            <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                            <td class="log_new_status" style="text-align: center;">Running</td>
                            <td class="log_time" style="text-align: center;">17:36:08</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                        <tr>
                            <td class="log_id" style="text-align: center;"></td>
                            <td class="log_user_id" style="text-align: center;">1</td>
                            <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                            <td class="log_pr_name" style="text-align: center;">Test Project</td>
                            <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                            <td class="log_new_status" style="text-align: center;">Paused</td>
                            <td class="log_time" style="text-align: center;">17:38:20</td>
                            <td class="log_date" style="text-align: center;">2019-04-29</td>
                        </tr>
                    </tbody>
                </table>
    </div>
    </details>
    <details>
        <summary>Table for 2019-04-30</summary>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User_ID</th>
                    <th>UserName</th>
                    <th>ProjectName</th>
                    <th>TaskName</th>
                    <th>New status</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                    <td class="log_t_name" style="text-align: center;">2ndTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">11:25:22</td>
                    <td class="log_date" style="text-align: center;">2019-04-30</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                    <td class="log_t_name" style="text-align: center;">2ndTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">12:00:43</td>
                    <td class="log_date" style="text-align: center;">2019-04-30</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                    <td class="log_t_name" style="text-align: center;">1st task</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">12:15:36</td>
                    <td class="log_date" style="text-align: center;">2019-04-30</td>
                </tr>
            </tbody>
        </table>
        </div>
    </details>
    <details>
        <summary>Table for 2019-05-04</summary>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User_ID</th>
                    <th>UserName</th>
                    <th>ProjectName</th>
                    <th>TaskName</th>
                    <th>New status</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                    <td class="log_t_name" style="text-align: center;">1st task</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">10:43:57</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                    <td class="log_t_name" style="text-align: center;">2ndTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">11:00:17</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Others tasks</td>
                    <td class="log_t_name" style="text-align: center;">2ndTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">21:42:10</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">10:45:03</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">10:45:33</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">21:50:42</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">22:03:42</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">22:09:23</td>
                    <td class="log_date" style="text-align: center;">2019-05-04</td>
                </tr>
            </tbody>
        </table>
        </div>
    </details>
    <details>
        <summary>Table for 2019-05-05</summary>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User_ID</th>
                    <th>UserName</th>
                    <th>ProjectName</th>
                    <th>TaskName</th>
                    <th>New status</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">00:34:10</td>
                    <td class="log_date" style="text-align: center;">2019-05-05</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">00:35:04</td>
                    <td class="log_date" style="text-align: center;">2019-05-05</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">00:37:33</td>
                    <td class="log_date" style="text-align: center;">2019-05-05</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">19:26:15</td>
                    <td class="log_date" style="text-align: center;">2019-05-05</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">2ndCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">23:21:26</td>
                    <td class="log_date" style="text-align: center;">2019-05-05</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">1stCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">23:33:58</td>
                    <td class="log_date" style="text-align: center;">2019-05-05</td>
                </tr>
            </tbody>
        </table>
        </div>
    </details>
    <details>
        <summary>Table for 2019-05-06</summary>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User_ID</th>
                    <th>UserName</th>
                    <th>ProjectName</th>
                    <th>TaskName</th>
                    <th>New status</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Created</td>
                    <td class="log_time" style="text-align: center;">18:01:37</td>
                    <td class="log_date" style="text-align: center;">2019-05-06</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Test Project</td>
                    <td class="log_t_name" style="text-align: center;">1stCreatedTask</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">14:47:30</td>
                    <td class="log_date" style="text-align: center;">2019-05-06</td>
                </tr>
            </tbody>
        </table>
        </div>
    </details>
    <details>
        <summary>Table for 2019-05-09</summary>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User_ID</th>
                    <th>UserName</th>
                    <th>ProjectName</th>
                    <th>TaskName</th>
                    <th>New status</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">16:55:05</td>
                    <td class="log_date" style="text-align: center;">2019-05-09</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">17:05:07</td>
                    <td class="log_date" style="text-align: center;">2019-05-09</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">17:05:49</td>
                    <td class="log_date" style="text-align: center;">2019-05-09</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">21:41:39</td>
                    <td class="log_date" style="text-align: center;">2019-05-09</td>
                </tr>
            </tbody>
        </table>
        </div>
    </details>
    <details>
        <summary>Table for 2019-05-10</summary>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User_ID</th>
                    <th>UserName</th>
                    <th>ProjectName</th>
                    <th>TaskName</th>
                    <th>New status</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">00:40:59</td>
                    <td class="log_date" style="text-align: center;">2019-05-10</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Paused</td>
                    <td class="log_time" style="text-align: center;">00:41:01</td>
                    <td class="log_date" style="text-align: center;">2019-05-10</td>
                </tr>
                <tr>
                    <td class="log_id" style="text-align: center;"></td>
                    <td class="log_user_id" style="text-align: center;">1</td>
                    <td class="username" style="text-align: center;">andrew_ormanzhi@mail.ru</td>
                    <td class="log_pr_name" style="text-align: center;">Diplom</td>
                    <td class="log_t_name" style="text-align: center;">prepare</td>
                    <td class="log_new_status" style="text-align: center;">Running</td>
                    <td class="log_time" style="text-align: center;">17:04:40</td>
                    <td class="log_date" style="text-align: center;">2019-05-10</td>
                </tr>
            </tbody>
        </table>
        </div>
    </details>
    </details>
    <div class="container-fluid">
        <div class='row'>
            <div class='col-md-7'>
                <div id="pie-chart-all-tasks">
                </div>
            </div>
            <div class='col-md-7s'>
                <div id="pie-chart-all-projects">
                </div>
            </div>

            <div class='col-md-6'>
                <div id="bar-chart-by-week">
                </div>
            </div>

            <div class='col-md-6'>
                <div id="bar-chart-by-pauses">
                </div>
            </div>
        </div>
    </div>
    <!-- Resources -->
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="./libs/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("pie-chart-all-tasks", am4charts.PieChart);

        // Add data
        chart.data = [{
                "tasks": "Others tasks / 1st task",
                "seconds": 340164
            },
            {
                "tasks": "Others tasks / 2ndTask",
                "seconds": 62328
            },
            {
                "tasks": "Test Project / 1stCreatedTask",
                "seconds": 40715
            },
            {
                "tasks": "Test Project / 2ndCreatedTask",
                "seconds": 23889
            },
            {
                "tasks": "Diplom / prepare",
                "seconds": 17154
            }
        ];
        //Legend
        //chart.legend = new am4charts.Legend();
        //title
        // var title = chart.titles.create();
        // title.text = "All tasks stats";
        // title.fontSize = 25;
        // title.marginTop = 3;

        // Add bottom label

        // Set inner radius
        chart.innerRadius = am4core.percent(50);

        // Force global duration format
        chart.durationFormatter.durationFormat = "hh ':' mm '  "; //:' ss  ";

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "seconds"; //values
        pieSeries.dataFields.category = "tasks"; //labels
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template.tooltipText = "{category}: {value.formatDuration()}";

        pieSeries.labels.template.text =
            "[font-style: italic]{category}:\n [bold]{value.percent.formatNumber('###.00')}%";

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

        var title = chart.titles.create();
        title.text = "All tasks stats";
        title.fontSize = 25;
    }); // end am4core.ready()
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("pie-chart-all-projects", am4charts.PieChart);

        // Add data
        chart.data = [{
                "projects": "Others tasks",
                "seconds": 380879
            },
            {
                "projects": "Test Project",
                "seconds": 86217
            },
            {
                "projects": "Diplom",
                "seconds": 17154
            }
        ];
        chart.legend = new am4charts.Legend();
        // Set inner radius
        chart.innerRadius = am4core.percent(50);

        // Force global duration format
        chart.durationFormatter.durationFormat = "hh ':' mm '  "; //:' ss  ";

        var title = chart.titles.create();
        title.text = "All projects stats";
        title.fontSize = 25;


        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "seconds"; //values
        pieSeries.dataFields.category = "projects"; //labels
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template.tooltipText = "{category}: {value.formatDuration()}";

        pieSeries.labels.template.text =
            "[font-style: italic]{category}:\n [bold]{value.percent.formatNumber('###.00')}%";

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
    });
    am4core.ready(function() {

        var chart = am4core.create("bar-chart-by-week", am4charts.XYChart);

        // Add data
        chart.data = [{
                "days": "Понедельник",
                "seconds": 0
            },
            {
                "days": "Вторник",
                "seconds": 0
            },
            {
                "days": "Среда",
                "seconds": 0
            },
            {
                "days": "Четверг",
                "seconds": 17152
            },
            {
                "days": "Пятница",
                "seconds": 2
            },
            {
                "days": "Суббота",
                "seconds": 0
            },
            {
                "days": "Воскресение",
                "seconds": 0
            }
        ];
        var title = chart.titles.create();
        title.text = "Worktime";
        title.fontSize = 25;
        title.marginBottom = 10;
        // Create axes
        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "days";
        xAxis.renderer.grid.template.location = 0;
        xAxis.renderer.minGridDistance = 30;

        var yAxis = chart.yAxes.push(new am4charts.DurationAxis());
        yAxis.baseUnit = "second";
        yAxis.title.text = "Time used";

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "seconds";
        series.dataFields.categoryX = "days";
        series.columns.template.tooltipText = "{categoryX}: {valueY.formatDuration()}";

        var bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.label.text = "{valueY.formatDuration()}";
        bullet.label.verticalCenter = "bottom";
        //bullet.label.dy = -10;
        //bullet.label.fontSize = 20;
        chart.durationFormatter.durationFormat = "hh ':' mm '  "; //:' ss  ";

        chart.maskBullets = false;

        // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
        series.columns.template.adapter.add("fill", (fill, target) => {
            return chart.colors.getIndex(target.dataItem.index * 2);
        });
    });
    am4core.ready(function() {

        var chart = am4core.create("bar-chart-by-pauses", am4charts.XYChart);

        // Add data
        chart.data = [{
                "days": "2019-04-29",
                "seconds": 52140
            },
            {
                "days": "2019-04-30",
                "seconds": 893
            },
            {
                "days": "2019-05-04",
                "seconds": 1803
            },
            {
                "days": "2019-05-05",
                "seconds": 68528
            },
            {
                "days": "2019-05-06",
                "seconds": 0
            },
            {
                "days": "2019-05-09",
                "seconds": 42
            },
            {
                "days": "2019-05-10",
                "seconds": 59019
            }
        ];
        var title = chart.titles.create();
        title.text = "Unused time";
        title.fontSize = 25;
        title.marginBottom = 10;
        // Create axes
        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "days";
        xAxis.renderer.grid.template.location = 0;
        xAxis.renderer.minGridDistance = 30;

        var yAxis = chart.yAxes.push(new am4charts.DurationAxis());
        yAxis.baseUnit = "second";
        yAxis.title.text = "Time used";

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "seconds";
        series.dataFields.categoryX = "days";
        series.columns.template.tooltipText = "{categoryX}: {valueY.formatDuration()}";
        chart.durationFormatter.durationFormat = "hh ':' mm '  "; //:' ss  ";
        var bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.label.text = "{valueY.formatDuration()}";
        bullet.label.verticalCenter = "bottom";
        //bullet.label.dy = -10;
        //bullet.label.fontSize = 20;

        chart.maskBullets = false;

        // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
        series.columns.template.adapter.add("fill", (fill, target) => {
            return chart.colors.getIndex(target.dataItem.index * 2);
        });
    });
    </script>
</body>

</html>