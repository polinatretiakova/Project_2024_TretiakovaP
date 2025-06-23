<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "design";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Запрос для получения изображений галереи
    $stmt = $conn->query("SELECT * FROM gallery");
    $galleryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>LLIARSSS DESIGN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700,900|Oswald:400,700" rel="stylesheet">
    
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/fancybox.min.css">

    <link rel="stylesheet" href="css/style.css">

    <style>
      .photo-item {
          position: relative;
          overflow: hidden;
      }

      .photo-title {
          position: absolute;
          bottom: -100%;
          left: 0;
          right: 0;
          background: rgba(0, 0, 0, 0.7);
          color: white;
          padding: 15px;
          text-align: center;
          transition: bottom 0.3s ease;
      }

      .photo-item:hover .photo-title {
          bottom: 0;
      }

      .photo-text-more {
          display: none;
      }

      /* Блок отзывов */


      .testimonial-card {
          background: #2a2a2a;
          border-radius: 8px;
          padding: 30px;
          height: 100%;
          transition: transform 0.3s ease;
          box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }

      .testimonial-card:hover {
          transform: translateY(-10px);
      }

      .testimonial-header {
          display: flex;
          justify-content: space-between;
          margin-bottom: 20px;
      }

      .rating {
          color: #FFD700;
          font-size: 18px;
      }

      .date {
          color: #aaa;
          font-size: 14px;
      }

      .testimonial-text {
          color: #eee;
          font-style: italic;
          line-height: 1.6;
          margin-bottom: 25px;
      }

      .testimonial-footer {
          border-top: 1px solid #444;
          padding-top: 15px;
      }

      .client-name {
          display: block;
          color: #fff;
          font-weight: bold;
          margin-bottom: 5px;
      }

      .client-project {
          color: #aaa;
          font-size: 14px;
      }
      /* Карта */
      #map {
          box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      }

      /* Контактная информация */
      .contact-info {
          background: #2a2a2a;
          border-radius: 8px;
          padding: 30px;
          height: 100%;
      }

      .contact-item {
          display: flex;
          margin-bottom: 20px;
      }

      .contact-icon {
          color: #FFD700;
          font-size: 24px;
          margin-right: 15px;
          width: 30px;
      }

      .contact-text h4 {
          color: #FFD700;
          margin-bottom: 5px;
          font-size: 18px;
      }

      .contact-text p,
      .contact-text a {
          color: #eee;
          margin: 0;
          line-height: 1.6;
      }

      .contact-text a:hover {
          color: #FFD700;
          text-decoration: none;
      }

      /* Социальные иконки */
      .social-links {
          display: flex;
          gap: 15px;
      }

      .social-icon {
          color: #eee;
          font-size: 24px;
          transition: color 0.3s ease;
      }

      .social-icon:hover {
          color: #FFD700;
      }
    </style>

  </head>
  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="200">
  

  <div class="site-wrap">

  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close mt-3">
        <span class="icon-close2 js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>

  <header class="header-bar d-flex d-lg-block align-items-center site-navbar-target" data-aos="fade-right">
    <div class="site-logo">
      <a href="index.php">lliarsss design</a>
    </div>
    
    <div class="d-inline-block d-lg-none ml-md-0 ml-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

    <div class="main-menu">
      <ul class="js-clone-nav">
        <li><a href="#section-home" class="nav-link">Главная</a></li>
        <li><a href="#section-photos" class="nav-link">Галерея работ</a></li>
        <li><a href="#section-bio" class="nav-link">Наши услуги</a></li>
        <li><a href="#section-blog" class="nav-link">Отзывы клиентов</a></li>
        <li><a href="#section-contact" class="nav-link">Контакты</a></li>
      </ul>
    </div>
  </header> 

  <main class="main-content">

    <section class="site-section-hero bg-image" style="background-image: url('images/img_main.jpg');"  data-stellar-background-ratio="0.5" id="section-home">
        <div class="row justify-content-center align-items-center">
          <div class="col-md-7 text-center">
            <h1 class="text-white heading text-uppercase" data-aos="fade-up">Суть. Стиль. Результат.</h1>
            <p class="lead text-white mb-5" data-aos="fade-up" data-aos-delay="100">Дизайн — это язык, на котором говорит бренд. Создадим дизайн, который скажет все за вас.</p>
            <p data-aos="fade-up" data-aos-delay="100"><a href="#section-contact" class="btn btn-primary btn-md smoothscroll">Мне нужен дизайн!</a></p>
          </div>
        </div>
      </section>

    <div class="container-fluid">
      <section class="row align-items-stretch photos" id="section-photos">
    <div class="col-12">
        <div class="row align-items-stretch">
            <?php foreach ($galleryItems as $index => $item): ?>
            <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                <a href="<?= htmlspecialchars($item['image_path']) ?>" class="d-block photo-item" data-fancybox="gallery">
                    <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="img-fluid">
                    <div class="photo-title">
                        <?= htmlspecialchars($item['title']) ?>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
      
      <section class="site-section darken-bg" id="section-bio">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <h2 class="heading text-uppercase text-white">Превращаем идеи в визуальную реальность</h2>
              <div data-aos="fade-up"  data-aos-delay="100">
              <h2 class="text-white">Что мы делаем?</h2>
              <p>Наша студия специализируется на комплексных дизайн-решениях для бизнеса. 
                Мы работаем с разными форматами, чтобы ваш бренд выглядел цельно и профессионально.</p>
              <p>Хотите сайт, который не просто работает, а вызывает «вау!»? Давайте сделаем это! </p>
              <div class="d-block d-md-flex mt-5">
                <div class="mr-md-auto mr-2">
                  <ul class="ul-check list-unstyled success">
                    <li>Дизайн сайтов и лендингов</li>
                    <li>Логотипы и фирменный стиль</li>
                    <li>Брендинг и айдентика</li>
                  </ul>
                </div>
                <div class="mr-md-auto">
                  <ul class="ul-check list-unstyled success">
                    <li>Полиграфия: визитки, буклеты, плакаты</li>
                    <li>Упаковка и мерч</li>
                    <li>Графика для соцсетей</li>
                  </ul>
                </div>

              </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="site-section" id="section-blog">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <h2 class="heading text-uppercase text-white text-center mb-5" data-aos="fade-up">Отзывы клиентов</h2>
                
                <div class="row">
                    <?php
                    // Подключаемся к БД
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "design";
                    
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        // Получаем отзывы из БД
                        $stmt = $conn->query("SELECT * FROM testimonials ORDER BY date DESC LIMIT 3");
                        $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($testimonials as $index => $testimonial) {
                            $delay = ($index + 1) * 100;
                            $ratingStars = str_repeat('★', $testimonial['rating']) . str_repeat('☆', 5 - $testimonial['rating']);
                            $formattedDate = date('d.m.Y', strtotime($testimonial['date']));
                            
                            echo <<<HTML
                            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="$delay">
                                <div class="testimonial-card">
                                    <div class="testimonial-header">
                                        <div class="rating">$ratingStars</div>
                                        <div class="date">$formattedDate</div>
                                    </div>
                                    <div class="testimonial-body">
                                        <p class="testimonial-text">"{$testimonial['text']}"</p>
                                    </div>
                                    <div class="testimonial-footer">
                                        <span class="client-name">{$testimonial['client_name']}</span>
                                        <span class="client-project">{$testimonial['project_type']}</span>
                                    </div>
                                </div>
                            </div>
                            HTML;
                        }
                    } catch(PDOException $e) {
                        echo "<div class='col-12'><p class='text-white text-center'>Ошибка загрузки отзывов. Пожалуйста, попробуйте позже.</p></div>";
                    }
                    ?>
                </div>
            </div>
          </div>
        </div>
      </section>

      <section class="site-section darken-bg" id="section-contact">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <h2 class="heading text-uppercase text-white text-center mb-5" data-aos="fade-up">Контакты</h2>
                
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                        <div id="map" style="width: 100%; height: 400px; border-radius: 8px;"></div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="contact-info">
                            <h3 class="text-white mb-4">Как с нами связаться</h3>
                            
                            <div class="contact-item mb-4">
                                <div class="contact-icon">
                                    <i class="icon-location-pin"></i>
                                </div>
                                <div class="contact-text">
                                    <h4 class="text-white">Адрес</h4>
                                    <p>Россия, г. Барнаул, пр. Комсомольский, 100</p>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="contact-icon">
                                    <i class="icon-clock"></i>
                                </div>
                                <div class="contact-text">
                                    <h4 class="text-white">Часы работы</h4>
                                    <p>Пн-Чт: 9:00 - 18:00<br>Пт: 9:00 - 17:00<br>Сб-Вс: выходной</p>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="contact-icon">
                                    <i class="icon-phone"></i>
                                </div>
                                <div class="contact-text">
                                    <h4 class="text-white">Телефоны</h4>
                                    <p>
                                        <a href="tel:+73852111111">+7 (3852) 11-11-11</a><br>
                                        <a href="tel:+79132652055">+7 (913) 265-20-55</a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="icon-envelope"></i>
                                </div>
                                <div class="contact-text">
                                    <h4 class="text-white">Электронная почта</h4>
                                    <p><a href="mailto:info@lliarsss-design.ru">info@lliarsss-design.ru</a></p>
                                    <p><a href="mailto:polinatretiakova795@gmail.com">polinatretiakova795@gmail.com</a></p>
                                </div>
                            </div>
                            
                            <div class="social-links mt-5">
                                <a href="https://vk.com/lliarsss" class="social-icon"><i class="icon-vk"></i></a>
                                <a href="https://t.me/lliarsss" class="social-icon"><i class="icon-telegram"></i></a>
                                <a href="https://wa.me/79132652055" class="social-icon"><i class="icon-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </section>

      <script src="https://api-maps.yandex.ru/2.1/?apikey=ваш_API_ключ&lang=ru_RU" type="text/javascript"></script>
<script>
    // Инициализация карты
    ymaps.ready(init);
    
    function init() {
        // Создаем карту
        var myMap = new ymaps.Map("map", {
            center: [53.345903,83.78813], // Координаты Барнаула (Комсомольский пр-т, 100)
            zoom: 16
        });
        
        // Создаем метку
        var myPlacemark = new ymaps.Placemark([53.345903,83.78813], {
            hintContent: 'LLIARSSS DESIGN',
            balloonContent: `
                <strong>LLIARSSS DESIGN</strong><br>
                <p>Адрес: г. Барнаул, пр. Комсомольский, 100</p>
                <p>Часы работы:<br>
                Пн-Чт: 9:00 - 18:00<br>
                Пт: 9:00 - 17:00<br>
                Сб-Вс: выходной</p>
            `
        }, {
            iconLayout: 'default#image',
            iconImageHref: 'images/map-marker.png',
            iconImageSize: [40, 40],
            iconImageOffset: [-20, -40]
        });
        
        // Добавляем метку на карту
        myMap.geoObjects.add(myPlacemark);
        
        // Открываем балун при загрузке
        myPlacemark.balloon.open();
    }
</script>
    </div>
  </main>

</div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>
  

  <script src="js/jquery.fancybox.min.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>