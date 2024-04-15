<?php
session_start(); // Начинаем сессию

// Подключение к базе данных
$servername = "localhost";
$username = "root"; // Ваше имя пользователя
$password = "root"; // Ваш пароль
$dbname = "lab3"; // Название вашей базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_SESSION['email']; // Почта пользователя

// Подготовка SQL-запроса для обновления данных пользователя
$sql = "UPDATE users SET Name = ?, Phone = ? WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $phone, $email); // Привязываем переменные к параметрам запроса и указываем их типы (s - строка)
$stmt->execute();

// Проверяем успешность выполнения запроса
if ($stmt->affected_rows > 0) {
    echo "Данные пользователя успешно обновлены.";
} else {
    echo "Ошибка при обновлении данных пользователя.";
}

$stmt->close();
$conn->close();
?>
