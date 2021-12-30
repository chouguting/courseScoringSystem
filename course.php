<?php
include('header.php'); ?>
<?php
include_once "db_conn.php"; 
session_start();
if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
    echo 'user_id:'.$_SESSION["user_id"].'</br>';
    echo 'username:'.$_SESSION["username"].'</br>';
}

?>
<?php
    if(array_key_exists('logOut', $_POST)) {
        logOut();
    }
    function logOut() {
        $_SESSION["hasSignedIn"] = false;
        header("Refresh:1");
    }
?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick='history.back()'>arrow_back
            </button>
            <span class="mdc-top-app-bar__title">課程列表</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        </section>
    </div>
</header>

<center>
    <br/>
    <br/>
    <br/>





    <h3> 查詢資料</h3>

    <form id="infoForm" action="courseInfo.php" method="post">
        <table border='1' style='width:70%'>
            <tr>
                <th>課程名稱</th>
                <th>學系</th>
                <th>時間</th>
                <th>詳細資料</th>
                <?php
                    if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true) {
                        if ($_SESSION["user_level"] == 's') {
                            echo '<th>編輯</th>';
                        }
                    }
                ?>
            </tr>

            <?php

            $query = ("select * from course");
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();

            for ($i = 0; $i < count($result); $i++) {
                echo "<tr>";
                echo "<td>" . $result[$i]['course_name'] . "</td>";
                echo "<td>" . $result[$i]['department_name'] . "</td>";
                echo "<td>" . $result[$i]['course_time'] . "</td>";
                echo '<input type="hidden" name="courseId" form="infoForm" value="'.$result[$i]['course_id'].'"> ';

                echo '<td><input class="waves-effect waves-light btn" type="submit"  name="submit" value="更多資訊"></td>';
                if (isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"] == true ) {
                    if ($_SESSION["user_level"] == 's') {
                        echo '<td><input class="waves-effect waves-light btn" type="submit"  name="submit" value="編輯"></td>';
                    }
                }

                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <a class="waves-effect waves-light btn-small margin5" onclick=location.href="index.php">回到標題</a>
        </form>
        <form = method="post">

            <?php
            if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){

                echo '<input type="submit" name="logOut"
                            class="btn waves-effect waves-light btn-small margin5" value="登出" />';
            }
            ?>
        </form>

        


</center>

<?php
include('footer.php');
?>


