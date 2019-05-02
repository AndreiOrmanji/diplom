<?php
require_once 'db.php';
$depts = R::getAll('SELECT dept_name, id FROM depts');
$users = R::getAll('SELECT email, id FROM users where dept_id is not null');

?>
<html>

<head>
    <title>Departments</title>
    <link rel="stylesheet" href="./libs/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
    <style>
    th {
        text-align: center !important;
    }

    td {
        text-align: center !important;
    }
    </style>
</head>

<body>
    <a>Departments</a>
    <?php
    #print_r($depts);
    if (empty($depts)) echo "No information about existing departments.";
    else {
        foreach ($depts as $dept) {
            $user = R::find('users', ' dept_id = ? ',  [$dept['id']]);
            #echo '<pre>'.print_r($user).'</pre>';
            echo '
                <div class="container">
                <details open>
                <summary> ' . $dept['dept_name'] . ' :</summary>
                <table class="table">    
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>E-mail</th>
                            <th>Admin</th>
                            <th>Head</th>
                        </tr>
                        </thead>
                        <tbody>';
            foreach ($user as $t) {
                switch ($t['is_head']) {
                    case '1': {
                            $head_mark = "&#10003;";
                            break;
                        }
                    default: {
                            $head_mark = "";
                            break;
                        }
                }
                switch ($t['is_admin']) {
                    case '1': {
                            $admin_mark = "&#10003;";
                            break;
                        }
                    default: {
                            $admin_mark = "";
                            break;
                        }
                }
                echo '<tr>
                            <td class="user_id">' . $t['id'] . '</td>
                            <td class="user_email">' . $t['email'] . '</td>
                            <td class="is_admin">' . $admin_mark . '</td>
                            <td class="is_head">' . $head_mark . '</td>
                          </tr>';
            }
        }
        echo        '</tbody>
                </table></div></details>';
    }
    ?>
    <div class="container">
        <div class="my-5 mx-auto text-center">
            <!--<button class="btn btn-dark btn-lg" data-toggle="modal" data-target="#exampleModal">Открыть модальное окно</button>-->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addDept">Add new
                department!</button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addDept" role="dialog">
        <!-- Modal-->
        <!--<div class="modal fade" id="addDept" tabindex="-1" role="dialog" aria-labelledby="addDeptLabel" aria-hidden="true" > -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDeptLabel">Add new department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="contactForm" action="./services/addDept" method="post">
                        <div class="form-group">
                            <label for="dept_name">Department name:</label>
                            <input id="dept_name" class="form-control" name="dept_name" type="text"
                                placeholder="Department name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="head">Head of department:</label>
                            <?php
                            if (empty($users)) {
                                echo '<span>No users registered...</span>';
                            } else {
                                echo '<select name="head_id">';
                                foreach ($users as $user) {
                                    echo '<option>' . $user['id'] . '| ' . $user['email'] . '</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                            <p>If needed user is not registered, go to <a href="./signup">Registration</a> page</p>
                        </div>

                        <button id="button" class="btn btn-success btn-block" name="submit" type="submit">Add new
                            department!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    // if ($_SESSION["email"]) {
    //     $autorized = '<li><a href="./user">User Settings</a></li>
    // 					<li><a href="./logout">Logout</a></li>';
    //     echo "Hello, " . $_SESSION["email"] . "!<br>";
    //     echo "If want to change your settings, go to <a href=\"./user\">User Settings page,</a>";
    //     echo "or you can <a href=\"./logout\">logout,</a> if you are done for today.";
    // } else {
    //     echo "Welcome, Guest. We are happy to see you here!";
    // }
    ?>
    <!-- 
    <ul>
        <li><a href="./tasks2">Tasks</a></li>
        <li><a href="./stats">Stats</a></li>
        <?php
        //echo "$autorized";
        ?>
    </ul>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    -->
    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="./libs/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>