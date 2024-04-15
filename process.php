<?php
// Подключение к базе данных
$servername = "localhost";
$username = "username"; // Ваше имя пользователя
$password = "password"; // Ваш пароль
$dbname = "my_database"; // Название вашей базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение критериев отбора и сортировки из формы
$type = $_POST["type"];
$sort = $_POST["sort"];
$order = $_POST["order"];

// Подготовка SQL-запроса с учетом критериев
$sql = "SELECT * FROM Tech";

if (!empty($type)) {
    $sql .= " WHERE ID_type = $type";
}

$sql .= " ORDER BY $sort $order";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Информация о технике</h2>";
    echo "<table border='1'><tr><th>ID</th><th>Название</th><th>Цена</th><th>Количество</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ID_Tech"]."</td><td>".$row["Name_tech"]."</td><td>".$row["Price"]."</td><td>".$row["Count"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Нет данных, удовлетворяющих вашему запросу.";
}

$conn->close();
?>
