<?php
    header("Content-Type: text/html; charset=utf-8");
    include('header.php');
    include_once "db_conn.php";
    $courseId = $_POST['courseId'];
    echo $courseId;
    $query = "select * from course where course_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($courseId));
    $result = $stmt->fetchAll();
    if(count($result)>0){
        echo 'success';
    }else{
        echo 'fail';
    }

    $query2 = "select * from instructor where instructor_id = ?";
    $stmt2 = $db->prepare($query2);
    echo $result[0]['instructor_id'];
    $stmt2->execute(array($result[0]['instructor_id']));
    $result_instructor = $stmt2->fetchAll();
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick='history.back()'>arrow_back
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
    <table border='1' style='width:70%'>
        <tr>
            <th>課號</th>
            <th>課程名稱</th>
            <th>學系</th>
            <th>時間</th>
            <th>地點</th>
        </tr>

        <?php

        for ($i = 0; $i < count($result); $i++) {
            echo "<tr>";
            echo "<td>" . $result[$i]['course_id'] . "</td>";
            echo "<td>" . $result[$i]['course_name'] . "</td>";
            echo "<td>" . $result[$i]['department_name'] . "</td>";
            echo "<td>" . $result[$i]['course_time'] . "</td>";
            echo "<td>" . $result[$i]['course_location'] . "</td>";

            echo "</tr>";
        }
        ?>
    </table>


    <h3> 開課老師</h3>
    <table border='1' style='width:70%'>
        <tr>
            <th>教師姓名</th>
            <th>所屬學系</th>
        </tr>

        <?php

        for ($i = 0; $i < count($result_instructor); $i++) {
            echo "<tr>";
            echo "<td>" . $result_instructor[$i]['instructor_name'] . "</td>";
            echo "<td>" . $result_instructor[$i]['department_name'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>



</center>

<?php
include('footer.php');
?>


