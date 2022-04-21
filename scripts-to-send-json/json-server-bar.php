<?php
    // Для гистограммы по комнатам
    header('Content-Type: application/json');

    require_once('/../class.php');
    require_once(dirname(__FILE__).'/../../config.php');

    function get() {
        global $DB;
        $dateFrom = strtotime($_COOKIE["dateFrom"]);
        $dateTo = strtotime($_COOKIE["dateTo"]);
        $servers = unserialize($_COOKIE["selectedServers"]);

        foreach ($servers as $server) {
            $query = "SELECT server_name, ROUND(AVG(meetings), 2) avg_meetings, MAX(meetings) max_meetings
                FROM {itk_bbb_stat}
                WHERE server_name = ? AND meetings != 0 AND stat_date BETWEEN ? AND ?
                GROUP BY server_name";
            $record[$server] = $DB->get_record_sql($query, array($server, $dateFrom, $dateTo));
        }
        return $record;
    }

    echo json_encode(get());
?>