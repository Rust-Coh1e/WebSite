<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

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

// Получаем идентификатор пользователя
$user_id = $_SESSION['ID_user'];
$email= $_SESSION['email'];
echo "user_id: " . $user_id; // Проверка
// Подготовка SQL-запроса для получения общей суммы заказа
$sql_total = "SELECT SUM(Tech.Price * cart.quantity) AS total_price
              FROM cart
              INNER JOIN Tech ON cart.tech_id = Tech.ID_Tech
              WHERE cart.Id_user = ?";

$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $user_id);
$stmt_total->execute();
$result_total = $stmt_total->get_result();

if ($result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $total_price = $row_total["total_price"];
    echo "Total Price: " . $total_price; // Проверка
}

// Создаем новую запись в таблице BUY
$sql_buy = "INSERT INTO buy (ID_user, total, timing) VALUES (?, ?, CURRENT_TIMESTAMP)";
$stmt_buy = $conn->prepare($sql_buy);
$stmt_buy->bind_param("id", $user_id, $total_price);
$stmt_buy->execute();
$buy_id = $stmt_buy->insert_id; // Получаем ID новой записи




// Переносим данные из временной таблицы в pos in buy
$sql_pos_in_buy = "INSERT INTO pos_in_buy (ID_buy, ID_tech, count) 
                   SELECT ?, tech_id, quantity FROM cart WHERE Id_user = ?";
$stmt_pos_in_buy = $conn->prepare($sql_pos_in_buy);
$stmt_pos_in_buy->bind_param("ii", $buy_id, $user_id);
$stmt_pos_in_buy->execute();

// Очищаем временную таблицу cart
$sql_clear_cart = "DELETE FROM cart WHERE Id_user = ?";
$stmt_clear_cart = $conn->prepare($sql_clear_cart);
$stmt_clear_cart->bind_param("i", $user_id);
$stmt_clear_cart->execute();

// Закрываем подготовленные выражения и соединение с базой данных
$stmt_total->close();
$stmt_buy->close();
$stmt_pos_in_buy->close();
$stmt_clear_cart->close();
$conn->close();

// Перенаправляем пользователя на страницу личного кабинета
header("Location: welcome.php");
exit;
?>