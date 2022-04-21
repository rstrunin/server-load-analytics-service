<?php
    // Извлекает список всех доступных серверов из базы данных Moodle
    function getServerList() {
        global $DB;
        $serverName = 'BALANCER';
        $dateFrom = mktime() - DateGlobal::SECONDS_IN_A_YEAR;
        $query = 'SELECT DISTINCT server_name FROM {itk_bbb_stat} WHERE server_name != ? AND stat_date >= ?';
        $record = $DB->get_records_sql($query, array($serverName, $dateFrom));
        return $record;
    }

    $serverList = getServerList();

    foreach ($serverList as $server) {
        echo "<input type='checkbox' name='formBar[]' value='$server->server_name'>$server->server_name" . '<br>';
    }

    $dateFrom = date('Y-m-d\TH:i', mktime() - DateGlobal::SECONDS_IN_A_MONTH - DateGlobal::SECONDS_IN_A_HOUR);
    $dateTo = date('Y-m-d\TH:i', mktime() - DateGlobal::SECONDS_IN_A_HOUR); // время спешит на час, поэтому час надо отнять
?>


<div class="block_row">
    <?php
        echo "С&nbsp; <input type='datetime-local' value='$dateFrom' name='dateFrom'><br>";
    ?>
</div>
<div class="block_row">
    <?php   
        echo "По&nbsp;<input type='datetime-local' value='$dateTo' name='dateTo'>";
    ?>
</div>


<?php 
    echo "<input type='checkbox' name='displayGraphServer' value='true'> Построить графики <br>";
    echo "<input type='submit' value='Показать' class='button'>";
?>