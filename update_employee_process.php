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

// Запрос на получение количества записей в таблице temp_employee
$count_query = "SELECT COUNT(*) AS count FROM temp_employee";
$result = $conn->query($count_query);
$count = 0;
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row["count"];
} else {
    echo "Ошибка при получении количества записей: " . $conn->error;
}

// Обработка запроса на обновление данных сотрудника

for ($i = 0; $i <= $count; $i++) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_update"])) {
        $employee_id = $_POST["employee_id"][$i];
        $name = $_POST["name"][$i];
        $phone = $_POST["phone"][$i];
        $position = $_POST["position"][$i];
        $shop_id = $_POST["shop_id"][$i];
    
        echo $employee_id . ' ' . $name . ' ' . $phone;
    
        $update_sql = "UPDATE temp_employee SET Name='$name', Phone='$phone', Position='$position', Shop_ID='$shop_id' WHERE ID_Emp='$employee_id'";
    
        if ($conn->query($update_sql) === TRUE) {
            // Данные сотрудника успешно обновлены. Перенаправляем пользователя обратно на страницу employee_manage.php
            header("Location: employee_manage.php");
            exit(); // Важно завершить выполнение скрипта после перенаправления
        } else {
            echo "Ошибка при обновлении данных сотрудника: " . $conn->error;
        }
    }
    else {
        echo "What's happen?";
    }
}



$conn->close();
?>
