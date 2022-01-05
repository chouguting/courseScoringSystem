<?php
include('header.php'); ?>
<?php
include_once "db_conn.php";
session_start();
if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
    if($_SESSION['user_level']=='u'){
        echo '<script>alert("請先登入為管理者!");</script>';
        echo '<script>window.location.href="login.php";</script>';
    }
    //echo 'user_id:'.$_SESSION["user_id"].'</br>';
    //echo 'username:'.$_SESSION["username"].'</br>';
}else{
    echo '<script>alert("請先登入為管理者!");</script>';
    echo '<script>window.location.href="login.php";</script>';
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(E_ERROR | E_PARSE);
    $course_id = $_POST['course_id'];

    $course_status = $_POST['course_status'];
    $course_name = $_POST['course_name'];
    $semester = $_POST['semester'];
    $instructor_name= $_POST['instructor_name'];
    $department_name = $_POST['department_name'];
    $course_time = $_POST['course_time'];
    $course_location = $_POST['course_location'];
    $query = "select instructor_id from instructor where instructor_name = ?";
    $stmt = $db->prepare($query);
    $stmt -> execute(array($instructor_name));
    $result = $stmt -> fetchAll();
    

    if (empty($course_id) || empty($course_name) || empty($semester) || empty($instructor_name) || empty($department_name) || empty($course_time) || empty($course_location)) {
        //$message = "Variable 'username' is empty.";
        echo "<script>alert('警告：有空格沒填東西');</script>";
    }elseif(empty($result)){
        echo '<script>alert("該授課教師不存在!");</script>';
        echo '<script>window.location.href="courseAdd.php";</script>';
    } else{
        if(empty($course_status)){
            $course_status = 'off';
        }

        $query2 = "insert into course (course_id, course_name , course_status , semester, instructor_id, department_name, course_location, course_time) values (?,?,?,?,?,?,?,?)";
        //$query2 = "select instructor_id from instructor where instructor_name = ?";
        $stmt2 = $db->prepare($query2);
        try {
            $stmt2 -> execute(array($course_id, $course_name, $course_status, $semester, $result[0]['instructor_id'], $department_name, $course_location, $course_time));
            echo '<script>alert("新增成功");</script>';
        }catch (Exception $e) {
            echo '<script>alert("沒有這個系所");</script>';
            echo '<script>window.location.href="courseAdd.php";</script>';
        }
        
    }

    //echo "<script>alert(strval(count($result)))</script>";
//    echo 'course_id:'.$course_id.'</br>';
//    echo 'course_status:'.$course_status.'</br>';
//    echo 'course_name:'.$course_name.'</br>';
//    echo 'semester:'.$semester.'</br>';
//    echo 'instructor_name:'.$instructor_name.'</br>';
//    echo 'department_name:'.$department_name.'</br>';
//    echo 'course_time:'.$course_time.'</br>';
//    echo 'course_location:'.$course_location.'</br>';
//    echo 'instructor_id:'.$result[0]['instructor_id'].'</br>';

    
    
   
    
}

?>


<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="course.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">新增課程</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        </section>
    </div>
</header>

<center>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="row">
        <form class="col s6 offset-s3" action="" method="post">

            <div class="input-field col s6">
                <input placeholder="輸入課程代號" id="course_id" type="text" class="validate" name="course_id">
                <label for="course_id">課號</label>
            </div>
            <div class="row">
                <label for="course_status">開課狀態</label>
                <div class="switch">
                    <label>
                        已不開課
                        <input type="checkbox" checked name="course_status">
                        <span class="lever"></span>
                        有開課
                    </label>
                </div>
            </div>
            <div class="input-field col s12">
                <input placeholder="輸入課程名稱" id="course_name" type="text" class="validate" name="course_name">
                <label for="course_name">課名</label>
            </div>
            
            
           
            
            <div class="row">
                <label for="semester">開課學期</label>
                    <div class="row">
                        <p>
                            <label>
                                <input class="with-gap" name="semester" type="radio" value="1"/>
                                <span>上學期</span>
                            </label>
                            <label>
                                <input class="with-gap" name="semester" type="radio" value="2" />
                                <span>下學期</span>
                            </label>
                        </p>
                        <p>
                            
                        </p>
                    </div>    

            </div>

            <div class="input-field col s12">
                <input placeholder="輸入老師的名字" id="instructor_name" type="text" name="instructor_name" class="validate">
                <label for="instructor_name">教師名稱</label>
            </div>

            <div class="input-field col s12">
                <input placeholder="輸入系所名稱" id="department_name" type="text" name="department_name" class="validate">
                <label for="department_name">開課系所</label>
            </div>

            <div class="input-field col s12">
                <input placeholder="輸入上課的節" id="course_time" type="text" name="course_time" class="validate">
                <label for="course_time">上課時間</label>
            </div>

            <div class="input-field col s12">
                <input placeholder="輸入上課的位置" id="course_location" name="course_location" type="text" class="validate">
                <label for="course_location">上課地點</label>
            </div>

            <input class=" btn waves-effect waves-light btn-small margin5" type="submit"  name="submit" value="新增課程">
           
        </form>
    </div>
    <br><br><br>






</center>

<?php
include('footer.php');
?>


