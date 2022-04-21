<?php
    // Для общего графика нагрузки
    header('Content-Type: application/json');

    require_once('/../class.php');
    require_once(dirname(__FILE__).'/../../config.php');

    function get() {
        global $DB;
        $dateFrom = mktime() - DateGlobal::SECONDS_IN_A_YEAR;
        $dateTo = mktime();
        $name = 'BALANCER';
        $query = 'SELECT stat_date, meetings, participants FROM {itk_bbb_stat} WHERE server_name = ? AND stat_date BETWEEN ? AND ?';
        $record = $DB->get_records_sql($query, array($name, $dateFrom, $dateTo));
        return $record;
    }

    echo json_encode(get());
?>