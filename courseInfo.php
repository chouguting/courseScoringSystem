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
    $old_course_id = $_GET['course_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        error_reporting(E_ERROR | E_PARSE);
        if (array_key_exists('edit', $_POST)) {
            $edit_mode = true;
        }
        elseif (array_key_exists('view', $_POST)) {
            $course_id = $_POST['course_id'];
            $course_name = $_POST['course_name'];
            $department_name = $_POST['department_name'];
            $course_time = $_POST['course_time'];
            $course_location = $_POST['course_location'];
            $course_status = $_POST['course_status'];
            $instructor_name = $_POST['instructor_name'];
            $instructor_department = $_POST['instructor_department'];
            if(empty($course_id) or empty($course_name) or empty($department_name) or empty($course_time) or empty($course_location) or empty($instructor_name) or empty($instructor_department)){
                echo sprintf('<script>alert("警告：有空格沒填東西");location.href="courseInfo.php?course_id=%s"</script>',$old_course_id);
            }
            else{
                $query = "select * from instructor where instructor_name = ? and department_name = ?";
                $instructor_check = $db->prepare($query);
                $instructor_check->execute(array($instructor_name, $instructor_department));
                $instructor_result = $instructor_check->fetchAll();
                if($instructor_check->rowCount() == 0){
                    echo sprintf('<script>alert("警告：請輸入有效的教師姓名與教師所屬學系");location.href="courseInfo.php?course_id=%s"</script>',$old_course_id);
                }
                else{
                    $query = "update course set course_id = ?, course_name = ?, course_status = ?, instructor_id = ?, department_name = ?, course_location = ?, course_time = ? where course_id = ?";
                    $stmt = $db->prepare($query);
                    try{
                        $stmt->execute(array($course_id, $course_name, (empty($course_status)? "off":"on"), $instructor_result[0]['instructor_id'], $department_name, $course_location, $course_time, $old_course_id));
                        $query = "update rating set course_id = ? where course_id = ?";
                        $stmt = $db->prepare($query);
                        $stmt->execute(array($course_id, $old_course_id));
                        echo sprintf('<script>location.href="courseInfo.php?course_id=%s"</script>',$course_id);
                    }
                    catch (Exception $e){
                        echo sprintf('<script>alert("警告：查無此學系名稱\n%s");location.href="courseInfo.php?course_id=%s"</script>',$e->getMessage(), $old_course_id);
                    }

                }
            }
        }
        elseif (array_key_exists('send', $_POST)) {
            $rating = $_POST['rating'];
            $impression = $_POST['impression'];
            if(empty($rating)){
                echo '<script>alert("警告：評分不可為空");</script>';
            }
            else{
                $query = "insert into rating values(?,?,?,?,?)";
                $stmt = $db->prepare($query);
                $stmt->execute(array($rating, $impression, $old_course_id, $_SESSION['user_id'], null));
            }
        }
        else{
            $user_id = array_keys($_POST);
            $query = "delete from rating where user_id = ? and course_id = ?";
            $stmt = $db->prepare($query);
            $stmt->execute(array($user_id[8],$old_course_id));
            //$count = $stmt->rowCount();
            //header("Refresh:0");
            echo sprintf('<script type="text/JavaScript"> location.href="courseInfo.php?course_id=%s"; </script>',$old_course_id);
        }
    }
    $query = "select * from course where course_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($old_course_id));
    $result = $stmt->fetchAll();

    $query = "select * from instructor where instructor_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($result[0]['instructor_id']));
    $result_instructor = $stmt->fetchAll();

    $query = "select * from rating where course_id = ? order by rating_time desc";
    $stmt = $db->prepare($query);
    $stmt->execute(array($old_course_id));
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
    <h3 class="change-color-to-gray"> 課程資訊</h3>
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
        <h3 class="change-color-to-gray"> 開課老師</h3>
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
        <h3 class="change-color-to-gray"> 評價</h3>
        <table border='1' style='width:70%'>
            <thead>
                <tr>
                    <th>用戶名稱</th>
                    <th>評分</th>
                    <th>簡評</th>
                    <th>評分時間</th>
                    <?php
                        if($edit_mode == true)
                            echo '<th></th>';
                        if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"] == true && $_SESSION["user_level"] == 'u'){
                            echo '<th></th>';
                            $query = "select * from rating where user_id = ? and course_id = ?";
                            $stmt = $db->prepare($query);
                            $stmt->execute(array($_SESSION['user_id'], $old_course_id));
                            if($stmt->rowCount() == 0){
                                echo "<tr>";
                                echo "<td></td>";
                                echo '<td><div class="rating">
                                      <input type="radio" id="star5" name="rating" value="5" hidden/>
                                      <label for="star5"></label>
                                      <input type="radio" id="star4" name="rating" value="4" hidden/>
                                      <label for="star4"></label>
                                      <input type="radio" id="star3" name="rating" value="3" hidden/>
                                      <label for="star3"></label>
                                      <input type="radio" id="star2" name="rating" value="2" hidden/>
                                      <label for="star2"></label>
                                      <input type="radio" id="star1" name="rating" value="1" hidden/>
                                      <label for="star1"></label>
                                      </div></td>';
                                //echo '<td><input class="materialize-textarea" type="text" name="rating" value=""/></td>';
                                echo '<td><input class="materialize-textarea" type="text" name="impression" value=""/></td>';
                                echo '<td></td>';
                                echo '<td><button class="btn-floating btn-large waves-effect waves-light blue" type="submit" name="send">
                                      <i class="material-icons">send</i>
                                      </button></td>';
                            }
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    for ($i = 0; $i < count($result_ratings); $i++) {
                        $query = "select * from user where user_id = ?";
                        $stmt = $db->prepare($query);
                        $stmt->execute(array($result_ratings[$i]['user_id']));
                        $result = $stmt->fetchAll();
                        echo "<tr>";
                        echo "<td>" . $result[0]['username'] . "</td>";
                        echo sprintf('<td><div class="rating2">
                                      <input type="radio" value="5" hidden disabled %s/>
                                      <label></label>
                                      <input type="radio" value="4" hidden disabled %s/>
                                      <label></label>
                                      <input type="radio" value="3" hidden disabled %s/>
                                      <label></label>
                                      <input type="radio" value="2" hidden disabled %s/>
                                      <label></label>
                                      <input type="radio" value="1" hidden disabled %s/>
                                      <label></label>
                                      </div></td>',$result_ratings[$i]['rating']==5?"checked":"",$result_ratings[$i]['rating']==4?"checked":"",$result_ratings[$i]['rating']==3?"checked":"",$result_ratings[$i]['rating']==2?"checked":"",$result_ratings[$i]['rating']==1?"checked":"");
                        //echo "<td>" . $result_ratings[$i]['rating'] . "</td>";
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
            </tbody>
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


