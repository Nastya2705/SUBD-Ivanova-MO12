<?php

    require_once "db.php";

    $ls_id = $_POST["ls_id"];
    $syear  = $_POST["syear"];
    $table  = $_POST["table"];

    $result = mysqli_query($conn, "SELECT m.`id_month` as id, 
    m.`label_mmonth` as label 
    FROM `tb_month`  m
    where m.id_month not in (select ch.smonth from `$table` ch where ch.id_ls = $ls_id and ch.syear = $syear)
    order by m.id_month asc ");

?>
<option value="">--- Выберите месяц ---</option>
<?php
    while ($row = mysqli_fetch_array($result)) {
?>
    <option value="<?php echo $row["id"]; ?>"><?php echo $row["label"]; ?></option>
<?php
    }
?>