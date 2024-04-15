<?php
session_start();

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, установлен ли идентификатор товара в POST-запросе
    if (isset($_POST['id'])) {
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

        // Подготовка SQL-запроса для удаления товара из корзины
        $sql = "DELETE FROM cart WHERE id = ?";
        
        // Создаем подготовленное выражение
        $stmt = $conn->prepare($sql);

        // Привязываем параметры
        $stmt->bind_param("i", $_POST['id']);
        

        // Выполняем запрос
        if ($stmt->execute()) {
            echo "Товар успешно удален из корзины";
        } else {
            echo "Ошибка при удалении товара из корзины: " . $conn->error;
        }

        // Закрываем подготовленное выражение и соединение с базой данных
        $stmt->close();
        $conn->close();
    } else {
        echo "Идентификатор товара не был отправлен";
    }
} else {
    echo "Неверный метод запроса";
}
header("Location: cart.php");
exit;
?>
