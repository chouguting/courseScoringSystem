
<?php
include('header.php');?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"  onclick=location.href="index.php">arrow_back</button>
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
        <?php
            include_once "db_conn.php";

            echo "<table border='1'>
                    <tr>
                        <th>id</th>
                        <th>username</th>
                        <th>display_name</th>
                        <th>password</th>
                        <th>userLevel</th>
                    </tr>
                    ";

            $query = ("select * from user");
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();

            for ($i = 0; $i < count($result); $i++) {
                echo "<tr>";
                echo "<td>" . $result[$i]['user_id'] . "</td>";
                echo "<td>" . $result[$i]['username'] . "</td>";
                echo "<td>" . $result[$i]['display_name'] . "</td>";
                echo "<td>" . $result[$i]['password'] . "</td>";
                echo "<td>" . $result[$i]['user_level'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<br><input typut type='button' onclick='history.back()' value='Go back'></input>";
        ?>
    <a class="waves-effect waves-light btn-small margin5" onclick=location.href="inform.php">所有課程</a>

</center>

<?php
include('footer.php');
?>


