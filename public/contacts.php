<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Наши контакты</title>
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <div class="container">
            <header>
                <? include "../template/header.php";?>
            </header>
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li>Контакты</li>
            </ul>
            <main class="content">
                <div class="feedback_form">
                    <h1>Напишите нам</h1>
                    <script>
                        function showAlert()
                        {
                            alert('Спасибо за ваш отзыв! Мы обязательно ответим на него');
                        }
                    </script>
                    <form action="javascript:showAlert()">
                        <p><input class="style_input" type="text" placeholder="Ваше имя" required autocomplete="on"></p>
                        <p><input class="style_input" type="email" placeholder="Ваш Email" required autocomplete="on"></p>
                        <p><input class="style_input" type="text" placeholder="Тема" required></p>
                        <p><textarea class="style_input" name="comment" rows="5" placeholder="Текст сообщения" required></textarea></p>
                        <p><input type="submit" value="Отправить"></p>
                    </form>
                </div>
                <div class="contacts_form">
                    <h1>Контакты</h1>
                    <p>Телефон: <a href="tel:88005556677">8 (800) 555 6677</a></p>
                    <p>Адрес: <a href="https://maps.google.com/?q=Москва,%20Фрунзенская%20набережная,%2030,%20строение%202" target="_blank">Москва, Фрунзенская набережная, 30, строение 2</a></p>
                    <p>Email: <a href="mailto:store@laptops-heaven.local">store@laptops-heaven.local</a></p>
                    <p>Полное наименование: Общество с ограниченной ответственностью «Первый цифровой»</p>
                    <p>Сокращенное наименование:    ООО «Первый цифровой»</p>
                    <p>ИНН:     123456791</p>
                    <p>КПП:     997950001</p>
                    <p>ОГРН:    1234567891011</p>
                    <h2>Реквизиты</h2>
                    <p>Для денежных расчетов:   р/с 40701812200003334455</p>
                    <p>в АО АКБ «ЕВРОФИНАНС МОСНАРБАНК» г. Москва</p>
                    <p>к/с 33101811999000000333</p>
                    <p>БИК 055525304</p>
                </div>
                
                <div class="map_form">
                    <h2>На карте</h2>
                    <div id="map"></div>
                    <script>
                    function initMap() {
                    var store = {lat: 55.725842,lng: 37.5832743};
                    var map = new google.maps.Map(document.getElementById('map'), {zoom: 18, center: store});
                    var marker = new google.maps.Marker({position: store, map: map});}
                    </script>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHtv1L4ol9cUyeDP8C52ge8EzyVVCU18c&callback=initMap">
                    </script>
                </div>
            </main>
            <footer>
                <? include "../template/footer.php";?>
            </footer>
        </div>
    </body>
</html>