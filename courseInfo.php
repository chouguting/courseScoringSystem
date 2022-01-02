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
    //echo $courseId;
    $query = "select * from course where course_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($courseId));
    $result = $stmt->fetchAll();
    if(count($result)>0){
        //echo 'success';
    }else{
        //echo 'fail';
    }

    $query2 = "select * from instructor where instructor_id = ?";
    $stmt2 = $db->prepare($query2);
    //echo $result[0]['instructor_id'];
    $stmt2->execute(array($result[0]['instructor_id']));
    $result_instructor = $stmt2->fetchAll();

    $query3 = "select * from rating where course_id = ?";
    $stmt3 = $db->prepare($query3);
    $stmt3->execute(array($courseId));
    $result_ratings = $stmt3->fetchAll();
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(array_key_exists('edit', $_POST)) {
        $_SESSION["edit_mode"] = true;
    }
    elseif(array_key_exists('view', $_POST)) {
        $_SESSION["edit_mode"] = false;
    }
    else{
        $user_id = array_keys($_POST);
        $query = "delete from rating where user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute(array(intval($user_id[0])));
        $count = $stmt->rowCount();
        //header("Refresh:0");
        echo sprintf('<script type="text/JavaScript"> location.href="courseInfo.php?course_id=%s"; </script>',$courseId);
    }
}

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
                if($_SESSION["edit_mode"] == true){
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
                if($_SESSION["edit_mode"] == true){
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="instructor_name" value="%s"/></td>', $result_instructor[$i]['instructor_name']);
                    echo sprintf('<td><input class="materialize-textarea" type="text" name="department_name" value="%s"/></td>', $result_instructor[$i]['department_name']);
                }
                else {
                    echo "<td>" . $result_instructor[$i]['instructor_name'] . "</td>";
                    echo "<td>" . $result_instructor[$i]['department_name'] . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </form>
    <form method="post">
        <br>
        <h3> 評價</h3>
        <table border='1' style='width:70%'>
            <tr>
                <th>評分</th>
                <th>簡評</th>
                <th>評分時間</th>
                <?php
                    if($_SESSION["edit_mode"] == true)
                        echo '<th></th>';
                ?>
            </tr>

            <?php
            for ($i = 0; $i < count($result_ratings); $i++) {
                echo "<tr>";
                echo "<td>" . $result_ratings[$i]['rating'] . "</td>";
                echo "<td>" . $result_ratings[$i]['impression'] . "</td>";
                echo "<td>" . $result_ratings[$i]['rating_time'] . "</td>";
                if($_SESSION["edit_mode"] == true) {
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
                if($_SESSION["edit_mode"] == false){
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


