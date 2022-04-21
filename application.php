<!DOCTYPE HTML>
<html>
    <head>
        <meta charset = "UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>statistics</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <style type="text/css">
        </style>
    </head>
    <body>

        <!-- ГРАФИКИ -->
        <script src="code/highstock.js"></script>
        <script src="code/themes/grid-light.js"></script>

        <div id="container" style="height: 600px; min-width: 300px"></div> <!-- контейнер для графика нагрузки BALANCER -->

        <div class="block_row"> <!-- нагрузка по серверам и меню -->
            <div class="options">
                <form action="index.php" method="POST">
                    <?php
                        require_once('menu.php'); // вывод чекбоксов в цикле
                    ?>
                </form>
            </div>

            <div id="container2" style="height: 600px; width: 90%"></div> <!-- контейнер для гистограммы нагрузки по серверам -->
        </div>

        <?php
            if (!empty($_POST['displayGraphServer'])) {
                echo '<div id=\'container3\' style=\'height: 600px; min-width: 300px\'></div>';
                echo '<script src=\'js\server-graph.js\' type=\'text/javascript\'></script>';
            }
        ?>

        <div class="block_row">
            <?php
                require_once('table-max.php');
                require_once('table-avg.php');
            ?>
        </div>

        <script src="js/chart-options.js"></script>
        <script src="js/main-graph.js" type="text/javascript"></script> <!-- скрипт графика -->
        <script src='js/server-bar.js' type='text/javascript'></script> <!-- скрипт гистограммы по серверам -->
        
    </body>
</html>