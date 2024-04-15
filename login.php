<?php
session_start(); // Начинаем сессию

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

// Авторизация пользователя
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE Email='$email' AND Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: welcome.php"); // Перенаправляем на страницу приветствия
    } else {
        echo "Неверный адрес электронной почты или пароль";
    }
}

// Регистрация пользователя
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];


    $sql = "INSERT INTO users (name, email, password, phone) VALUES ('$name', '$email', '$password', '$phone')";


    if ($conn->query($sql) === TRUE) {
        echo "Регистрация прошла успешно!";
    } else {
        echo "Ошибка при регистрации: " . $conn->error;
    }
}

$conn->close(); // Закрываем соединение с базой данных
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="styles.css">
    <style>
         select, input[type="submit"] {
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
    </style>
</head>
<body>
<header>
        <h1>Меню</h1>
        <nav>
            <ul>
            <li><a href="index.php">Поиск</a></li>
            <li><a href="news.php">Новости</a></li>
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
    <title>Авторизация и регистрация</title>
</head>
<body>
    <h2>Авторизация</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required><br>
        
        <input type="submit" name="login" value="Войти">
    </form>

    <h2>Регистрация</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="phone">Номер телефона:</label><input type="text" id="phone" name="phone" required>
        <input type="submit" name="register" value="Зарегистрироваться">
    </form>
</body>
</html>
