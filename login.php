<?php
session_start();
include('header.php');
include_once "db_conn.php";
header("Content-Type: text/html; charset=utf-8");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "select user_id, user_level from user where username = ? and password = ?";
    $stmt = $db->prepare($query);
    $stmt -> execute(array($username, $password));
    $result = $stmt -> fetchAll();

    //echo "<script>alert(strval(count($result)))</script>";
    if(count($result)==1){
        //echo "<script>alert('登入成功')</script>";


        $_SESSION["hasSignedIn"] = true;
        $_SESSION["user_id"] = $result[0]['user_id'];
        $_SESSION["username"] = $username;
        $_SESSION["user_level"] = $result[0]['user_level'];
        echo '<script>location.href="index.php"</script>';
        //header("Location: index.php");
        exit;
    }
    else{
        echo "<script>alert('帳號或密碼錯誤')</script>";
    }
}

?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"  onclick="location.href='index.php';">arrow_back</button>
            <span class="mdc-top-app-bar__title">用戶登入</span>
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
    <h3 class="brown-text">用戶登入</h3>
    <div class="row">
        <form class="col s6 offset-s3" action="" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <input id="textarea1" class="materialize-textarea" type="text" name="username"/>
                    <label for="textarea1">帳號</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="textarea1" class="materialize-textarea" type="password" name="password"/>
                    <label for="textarea1">密碼</label>
                </div>
            </div>
            <input class=" btn waves-effect waves-light btn-small margin5 red lighten-3" type="submit"  name="submit" value="用戶登入">
            <!--    <a class="waves-effect waves-light btn-small margin5" onclick="location.href='mipsEmulator.html';">忘記密碼</a>-->
            <a class="waves-effect waves-light btn-small margin5 red lighten-3" onclick="location.href='register.php';">註冊</a>
        </form>
    </div>


</center>

<?php
include('footer.php');
?>


