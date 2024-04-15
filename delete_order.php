<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id']; // Получаем ID заказа для удаления

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "lab3";

    // Создание подключения к базе данных
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Удаление связанных записей из таблицы pos_in_buy
    $sql_delete_pos_in_buy = "DELETE FROM pos_in_buy WHERE ID_buy = ?";
    $stmt_delete_pos_in_buy = $conn->prepare($sql_delete_pos_in_buy);
    $stmt_delete_pos_in_buy->bind_param("i", $order_id);

    if ($stmt_delete_pos_in_buy->execute()) {
        // Удаление заказа из таблицы buy после успешного удаления связанных записей
        $sql_delete_order = "DELETE FROM buy WHERE ID_buy = ?";
        $stmt_delete_order = $conn->prepare($sql_delete_order);
        $stmt_delete_order->bind_param("i", $order_id);

        if ($stmt_delete_order->execute()) {
            echo "Заказ успешно удален.";
        } else {
            echo "Ошибка при удалении заказа: " . $conn->error;
        }

        $stmt_delete_order->close();
    } else {
        echo "Ошибка при удалении заказа: " . $conn->error;
    }

    // Закрываем подготовленные выражения и соединение с базой данных
    $stmt_delete_pos_in_buy->close();
    $conn->close();
} else {
    echo "Неверный метод запроса.";
}
?>
