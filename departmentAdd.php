<?php
include('header.php');
include_once "db_conn.php";
session_start();
if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
    //echo 'user_id:'.$_SESSION["user_id"].'</br>';
    //echo 'username:'.$_SESSION["username"].'</br>';
    if($_SESSION['user_level']=='u'){
        echo '<script>alert("請先登入為管理者!");</script>';
        echo '<script>window.location.href="login.php";</script>';
    }
}else{
    echo '<script>alert("請先登入為管理者!");</script>';
    echo '<script>window.location.href="login.php";</script>';
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(E_ERROR | E_PARSE);

    
    $department_name = $_POST['department_name'];
    $department_website = $_POST['department_website'];

    if (empty($department_name)) {
        //$message = "Variable 'username' is empty.";
        echo "<script>alert('警告：學系名稱不能為空');</script>";
    } else {
        $query = "insert into department values(?,?,?)";
        // $query = "INSERT INTO user (user_id, username, display_name, password, user_level) VALUES (?, ?, ?, ?)";
        //$query2 = "select instructor_id from instructor where instructor_name = ?";
        $stmt = $db->prepare($query);
        try {
            $stmt->execute(array($department_name, $department_website, 0));
            echo '<script>alert("新增成功");</script>';
        } catch (Exception $e) {
            echo '<script>alert("新增出了點問題");</script>';
            echo '<script>window.location.href="departmentAdd.php";</script>';
        }

    }
}
?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="department.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">新增學系</span>
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

            <div class="input-field col s12">
                <input placeholder="輸入學系名稱" id="department_name" type="text" class="validate" name="department_name">
                <label for="department_name">學系名稱</label>
            </div>

            <div class="input-field col s12">
                <input placeholder="輸入學系的網站(url)" id="department_website" type="text" class="validate" name="department_website">
                <label for="department_website">學系網站</label>
            </div>

            <input class=" btn waves-effect waves-light btn-small margin5" type="submit"  name="submit" value="新增學系">

        </form>
    </div>
    <br><br><br>






</center>



<?php
include 'footer.php';
?>
