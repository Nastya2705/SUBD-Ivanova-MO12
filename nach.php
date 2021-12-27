<?php
// подключение к бд
include 'db.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Начисления</title>

    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="ajax.js"></script>
</head>

<body>
    <h1>Начисления</h1>
    <div class="df">
        <div class="link_back">
            <a href="index.php" title="Назад">&larr; Назад </a>
        </div>        
        <div class="btn_link">
            <?php
            $ret = mysqli_query($conn, "SELECT count(*) as scount_ls FROM `tb_ls` ");
            $row = mysqli_num_rows($ret);
            if ($row > 0) {
                while ($row = mysqli_fetch_array($ret)) {
                    $scount_ls = $row["scount_ls"];
            ?>
                    <a href="ls.php" title="Л/С">Л/С (<?php echo $scount_ls; ?>)</a>
            <?php
                }
            }
            ?>
        </div>
        <div class="btn_link">
            <a href="plat.php" title="Платежи">Платежи</a>
        </div>
        <div class="btn_link">
            <a href="saldo.php" title="Сальдо">Сальдо</a>
        </div>
    </div>
    <div class="table_flex">
        <div class="sp_flex">
            <div>Всего записей: <b>
                    <?php
                    $ret = mysqli_query($conn, "SELECT count(*) as scount_ls FROM `tb_charges` ");
                    $row = mysqli_num_rows($ret);
                    if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                            $scount_ls = $row["scount_ls"];
                            echo $scount_ls;
                        }
                    }
                    ?>
                </b>
            </div>
            <div>
                <div class="col-sm-6">
                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Добавить начисление</span></a>
                </div>
            </div>
        </div>
        <div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>№ Л/С</th>
                        <th>Месяц, Год</th>
                        <th>Начисления</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $_monthsList = array(
                        "1"=>"Январь","2"=>"Февраль","3"=>"Март",
                        "4"=>"Апрель","5"=>"Май", "6"=>"Июнь",
                        "7"=>"Июль","8"=>"Август","9"=>"Сентябрь",
                        "10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь");

                    $ret = mysqli_query($conn, "SELECT `id_ls` as id_ls, `smonth` as smonth, `syear` as syear , `scount` as scount 
                            FROM `tb_charges` 
                            order by id_ls, syear, smonth asc ");
                    $row = mysqli_num_rows($ret);
                    if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                            $pid = $row["id"];
                    ?>
                            <tr id="<?php echo $row["id_ls"]; ?>">
                                <td><?php echo $row['id_ls']; ?></td>
                                <td><?php echo $month = $_monthsList[date($row['smonth'])].', '.$row['syear']; ?></td>
                                <td><?php echo $row['scount']; ?></td>
                                <td>
                                    <a href="#editEmployeeModal" class="edit" data-toggle="modal">
                                        <i class="material-icons update_nach" 
                                        data-toggle="tooltip" 
                                        data-idls ="<?php echo $row["id_ls"]; ?>" 
                                        data-smonth = "<?php echo $row["smonth"]; ?>" 
                                        data-syear = "<?php echo $row["syear"]; ?>" 
                                        data-scount = "<?php echo $row["scount"]; ?>" 
                                        title = "Изменить"></i>
                                    </a>
                                    <a href="#deleteEmployeeModal" class="delete-nach" 
                                        data-idls ="<?php echo $row["id_ls"]; ?>" 
                                        data-smonth = "<?php echo $row["smonth"]; ?>" 
                                        data-syear = "<?php echo $row["syear"]; ?>" 
                                        data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Удалить"></i></a>
                                </td>
                            </tr>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    <!-- Add Modal HTML -->
     <div id="addEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="user_form">
                        <div class="modal-header">
                            <h4 class="modal-title">Добавить новые начисления</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">                            
                            <div class="form-group">
                                <label>Год:</label>
                                <input type="number" id="syear" name="syear" class="form-control" value='<?php echo date('Y', time()); ?>' required>
                            </div>
                            <div class="form-group">
                                <label>№ Л/С:</label>
                                    <?php     
                                    // вывод 
                                    echo '<select name="id_ls" id="id_ls_list" class="form-control"  onchange="val(this)" data-table="tb_charges"><option>--- Выберите Л/С ---</option>';
                                    $ret = mysqli_query($conn, "SELECT `id` as id, 
                                    concat(`id` , ' / ' , `flat_number` , ' / ' ,`address`,' / ' , `owner`) as label 
                                     FROM `tb_ls` 
                                     order by id, flat_number, address, owner asc ");
                                        $row = mysqli_num_rows($ret);
                                        if ($row > 0) {
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $id = $row["id"];
                                                $label = $row["label"];
                                        echo "<option value='{$id}'>{$label}</option>";    
                                        }  
                                    }
                                    echo '</select>';
                                    ?>
                            </div>      
                            <div class="form-group">
                                <label>Месяц:</label>   
                                <select name="smonth" class="form-control" id="smonth">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Начисления:</label>
                                <input type="number" step="0.01" id="scount" name="scount" class="form-control" value="0.00">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="21" name="type">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Отмена">
                            <button type="button" class="btn btn-success" id="btn-add-nach">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal HTML -->
        <div id="editEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="update_form">                        
                        <div class="modal-body">    
                        <div class="modal-header">
                            <h4 class="modal-title">Изменить Л/С</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="form-group">
                                <label>Год:</label>
                                <input type="number" id="syear_u" name="syear" class="form-control" value='<?php echo date('Y', time()); ?>' readonly>
                            </div>
                            <div class="form-group">
                                <label>№ Л/С:</label>
                                <input type='text' id='idls_u' name='idls' class='form-control' readonly>
                            </div>      
                            <div class="form-group">
                                <label>Месяц:</label>   
                                <input type='text' id='smonth_u' name='smonth' class='form-control' readonly>
                            </div>
                            <div class="form-group">
                                <label>Начисления:</label>
                                <input type="number" step="0.01" id="scount_u" name="scount" class="form-control" value="0.00">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="22" name="type">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Отмена">
                            <button type="button" class="btn btn-info" id="update-nach">Обновить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal HTML -->
        <div id="deleteEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>

                        <div class="modal-header">
                            <h4 class="modal-title">Удалить данные? </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idls_d" name="idls" class="form-control">
                            <input type="hidden" id="smonth_d" name="smonth" class="form-control">
                            <input type="hidden" id="syear_d" name="syear" class="form-control">
                            <p class="text-warning"><small>Это действие нельзя будет отменить.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Отмена">
                            <button type="button" class="btn btn-danger" id="delete-nach">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div class="footer_txt">
        <div>
            Сегодня: <b><?php echo date('d.m.Y h:i', time()); ?></b>
        </div>
        <div>
            Подключение к БД: <?php echo $db_conn; ?>
        </div>
    </div>
    <?php
    mysqli_close($conn);
    ?>
    <script type="text/javascript">
        function val(a) {
            var x = (a.value || a.options[a.selectedIndex].value);
        }
        </script>

</body>

</html>