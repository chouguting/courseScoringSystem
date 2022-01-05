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

?>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //echo array_keys($_POST)[1];
   if(strpos(array_keys($_POST)[1], 'delete') !== false){
       $user_id = array_keys($_POST)[1];
       $query = "delete from user where user_id = ?";
       $stmt = $db->prepare($query);
       $stmt->execute(array(intval(substr($user_id,6))));
       //header("Refresh:0");
       echo sprintf('<script type="text/JavaScript"> location.href="userManage.php"; </script>');
   }
}
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="index.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">使用者管理</span>
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
            <h3 class="inline"> 使用者管理</h3>
            <form class="inline col s4 offset-s7 " method="post" >
                <div class="row inline">
                    <div class="input-field col s7">
                        <i class="material-icons prefix ">search</i>
                        <input id="textarea1" class="materialize-textarea" type="text" name="searchWord"></input>
                        <label for="icon_prefix2">查詢</label>
                    </div>
                    <p></p>
                    <input class="inline btn waves-effect waves-light btn-small margin5 vertical-center " type="submit"  name="submit" value="查詢">
                </div>
            
        </div>

        <br/>
        <br/>
        <form method="post">
        <table class="table2">
            <thead class="thead2">
            <tr>
                <th>id</th>
                <th>username</th>
                <th>顯示名稱</th>
                <th>用戶層級</th>
                <th></th>
            </tr>

            </thead>
            <tbody class="tbody2">
            <?php
            $searchWord='';
            error_reporting(E_ERROR | E_PARSE);
            if(isset($_POST['searchWord'])){
                $searchWord=$_POST['searchWord'];
            }

            $query = ("select * from user
                            where username like ?");
            $stmt = $db->prepare($query);
            $stmt->execute(array('%'.$searchWord.'%'));
            $result = $stmt->fetchAll();

            for ($i = 0; $i < count($result); $i++) {
                echo '<tr>';
                echo '<td>' . $result[$i]['user_id'] . "</td>";
                echo '<td>' . $result[$i]['username'] . "</td>";
                echo '<td> ' . $result[$i]['display_name'] . "</td>";
                if($result[$i]['user_level']=='u'){
                    echo '<td>' . "一般使用者" . "</td>";
                }else{
                    echo '<td>' . "管理者" . "</td>";
                }

                echo sprintf('<td><button class="btn-floating btn-large waves-effect waves-light red" type="submit" name="%s">
                      <i class="material-icons">delete_forever</i>
                      </button></td>','delete'.$result[$i]['user_id']);
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        </form>
        <br>
        <br>
        <br>
        <a class="waves-effect waves-light btn-small margin5" onclick=location.href="index.php">回到標題</a>

    </center>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red"  onclick=location.href="userAdd.php">
            <i class="large material-icons">add</i>
        </a>

    </div>
<?php
include('footer.php'); 
?>