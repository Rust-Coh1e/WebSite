<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Проверяем, существует ли сессия пользователя
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    header("Location: login.php");
    exit;
}

if (isset($_POST['add_to_cart'])) {
    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "lab3";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $tech_id = $_POST['tech_id'];
    $quantity = $_POST['quantity'];

    // Подготовленный запрос для добавления товара в корзину
    $email = $_SESSION['email'];
    $user_id = $_SESSION['ID_user'];
    
    $stmt = $conn->prepare("INSERT INTO cart ( tech_id, quantity, ID_user) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Ошибка при подготовке запроса: " . $conn->error);
        }
    $stmt->bind_param("iii",  $tech_id, $quantity, $user_id);

    try {
        if ($stmt->execute()) {
            echo "Товар успешно добавлен в корзину";
        } else {
            echo "Ошибка при добавлении товара в корзину: " . $conn->error;
        }
    } catch (Exception $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }

    $stmt->close();
    $conn->close();

}

// Перенаправляем обратно на страницу поиска (index.php)
header("Location: index.php");
exit;
?>
