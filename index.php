<?php
    header('Content-Type: text/html; charset=utf-8');

    // Подключение файла конфигурации для получения доступа к объекту $DB (docs.moodle.org/dev/Data_manipulation_API -> General concepts -> DB Object)
    require_once(dirname(__FILE__).'/../config.php');
    require_once('class.php');

    // Установка cookie для выбранных серверов и промежутка времени (выводится в menu.php)
    setcookie('selectedServers', serialize($_POST['formBar']));
    setcookie('dateFrom', $_POST['dateFrom']);
    setcookie('dateTo', $_POST['dateTo']);

    // Установка параметров страницы
    $PAGE->set_pagelayout('base');
    $PAGE->set_context(get_system_context());
    $PAGE->set_title('title');
    $PAGE->set_heading('Страница статистики нагрузки серверов');
    $PAGE->set_url('/www/statistics/index.php'); // заменить на нужное
    echo $OUTPUT->header();

    // Ограничение доступа по имени пользователя
    if (/* Список пользователей LMS Moodle, которым доступна страница.
        ($USER->username == 'ИМЯ_ПОЛЬЗОВАТЕЛЯ_MOODLE') */) {
            require_once('application.php');
    }
    else {
        // В случае отсутствия прав доступа у пользователя
        echo 'Access denied!';
    }

    // Вывод нижней части страницы
    echo $OUTPUT->footer();
?>