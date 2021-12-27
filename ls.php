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

    <title>Л/С</title>

    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="ajax.js"></script>
</head>

<body>
    <h1>Лицевые счета</h1>
    <div class="df">
        <div class="link_back">
            <a href="index.php" title="Назад">&larr; Назад </a>
        </div>
        <div class="btn_link">
            <a href="nach.php" title="Начисления">Начисления</a>
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
                    $ret = mysqli_query($conn, "SELECT count(*) as scount_ls FROM `tb_ls` ");
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
                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Добавить товар</span></a>
                </div>
            </div>
        </div>
        <div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>№ Л/С</th>
                        <th>№ квартиры</th>
                        <th>Адрес</th>
                        <th>Собственник</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ret = mysqli_query($conn, "SELECT `id` as id, `flat_number` as flat_number, `address` as address, `owner` as owner 
                            FROM `tb_ls` 
                            order by flat_number asc ");
                    $cnt = 1;
                    $row = mysqli_num_rows($ret);
                    if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                            $pid = $row["id"];
                    ?>
                            <tr id="<?php echo $row["id"]; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['flat_number']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['owner']; ?></td>
                                <td>
                                    <a href="#editEmployeeModal" class="edit" data-toggle="modal">
                                        <i class="material-icons update" 
                                        data-toggle="tooltip" 
                                        data-id ="<?php echo $row["id"]; ?>" 
                                        data-flatnumber = "<?php echo $row["flat_number"]; ?>" 
                                        data-address = "<?php echo $row["address"]; ?>" 
                                        data-owner = "<?php echo $row["owner"]; ?>" 
                                        title = "Изменить"></i>
                                    </a>
                                    <a href="#deleteEmployeeModal" class="delete" data-id="<?php echo $row["id"]; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Удалить"></i></a>
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
                            <h4 class="modal-title">Добавить новый Л/С</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>№ квартиры:</label>
                                <input type="number" id="flat_number" name="flat_number" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Адрес:</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Собственник:</label>
                                <input type="text" id="owner" name="owner" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="1" name="type">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Отмена">
                            <button type="button" class="btn btn-success" id="btn-add">Добавить</button>
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
                        <div class="modal-header">
                            <h4 class="modal-title">Изменить Л/С</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_u" name="id" class="form-control" required>

                            <div class="form-group">
                                <label>№ квартиры:</label>
                                <input type="number" id="flat_number_u" name="flat_number" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Адрес:</label>
                                <input type="text" id="address_u" name="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Собственник:</label>
                                <input type="text" id="owner_u" name="owner" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="12" name="type">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Отмена">
                            <button type="button" class="btn btn-info" id="update">Обновить</button>
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
                            <input type="hidden" id="id_d" name="id" class="form-control">
                            <p class="text-warning"><small>Это действие нельзя будет отменить.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Отмена">
                            <button type="button" class="btn btn-danger" id="delete">Удалить</button>
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
</body>

</html>