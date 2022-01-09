<?php
include('header.php');
header("Content-Type: text/html; charset=utf-8");
include_once "db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $display_name = $_POST['display_name'];
    $password_check = $_POST['password_check'];

    $query = "select * from user where username = ?";
    $stmt = $db->prepare($query);
    $stmt -> execute(array($username));
    $result = $stmt -> fetchAll();

    $query = "insert into user values(?,?,?,?,?)";
    $stmt = $db->prepare($query);
    if(count($result)==1){
        echo "<script>alert('警告：此帳號已註冊過');</script>";
    }elseif (empty($username) || empty($password) || empty($display_name) || empty($password_check)) {
        //$message = "Variable 'username' is empty.";
        echo "<script>alert('警告：有空格沒填東西');</script>";
    }elseif ($password!=$password_check) {
        //$message = "Password is not the same.";
        echo "<script>alert('警告：密碼不一樣');</script>";

    }else{
        $stmt->execute(array(null,$username,$display_name,$password,'u'));
        header("Location: login.php");
    }
}
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"  onclick="location.href='login.php';">arrow_back</button>
            <span class="mdc-top-app-bar__title">用戶註冊</span>
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
    <br/>
    <br/>
    <br/>

    <h3 class="brown-text">用戶註冊</h3>
    <div class="row">
        <form class="col s6 offset-s3" action="" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <input value="" id="textarea1" class="materialize-textarea"  type="text" name="username">
                    <label class="active" for="textarea1">帳號</label>
                </div>
                <div class="input-field col s12">
                    <input id="textarea2" class="materialize-textarea"  type="text" name="display_name">
                    <label class="active" for="textarea2">用戶(顯示)名稱</label>
                </div>
                <div class="input-field col s12">
                    <input id="textarea3" class="materialize-textarea"  type="password" name="password">
                    <label class="active" for="textarea3">密碼</label>
                </div>
                <div class="input-field col s12">
                    <input id="textarea4" class="materialize-textarea"  type="password" name="password_check">
                    <label class="active" for="textarea4">再次確認密碼</label>
                </div>
            </div>
            <input class=" btn waves-effect waves-light btn-small margin5 red lighten-3" type="submit"  name="submit" value="註冊">
                    
        </form>
    </div>


</center>

<?php
include('footer.php');
?>


