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

    <title>Оборотная ведомость по квартире</title>

    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Оборотная ведомость по квартире</h1>
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
            <div>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Квартира</th>
                            <th>Вх.сальдно</th>
                            <?php
                            $months = array(
                                'Январь', 'Февраль', 'Март', 'Апрель', 'Май',  'Июнь',
                                'Июль', 'Август', 'Сентябрь', 'Октябрь',  'Ноябрь', 'Декабрь'
                            );

                            $dateStr = date("Y-m-d"); // сегодня
                            $begin = new DateTime($dateStr);
                            $end = (new DateTime($dateStr))->modify('+12 month');

                            $periods = new DatePeriod($begin, new DateInterval('P1M'), $end);

                            // вывод 
                            foreach ($periods as $period) {
                                $num = $period->format("n");
                                echo "<th>{$months[$num - 1]}</th>";
                            }
                            ?>
                            <th>Исх.сальдо</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $syear = 2021;

                        $ret = mysqli_query($conn, "CALL proc_form_1($syear); ");
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                            while ($row = mysqli_fetch_array($ret)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['flat_number']; ?></td>
                                    <td><?php echo $row['saldo_start']; ?></td>
                                    <td><?php echo $row['m1']; ?></td>
                                    <td><?php echo $row['m2']; ?></td>
                                    <td><?php echo $row['m3']; ?></td>
                                    <td><?php echo $row['m4']; ?></td>
                                    <td><?php echo $row['m5']; ?></td>
                                    <td><?php echo $row['m6']; ?></td>
                                    <td><?php echo $row['m7']; ?></td>
                                    <td><?php echo $row['m8']; ?></td>
                                    <td><?php echo $row['m9']; ?></td>
                                    <td><?php echo $row['m10']; ?></td>
                                    <td><?php echo $row['m11']; ?></td>
                                    <td><?php echo $row['m12']; ?></td>
                                    <td><?php echo $row['saldo_end']; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
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