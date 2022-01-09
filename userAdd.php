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
        
        $username = $_POST['username'];
        $display_name = $_POST['display_name'];
        $password = $_POST['password'];
        $user_level = $_POST['user_level'];
        
//        echo $username;
//        echo $display_name;
//        echo $password;
//        echo $user_level;
        
        if (empty($username) || empty($display_name) || empty($password) || empty($user_level)) {
            //$message = "Variable 'username' is empty.";
            echo "<script>alert('警告：有空格沒填東西');</script>";
        } else {
            $query = "insert into user values(?,?,?,?,?)";
           // $query = "INSERT INTO user (user_id, username, display_name, password, user_level) VALUES (?, ?, ?, ?)";
            //$query2 = "select instructor_id from instructor where instructor_name = ?";
            $stmt = $db->prepare($query);
            try {
                $stmt->execute(array(null, $username, $display_name, $password, $user_level));
                echo '<script>alert("新增成功");</script>';
            } catch (Exception $e) {
                echo '<script>alert("已經有人用了這個username");</script>';
                echo '<script>window.location.href="userAdd.php";</script>';
            }
            
        }
    }
?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="userManage.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">新增用戶</span>
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
                <input placeholder="輸入username" id="username" type="text" class="validate" name="username">
                <label for="username">用戶名稱</label>
            </div>
            
            <div class="input-field col s12">
                <input placeholder="輸入display name" id="display_name" type="text" class="validate" name="display_name">
                <label for="display_name">顯示名稱</label>
            </div>


            <div class="input-field col s12">
                <input placeholder="輸入用戶密碼" id="password" type="text" name="password" class="validate">
                <label for="password">用戶密碼</label>
            </div>


            <div class="row">
                <label for="user_level">用戶權限</label>
                <div class="row">
                    <p>
                        <label>
                            <input class="with-gap" name="user_level" type="radio" value="u" checked/>
                            <span>使用者</span>
                        </label>
                        <label>
                            <input class="with-gap" name="user_level" type="radio" value="s" />
                            <span>管理者</span>
                        </label>
                    </p>
                    <p>

                    </p>
                </div>

            </div>

            <input class=" btn waves-effect waves-light btn-small margin5 red lighten-3" type="submit"  name="submit" value="新增使用者">

        </form>
    </div>
    <br><br><br>






</center>



<?php
include 'footer.php';
?>
