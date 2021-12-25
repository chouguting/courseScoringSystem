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
$stmt -> execute();
$result = $stmt -> fetchAll();

for($i=0; $i<count($result); $i++){
    echo "<tr>";
    echo "<td>".$result[$i]['user_id']."</td>";
    echo "<td>".$result[$i]['username']."</td>";
    echo "<td>".$result[$i]['display_name']."</td>";
    echo "<td>".$result[$i]['password']."</td>";
    echo "<td>".$result[$i]['user_level']."</td>";
    echo "</tr>";
}

echo "</table>";
echo "<br><input typut type='button' onclick='history.back()' value='Go back'></input>";
?>