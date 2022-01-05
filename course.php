<?php
include('header.php'); ?>
<?php
    include_once "db_conn.php";
    session_start();
    $_SESSION["edit_mode"] = false;
    if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
        //echo 'user_id:'.$_SESSION["user_id"].'</br>';
        //echo 'username:'.$_SESSION["username"].'</br>';
    }
?>
<?php
    if(array_key_exists('logOut', $_POST)) {
        logOut();
    }
    function logOut() {
        $_SESSION["hasSignedIn"] = false;
        //header("Refresh:1");
    }
?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="index.php">arrow_back
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
    <br/>
    <br/>

    

    <div class="row">
        <h3 class="inline"> 查詢資料</h3>
        <form class="inline col s4 offset-s7 " action="" method="post" style=''>
            <div class="row inline">
                <div class="input-field col s7">
                    <i class="material-icons prefix ">search</i>
                    <input id="textarea1" class="materialize-textarea" type="text" name="searchWord"></input>
                    <label for="icon_prefix2">查詢</label>
                </div>
                <p></p>
                <input class="inline btn waves-effect waves-light btn-small margin5 vertical-center " type="submit"  name="submit" value="查詢">
            </div>
           
        </form>
    </div>
    
    <br/>
        <table class="table2">
            <thead class="thead2">
                <tr>
                <th>課程名稱</th>
                <th>學系</th>
                <th>時間</th>
                <th>詳細資料</th>
                </tr>
            
            </thead>
            <tbody class="tbody2">
                <?php
                $searchWord='';
                error_reporting(E_ERROR | E_PARSE);
                if(isset($_POST['searchWord'])){
                    $searchWord=$_POST['searchWord'];
                }



                $query = ("select * from course
                            where course_name like ?");
                $stmt = $db->prepare($query);
                $stmt->execute(array('%'.$searchWord.'%'));
                $result = $stmt->fetchAll();
    
                for ($i = 0; $i < count($result); $i++) {
                    echo '<form action="courseInfo.php" method="post">';
                    echo '<tr>';
                    echo '<td>' . $result[$i]['course_name'] . "</td>";
                    echo '<td>' . $result[$i]['department_name'] . "</td>";
                    echo '<td> ' . $result[$i]['course_time'] . "</td>";
                    echo '<input type="hidden" name="courseId" value="'.$result[$i]['course_id'].'">';

                    echo '<td><a class="waves-effect waves-light btn" href="courseInfo.php?course_id='.$result[$i]['course_id'].'">更多資訊</a></td>';
    
                    echo "</tr>";
                    echo "</form>";
                }
                ?>
            </tbody>
        </table>
        <br>
    <br>
    <br>
<!--        <a class="waves-effect waves-light btn-small margin5" onclick=location.href="index.php">回到標題</a>-->
<!--        </form>-->
        <form method="post">

<!--        --><?php
//        if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true && $_SESSION["user_level"]=='s'){
//            echo '<a class="waves-effect waves-light btn-small margin5" onclick=location.href="courseAdd.php">新增課程</a>';
//        }
//        ?>


<!--        <form  method="post">-->
<!--            --><?php
//            if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
//                echo '<input type="submit" name="logOut"
//                            class="btn waves-effect waves-light btn-small margin5" value="登出" />';
//            }
//            ?>
<!--        </form>-->

        <?php
        if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true) {
            if ($_SESSION["user_level"] == 's') {
                echo '<div class="fixed-action-btn">
                       <a class="btn-floating btn-large red"  onclick=location.href="courseAdd.php">
                         <i class="large material-icons">add</i>
                        </a>
                       
                    </div>';
            }
        }
        ?>
            <a class="waves-effect waves-light btn-small margin5" onclick=location.href="instructor.php">教師列表</a>
            <a class="waves-effect waves-light btn-small margin5" onclick=location.href="department.php">學系列表</a>


</center>

<?php
include('footer.php');
?>


