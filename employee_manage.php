<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Техника</title>
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
        display: flex;
        flex-direction: column;
        max-width: 300px; /* Ширина формы, чтобы избежать слишком широких полей на больших экранах */
        margin: auto; /* Центрирование формы на странице */
        }
        label {
            margin-bottom: 5px; /* Отступ между метками и полями ввода */
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
                <li><a href="tech.php">Товары</a></li>
                <li><a href="employee.php">Работники</a></li>
                <li><a href="shops.php">Магазины</a></li>
                <li><a href="employee_manage.php">Управление</a></li>
            </ul>
        </nav>
    </header>

    <h2>Добавить нового сотрудника</h2>
    <form action="" method="post">
        <label for="name">Имя:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="phone">Телефон:</label>
        <input type="text" name="phone" id="phone">
        <br>
        <label for="position">Должность:</label>
        <input type="text" name="position" id="position">
        <br>
        <label for="shop_id">ID магазина:</label>
        <input type="number" name="shop_id" id="shop_id">
        <br>
        <input type="submit" name="submit_add" value="Добавить">
    </form>
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


    // Создание временной таблицы (типа MEMORY) для сотрудников
    $create_table_sql = "CREATE TABLE IF NOT EXISTS temp_employee (
        ID_Emp INT(11) AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(50) NOT NULL,
        Phone VARCHAR(15),
        Position VARCHAR(50),
        Shop_ID INT(11)
    ) ENGINE=MEMORY;";

    if ($conn->query($create_table_sql) === TRUE) {
        echo "Временная таблица успешно создана.";
    } else {
        echo "Ошибка при создании временной таблицы: " . $conn->error;
    }

    // Обработка добавления записей
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_add"])) {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $position = $_POST["position"];
        $shop_id = $_POST["shop_id"];

        $insert_sql = "INSERT INTO temp_employee (Name, Phone, Position, Shop_ID) VALUES ('$name', '$phone', '$position', '$shop_id')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "Новая запись успешно добавлена.";
        } else {
            echo "Ошибка при добавлении записи: " . $conn->error;
        }
    }

    // Обработка удаления записей
    if (isset($_GET["delete_id"])) {
        $delete_id = $_GET["delete_id"];

        $delete_sql = "DELETE FROM temp_employee WHERE ID_Emp = $delete_id";

        if ($conn->query($delete_sql) === TRUE) {
            echo "Запись успешно удалена.";
        } else {
            echo "Ошибка при удалении записи: " . $conn->error;
        }
    }

    // Получение данных из временной таблицы
    $select_sql = "SELECT * FROM temp_employee";
    $result = $conn->query($select_sql);

    if ($result->num_rows > 0) {
        echo "<h2>Данные сотрудников</h2>";
        echo "<form method='post' action='update_employee_process.php'>"; // Добавляем форму для отправки данных при нажатии кнопки "изменить сейчас"
        echo "<table>";
        echo "<tr><th>ID</th><th>Имя</th><th>Телефон</th><th>Должность</th><th>ID магазина</th><th>Действие</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID_Emp"] . "</td>";
            echo "<input type='hidden' name='employee_id[]' value='" . $row["ID_Emp"] . "'>";
            echo "<td><input type='text' name='name[]' value='" . $row["Name"] . "'></td>";
            echo "<td><input type='text' name='phone[]' value='" . $row["Phone"] . "'></td>";
            echo "<td><input type='text' name='position[]' value='" . $row["Position"] . "'></td>";
            echo "<td><input type='text' name='shop_id[]' value='" . $row["Shop_ID"] . "'></td>";
            echo "<td><a href='?delete_id=".$row["ID_Emp"]."'>Удалить</a></td>";
            echo "<td><button type='submit' name='submit_update' value='" . $row["ID_Emp"] . "'>Изменить сейчас</button></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>"; // Закрываем форму
    } else {
        echo "Нет данных о сотрудниках.";
    }


    $conn->close();
    ?>
    
    <br>
 
</body>
</html>