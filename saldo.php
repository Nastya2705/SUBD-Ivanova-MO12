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

    <title>Сальдо</title>

    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="ajax.js"></script>
</head>

<body>
    <h1>Сальдо</h1>
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
            <a href="nach.php" title="Начисления">Начисления</a>
        </div>
    </div>
    <div class="table_flex">
        <div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>№ Л/С</th>
                        <th>Начислено</th>
                        <th>Оплачено</th>
                        <th>Сальдо</th>
                        <th>Статус</th>
                        <th>Год</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ret = mysqli_query($conn, "SELECT
                    t.id_ls as id_ls,
                    t.sum_charges as sum_charges,
                    t.sum_payments as sum_payments,
                    t.sum_charges - t.sum_payments as saldo,
                    CASE
                        when (t.sum_charges - t.sum_payments) > 0 then '<b style=color:red>долг</b>'
                        when (t.sum_charges - t.sum_payments) = 0 then 'по нулям'
                        when (t.sum_charges - t.sum_payments) < 0 then '<b style=color:green>переплата</b>'
                        end sstatus,
                    t.syear as syear
                FROM
                (
                    SELECT
                    ch.id_ls as id_ls,
                    TRUNCATE(sum(ch.scount),2) as sum_charges,
                    TRUNCATE(sum(p.scount),2) as sum_payments,
                    ch.syear as syear
                from tb_charges ch,
                    tb_payments p 
                where ch.id_ls = p.id_ls
                group by 
                    ch.id_ls, ch.syear
                    ) as t ");
                    $row = mysqli_num_rows($ret);
                    if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                    ?>
                            <tr id="<?php echo $row["id_ls"]; ?>">
                                <td><?php echo $row['id_ls']; ?></td>
                                <td><?php echo $row['sum_charges']; ?></td>
                                <td><?php echo $row['sum_payments']; ?></td>
                                <td><?php echo $row['saldo']; ?></td>
                                <td><?php echo $row['sstatus']; ?></td>
                                <td><?php echo $row['syear']; ?></td>
                            </tr>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div class="footer_txt">
        <div>
            <?php echo date('d.m.Y h:i', time()); ?>
        </div>
        <div>
            Связь с БД: <?php echo $db_conn; ?>
        </div>
    </div>
    <?php
    mysqli_close($conn);
    ?>
    <script type="text/javascript">
        function val(a) {
            var x = (a.value || a.options[a.selectedIndex].value);
        }

        function fetch_select(val)
        {
        $.ajax({
            type: 'post',
            url: 'fetch_data.php',
            data: {
            get_option:val
        },
        success: function (response) {
            document.getElementById("new_select").innerHTML=response; 
        }
        });
        }

        </script>

</body>

</html>