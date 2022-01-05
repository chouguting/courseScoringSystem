<?php
    header("Content-Type: text/html; charset=utf-8");
    include('header.php');
    include_once "db_conn.php";
    session_start();
    $edit_mode = false;
    if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
        //echo 'user_id:'.$_SESSION["user_id"].'</br>';
        //echo 'username:'.$_SESSION["username"].'</br>';
    }
    $courseId = $_GET['course_id'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        error_reporting(E_ERROR | E_PARSE);
        if(array_key_exists('edit', $_POST)) {
            $edit_mode = true;
        }
        elseif(array_key_exists('view', $_POST)) {
            $course_id = $_POST['course_id'];
            $course_name = $_POST['course_name'];
            $department_name = $_POST['department_name'];
            $course_time = $_POST['course_time'];
            $course_location = $_POST['course_location'];
            $course_status = $_POST['course_status'];
            $instructor_name = $_POST['instructor_name'];
            $instructor_department = $_POST['instructor_department'];
            if(empty($course_id) or empty($course_name) or empty($department_name) or empty($course_time) or empty($course_location) or empty($instructor_name) or empty($instructor_department)){
                echo sprintf('<script>alert("警告：有空格沒填東西");location.href="courseInfo.php?course_id=%s"</script>',$courseId);
            }
            else{
                $query = "select * from department where department_name = ?";
                $department_check = $db->prepare($query);
                $department_check->execute(array($department_name));
                $query = "select * from instructor where instructor_name = ? and department_name = ?";
                $instructor_check = $db->prepare($query);
                $instructor_check->execute(array($instructor_name, $instructor_department));
                $instructor_result = $instructor_check->fetchAll();
                if($department_check->rowCount() == 0){
                    echo sprintf('<script>alert("警告：請輸入有效的學系名稱");location.href="courseInfo.php?course_id=%s"</script>',$courseId);
                }
                elseif($instructor_check->rowCount() == 0){
                    echo sprintf('<script>alert("警告：請輸入有效的教師姓名與教師所屬學系");location.href="courseInfo.php?course_id=%s"</script>',$courseId);
                }
                else{
                    $query = "update course set course_id = ?, course_name = ?, course_status = ?, instructor_id = ?, department_name = ?, course_location = ?, course_time = ? where course_id = ?";
                    $stmt = $db->prepare($query);
                    $stmt->execute(array($course_id, $course_name, (empty($course_status)? "off":"on"), $instructor_result[0]['instructor_id'], $department_name, $course_location, $course_time, $courseId));
                    $edit_mode = false;
                }
            }
        }
        else{
            $user_id = array_keys($_POST);
            $query = "delete from rating where user_id = ?";
            $stmt = $db->prepare($query);
            $stmt->execute(array(intval($user_id[0])));
            //$count = $stmt->rowCount();
            //header("Refresh:0");
            echo sprintf('<script type="text/JavaScript"> location.href="courseInfo.php?course_id=%s"; </script>',$courseId);
        }
    }
    $query = "select * from course where course_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($courseId));
    $result = $stmt->fetchAll();

    $query = "select * from instructor where instructor_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($result[0]['instructor_id']));
    $result_instructor = $stmt->fetchAll();

    $query = "select * from rating where course_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($courseId));
    $result_ratings = $stmt->fetchAll();
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick="location.href='course.php';">arrow_back
            </button>
            <?php
            echo '<span class="mdc-top-app-bar__title">'.$result[0]['course_name'].'</span>';
            ?>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        </section>
    </div>
</header>

<center>
    <br/>
    <br/>
    <br/>
    <h3> 課程資訊</h3>
    <form method="post">
        <table border='1' style='width:70%' >
            <tr>
                <th>課號</th>
                <th>課程名稱</th>
                <th>學系</th>
                <th>時間</th>
                <th>地點</th>
                <th>開課狀態</th>
            </tr>
            <?php

            for ($i = 0; $i < count($result); $i++) {
                echo "<tr>";
                if($edit_mode == true){
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="course_id" value="%s"/></td>', $result[$i]['course_id']);
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="course_name" value="%s"/></td>', $result[$i]['course_name']);
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="department_name" value="%s"/></td>', $result[$i]['department_name']);
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="course_time" value="%s"/></td>', $result[$i]['course_time']);
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="course_location" value="%s"/></td>', $result[$i]['course_location']);
                    echo sprintf('<td><div class="switch"><label><input type="checkbox" name="course_status" %s><span class="lever"></span></label></div></td>',$result[$i]['course_status'] == "on" ? "checked":"");
                }
                else{
                    echo "<td>" . $result[$i]['course_id'] . "</td>";
                    echo "<td>" . $result[$i]['course_name'] . "</td>";
                    echo "<td>" . $result[$i]['department_name'] . "</td>";
                    echo "<td>" . $result[$i]['course_time'] . "</td>";
                    echo "<td>" . $result[$i]['course_location'] . "</td>";
                    echo "<td>" . ($result[$i]['course_status'] == "on" ? "是":"否") . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <h3> 開課老師</h3>
        <table border='1' style='width:70%'>
            <tr>
                <th>教師姓名</th>
                <th>所屬學系</th>
            </tr>

            <?php

            for ($i = 0; $i < count($result_instructor); $i++) {
                echo "<tr>";
                if($edit_mode == true){
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="instructor_name" value="%s"/></td>', $result_instructor[$i]['instructor_name']);
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="instructor_department" value="%s"/></td>', $result_instructor[$i]['department_name']);
                }
                else {
                    echo "<td>" . $result_instructor[$i]['instructor_name'] . "</td>";
                    echo "<td>" . $result_instructor[$i]['department_name'] . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <h3> 評價</h3>
        <table border='1' style='width:70%'>
            <tr>
                <th>評分</th>
                <th>簡評</th>
                <th>評分時間</th>
                <?php
                    if($edit_mode == true)
                        echo '<th></th>';
                ?>
            </tr>

            <?php
            for ($i = 0; $i < count($result_ratings); $i++) {
                echo "<tr>";
                echo "<td>" . $result_ratings[$i]['rating'] . "</td>";
                echo "<td>" . $result_ratings[$i]['impression'] . "</td>";
                echo "<td>" . $result_ratings[$i]['rating_time'] . "</td>";
                if($edit_mode == true) {
                    echo sprintf('<td><button class="btn-floating btn-large waves-effect waves-light red" type="submit" name="%s">
                      <i class="material-icons">delete_forever</i>
                      </button></td>',$result_ratings[$i]['user_id']);
                }
                echo "</tr>";
            }
            ?>
        </table>
        <?php
        if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true) {
            if ($_SESSION["user_level"] == 's' ) {
                if($edit_mode == false){
                    echo '<div class="fixed-action-btn">
                  <button class="btn-floating btn-large waves-effect waves-light red" type="submit" name="edit">
                  <i class="material-icons">mode_edit</i>
                  </button>
                  </div>';
                }
                else{
                    echo '<div class="fixed-action-btn">
                  <button class="btn-floating btn-large waves-effect waves-light green" type="submit" name="view">
                  <i class="material-icons">check</i>
                  </button>
                  </div>';
                }
            }
        }
        ?>
    </form>
</center>

<?php
include('footer.php');
?>


