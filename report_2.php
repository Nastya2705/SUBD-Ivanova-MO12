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

    <title>Начисления и платежи</title>

    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Начисления и платежи</h1>
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
            <a href="nach.php" title="Начисления">Начисления</a>
        </div>
        <div class="btn_link">
            <a href="plat.php" title="Платежи">Платежи</a>
        </div>
        <div class="btn_link">
            <a href="saldo.php" title="Сальдо">Сальдо</a>
        </div>
    </div>
    <p>&nbsp;</p>
    <div>
        <?php
        $syear = 2021;
        $flat_number = 1;
        ?>
        <p>Год: <?php echo $syear; ?></p>
        <p>Квартира №<?php echo $flat_number; ?></p>
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width:5%">На начало года (+ долг / - переплата)</th>
                    <th>&nbsp;</th>
                    <th>01</th>
                    <th>02</th>
                    <th>03</th>
                    <th>04</th>
                    <th>05</th>
                    <th>06</th>
                    <th>07</th>
                    <th>08</th>
                    <th>09</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>Итого</th>
                    <th style="width:5%">+ долг / - переплата</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ret = mysqli_query($conn, "CALL proc_form_2($syear,$flat_number); ");
                $row = mysqli_num_rows($ret);
                if ($row > 0) {
                    while ($row = mysqli_fetch_array($ret)) {
                ?>
                        <tr>
                            <td rowspan="2"><?php echo $row['saldo_start']; ?></td>
                            <td>Начис.</td>
                            <td><?php echo $row['ch_m1']; ?></td>
                            <td><?php echo $row['ch_m2']; ?></td>
                            <td><?php echo $row['ch_m3']; ?></td>
                            <td><?php echo $row['ch_m4']; ?></td>
                            <td><?php echo $row['ch_m5']; ?></td>
                            <td><?php echo $row['ch_m6']; ?></td>
                            <td><?php echo $row['ch_m7']; ?></td>
                            <td><?php echo $row['ch_m8']; ?></td>
                            <td><?php echo $row['ch_m9']; ?></td>
                            <td><?php echo $row['ch_m10']; ?></td>
                            <td><?php echo $row['ch_m11']; ?></td>
                            <td><?php echo $row['ch_m12']; ?></td>
                            <td><?php echo $row['sum_charges']; ?></td>
                            <td rowspan="2"><?php echo $row['saldo_end']; ?></td>
                        </tr>
                        <tr>
                            <td>Опл.</td>
                            <td><?php echo $row['p_m1']; ?></td>
                            <td><?php echo $row['p_m2']; ?></td>
                            <td><?php echo $row['p_m3']; ?></td>
                            <td><?php echo $row['p_m4']; ?></td>
                            <td><?php echo $row['p_m5']; ?></td>
                            <td><?php echo $row['p_m6']; ?></td>
                            <td><?php echo $row['p_m7']; ?></td>
                            <td><?php echo $row['p_m8']; ?></td>
                            <td><?php echo $row['p_m9']; ?></td>
                            <td><?php echo $row['p_m10']; ?></td>
                            <td><?php echo $row['p_m11']; ?></td>
                            <td><?php echo $row['p_m12']; ?></td>
                            <td><?php echo $row['sum_payments']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="10">&nbsp;</td>
                            <td colspan="5" style="text-align:right"><b>Итого:</b></td>
                            <td><b><?php echo $row['sum_all']; ?></b></td>
                        </tr>
                <?php
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
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>
</body>

</html>