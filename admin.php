<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "design";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Обработка добавления нового изображения в галерею
if (isset($_POST['add_gallery_item'])) {
    $title = $_POST['title'];
    $image_path = 'images/' . basename($_FILES['image']['name']);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        $stmt = $conn->prepare("INSERT INTO gallery (image_path, title) VALUES (:image_path, :title)");
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        $gallery_success = "Изображение успешно добавлено!";
    } else {
        $gallery_error = "Ошибка загрузки изображения";
    }
}

// Обработка удаления изображения из галереи
if (isset($_GET['delete_gallery'])) {
    $id = $_GET['delete_gallery'];
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: admin.php?tab=gallery');
    exit;
}

// Обработка добавления нового отзыва
if (isset($_POST['add_testimonial'])) {
    $client_name = $_POST['client_name'];
    $text = $_POST['text'];
    $rating = $_POST['rating'];
    $project_type = $_POST['project_type'];
    $date = date('Y-m-d');
    
    $stmt = $conn->prepare("INSERT INTO testimonials (client_name, text, rating, project_type, date) VALUES (:client_name, :text, :rating, :project_type, :date)");
    $stmt->bindParam(':client_name', $client_name);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':project_type', $project_type);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $testimonial_success = "Отзыв успешно добавлен!";
}

// Обработка удаления отзыва
if (isset($_GET['delete_testimonial'])) {
    $id = $_GET['delete_testimonial'];
    $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: admin.php?tab=testimonials');
    exit;
}

// Получаем текущие данные
$galleryItems = $conn->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();
$testimonials = $conn->query("SELECT * FROM testimonials ORDER BY date DESC")->fetchAll();

// Определяем активную вкладку
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'gallery';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель LLIARSSS DESIGN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    body {
        background-color: #1a1a1a;
        color: #eee;
    }
    .admin-container {
        max-width: 1200px;
        margin: 20px auto;
        background: #2a2a2a;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .admin-header {
        background-color: #1a1a1a;
        color: white;
        padding: 20px;
        border-bottom: 1px solid #df0e62;
    }
    .admin-nav {
        background-color: #1a1a1a;
    }
    .admin-nav .nav-link {
        color: rgba(255,255,255,.8);
    }
    .admin-nav .nav-link.active {
        color: white;
        background-color: rgba(223, 14, 98, 0.2);
        border-left: 3px solid #df0e62;
    }
    .admin-content {
        padding: 20px;
        background-color: #2a2a2a;
    }
    .gallery-image {
        max-width: 100px;
        height: auto;
        border-radius: 4px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .form-section {
        background: #1a1a1a;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #333;
    }
    .table {
        color: #eee;
        background-color: #2a2a2a;
    }
    .table th {
        background-color: #1a1a1a;
        border-color: #333;
        color:rgb(255, 255, 255); 
        font-weight: bold;
    }
    .table td {
        border-color: #333;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(255,255,255,0.05);
    }
    
    /* Кнопки */
    .btn-primary {
        background-color: #df0e62;
        border-color: #df0e62;
    }
    .btn-primary:hover {
        background-color: #c00d56;
        border-color: #c00d56;
    }
    .btn-danger {
        background-color: #333;
        border-color: #555;
    }
    .btn-danger:hover {
        background-color: #555;
        border-color: #777;
    }
    
    /* Формы */
    .form-control, .form-select {
        background-color: #333;
        border-color: #555;
        color: #eee;
    }
    .form-control:focus, .form-select:focus {
        background-color: #444;
        border-color: #df0e62;
        color: #eee;
        box-shadow: 0 0 0 0.25rem rgba(223, 14, 98, 0.25);
    }
    .form-text {
        color: #aaa !important;
    }
    
    /* Алерты */
    .alert-success {
        background-color: rgba(40, 167, 69, 0.2);
        border-color: rgba(40, 167, 69, 0.3);
        color: #28a745;
    }
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.2);
        border-color: rgba(220, 53, 69, 0.3);
        color: #dc3545;
    }
</style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="bi bi-shield-lock"></i> Админ-панель LLIARSSS DESIGN</h1>
            <a href="admin_logout.php" class="btn btn-danger btn-sm">Выйти</a>
        </div>
        
        <ul class="nav admin-nav">
            <li class="nav-item">
                <a class="nav-link <?= $active_tab == 'gallery' ? 'active' : '' ?>" href="?tab=gallery">Галерея</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active_tab == 'testimonials' ? 'active' : '' ?>" href="?tab=testimonials">Отзывы</a>
            </li>
        </ul>
        
        <div class="admin-content">
            <?php if ($active_tab == 'gallery'): ?>
                <h2><i class="bi bi-images"></i> Управление галереей</h2>
                
                <div class="form-section">
                    <h4>Добавить новое изображение</h4>
                    <?php if (isset($gallery_success)): ?>
                        <div class="alert alert-success"><?= $gallery_success ?></div>
                    <?php elseif (isset($gallery_error)): ?>
                        <div class="alert alert-danger"><?= $gallery_error ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Название изображения</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Изображение</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <div class="form-text">Изображение будет сохранено в папку images/</div>
                        </div>
                        <button type="submit" name="add_gallery_item" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
                
                <h4>Текущие изображения</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Изображение</th>
                                <th>Название</th>
                                <th>Путь</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($galleryItems as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['id']) ?></td>
                                <td><img src="<?= htmlspecialchars($item['image_path']) ?>" alt="Preview" class="gallery-image"></td>
                                <td><?= htmlspecialchars($item['title']) ?></td>
                                <td><?= htmlspecialchars($item['image_path']) ?></td>
                                <td>
                                    <a href="?tab=gallery&delete_gallery=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить это изображение?')">
                                        <i class="bi bi-trash"></i> Удалить
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
            <?php elseif ($active_tab == 'testimonials'): ?>
                <h2><i class="bi bi-chat-square-quote"></i> Управление отзывами</h2>
                
                <div class="form-section">
                    <h4>Добавить новый отзыв</h4>
                    <?php if (isset($testimonial_success)): ?>
                        <div class="alert alert-success"><?= $testimonial_success ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="client_name" class="form-label">Имя клиента</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Текст отзыва</label>
                            <textarea class="form-control" id="text" name="text" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Рейтинг (1-5)</label>
                            <select class="form-control" id="rating" name="rating" required>
                                <option value="5">★★★★★</option>
                                <option value="4">★★★★☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="1">★☆☆☆☆</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project_type" class="form-label">Тип проекта</label>
                            <input type="text" class="form-control" id="project_type" name="project_type" required>
                        </div>
                        <button type="submit" name="add_testimonial" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
                
                <h4>Текущие отзывы</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Текст</th>
                                <th>Рейтинг</th>
                                <th>Тип проекта</th>
                                <th>Дата</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($testimonials as $item): 
                                $stars = str_repeat('★', $item['rating']) . str_repeat('☆', 5 - $item['rating']);
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($item['id']) ?></td>
                                <td><?= htmlspecialchars($item['client_name']) ?></td>
                                <td><?= htmlspecialchars(substr($item['text'], 0, 50)) ?>...</td>
                                <td><?= $stars ?></td>
                                <td><?= htmlspecialchars($item['project_type']) ?></td>
                                <td><?= date('d.m.Y', strtotime($item['date'])) ?></td>
                                <td>
                                    <a href="?tab=testimonials&delete_testimonial=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить этот отзыв?')">
                                        <i class="bi bi-trash"></i> Удалить
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>