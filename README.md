# Разработка сервиса аналитики проведения видеоконференций в СЭО МАИ
## О проекте
Целью является разработка страницы статистики для постоянного наблюдения и оценки загруженности серверов 
BigBlueButton (открытое ПО для проведения веб-конференций) и интеграции этой страницы в LMS Moodle (гибкая система управления курсами, на основе которой работают сайты дистанционного обучения).
Веб-сервис дсодержит различные графики количества участников и комнат по 
серверам за разные промежутки времени.
![Нагрузка за месяц](https://user-images.githubusercontent.com/102303340/165743770-0d62ce4d-592a-40c4-8c4a-53edff95a1ab.png)
![Средняя и максимальная нагрузка по серверам за период](https://user-images.githubusercontent.com/102303340/165743786-7a1d02e6-0689-453d-87e0-b8ac06cff417.png)
![Нагрузка по серверам за период](https://user-images.githubusercontent.com/102303340/165743808-9672c0ec-8bb8-40b4-ade9-d769b019a3e0.png)
## Логика работы
1. Выборка данных из базы, по которым будут строиться графики. 
2. Далее, полученный массив записей преобразуется в JSON-файл. 
3. Полученный JSON-файл передается в скрипт, который строит графики. Чтобы работать с сервисом было удобнее и не было необходимости перезагружать страницу, используется технология AJAX (в данном случае, реализуется объектом XMLHttpRequest). 
4. По данным из полученного JSON-файла строятся интерактивные графики с помощью инструментов библиотеки Highcharts (highcharts.com).
## Выборка и обработка
Информация о состоянии серверов хранится в таблице базы данных Moodle и называется itk_bbb_stat с префиксом mdl (префикс добавляется ко всем таблицам БД). Каждые 60 секунд сервер отправляет статистику о каждом имеющемся сервере и общую нагрузку (BALANCER). Количество серверов и их названия могут меняться.

Изначально был использован инструмент работы с базами данных PDO, затем он был заменен на специальный API работы с базой данных Moodle. Такой подход предоставляет высокий уровень абстракции и гарантирует корректную работу запросов при работе с различными реляционными СУБД. 

Доступ к базе данных предоставляется через глобальный объект $DB, который доступен сразу после подключения config.php (вторая строка кода). 

Пример использования: метод get_records_sql – возвращает список записей пользовательского запроса SELECT. Используются плейсхолдеры. Для этого в самом запросе вместо переменной указывается символ вопроса, а в функции типа get_records_sql передается вторым параметром массив переменных (в том порядке, в котором эти переменные должны быть вставлены в запрос).

Полученный массив кодируется в нужный формат (json_encode) и отправляется как JSON-файл (для этого был установлен header) в скрипт отрисовки.

Для каждого графика разработан собственный сценарий, который осуществляет выборку данных и производит манипуляции над ними.
## Отправка
Для загрузки обработанных данных с сервера HTTP-методом GET используется API XMLHttpRequest, который позволяет делать запросы без перезагрузки страницы. XMLHttpRequest имеет асинхронный и синхронный режим работы. В данном случае он выполняется асинхронно, потому что в таком случае запрос не блокирует JavaScript до тех пор, пока не будет завершена загрузка.
## Отрисовка
Для отрисовки интерактивных графиков используется библиотека Highcharts. Графики могут быть скомбинированы между собой и выведены в одном контейнере. В данном случае использованы bar chart (гистограмма) и line chart (линейный график).

Графики Highcahrts работают на чистом JS, поддерживаются всеми современными браузерами и не требуют использования дополнительных плагинов.

Анимация, кнопки конфигурации, полоса прокрутки для выбора временного промежутка добавляется автоматически и не требует настройки, возможен перевод кнопок в случае необходимости.
## Ссылки
1. [Highcharts](https://www.highcharts.com/)
2. [Moodle Data Manipulation API](https://docs.moodle.org/dev/Data_manipulation_API)
