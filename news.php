<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root"; // Ваше имя пользователя
$password = "root"; // Ваш пароль
$dbname = "lab3"; // Название вашей базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
// SQL запрос для выборки новостей из базы данных
$sql = "SELECT * FROM news ORDER BY date_published DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         select, input[type="submit"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #cccccc;
            margin-bottom: 20px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 30%;
        }
        .add-to-cart-form {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0px;
            border-radius: 0px;
        }

        .add-to-cart-button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            height: auto;
        }


    </style>
</head>
<body>
<header>
    <h1>Меню</h1>
    <nav>
        <ul>
            <li><a href="index.php">Поиск</a></li>
            <li><a href="Companies.php">Производители</a></li>
            <li><a href="Сontacts.php">Контакты</a></li>
            <li><a href="employee.php">Работники</a></li>
            <li><a href="shops.php">Магазины</a></li>
            <li><a href="employee_manage.php">Управление</a></li>
            <li><a href="welcome.php">ЛК</a></li>
            <li><a href="cart.php">Корзина</a></li>

            
        </ul>
    </nav>
    </header>
    <h2>О нашем магазине</h2>
        <p>Магазин техники предлагает широкий выбор высококачественной техники по доступным ценам. Мы специализируемся на продаже компьютеров, но также предлагаем другие электронные устройства, аксессуары и комплектующие.</p>
        <h2>Наши услуги</h2>
        <ul>
            <li>Продажа компьютеров и ноутбуков</li>
            <li>Ремонт и обслуживание техники</li>
            <li>Консультации специалистов</li>
            <li>Доставка по всей стране</li>
        </ul>
    
    <h2>Новости</h2>
    <?php

    // Проверяем, есть ли новости в результате запроса
    if ($result && $result->num_rows > 0) {
        // Выводим новости в виде списка
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li><h2>" . $row["title"] . "</h2>";
            echo "<p>" . $row["content"] . "</p>";
            echo "<p><strong>Дата публикации:</strong> " . $row["date_published"] . "</p></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Нет доступных новостей.</p>";
    }
    ?>
</body>
</html>
