<?php
include('header.php'); ?>
<?php
include_once "db_conn.php"; ?>
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


    <form action="inform.php" method="get">
        <h3> 查詢資料</h3>

        <table border='1' style='width:70%'>
            <tr>
                <th>id</th>
                <th>course name</th>
                <th>department</th>
                <th>time</th>
                <th>location</th>
            </tr>
            <?php

            $query = ("select * from course");
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();

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
        <br>


        <a class="waves-effect waves-light btn-small margin5" onclick=location.href="index.php">回到標題</a>

</center>

<?php
include('footer.php');
?>


