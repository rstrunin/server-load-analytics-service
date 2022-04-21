<?php
    // Для графика нагрузки серверов по комнатам
    header('Content-Type: application/json');

    // Если файл перенесен в другую директорию, путь надо поменять
    require_once('/../class.php');
    //require_once('../../../../config.php');
    require_once(dirname(__FILE__).'/../../config.php');

    function get() {
        global $DB;
        $dateFrom = strtotime($_COOKIE["dateFrom"]);
        $dateTo = strtotime($_COOKIE["dateTo"]);
        $servers = unserialize($_COOKIE["selectedServers"]);

        foreach ($servers as $server) {
            $query = "SELECT stat_date, meetings
                FROM {itk_bbb_stat}
                WHERE server_name = ? AND stat_date BETWEEN ? AND ?";
            $record[$server] = $DB->get_records_sql($query, array($server, $dateFrom, $dateTo));
        }
        return $record;
    }

    /* Промежуток времени для построения графиков, берется из формы */

    echo json_encode(get());
?> 