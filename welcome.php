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

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Перенаправляем на страницу входа, если пользователь не авторизован
    exit;
}

$email = $_SESSION['email'];

$query = $conn->prepare("SELECT ID_User, Name, Email, Phone FROM users WHERE Email = ?");
$query->bind_param("s", $email); // Привязываем переменную к параметру запроса и указываем ее тип (s - строка)
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    // Вывод информации о пользователе
    $row = $result->fetch_assoc();
    $name = $row['Name']; // Обращение к полю 'Name' вместо 'username'
    $email = $row['Email'];
    $phone = $row['Phone'];

    $_SESSION['ID_user'] = $row['ID_User'];
} else {
    echo "Ошибка: Не удалось найти информацию о пользователе.";
}

$conn->close(); // Закрываем соединение с базой данных
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         select, input[type="submit"], input[type="text"] {
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

<main>
    <h1>Личный кабинет</h1>
    <h2>Данные о пользователе:</h2>
    <form action="update_user.php" method="post">
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" disabled><br>
        <label for="phone">Телефон:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"><br>
        <input type="submit" value="Сохранить изменения">
    </form>

    <form action="logout.php" method="post">
        <input type="submit" value="Выход">
    </form>

    <table>
        <tr>
            <th>Заказ</th>
            <th>Сумма</th>
            <th>Время</th>
        </tr>
        <?php
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "lab3";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION['ID_user'];

        // Получение списка покупок пользователя
        $sql = "SELECT * FROM buy WHERE ID_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID_buy'] . "</td>";
                echo "<td>" . $row['Total'] . " руб.</td>";
                echo "<td>" . $row['Timing'] . "</td>";
                echo "<td><form action='delete_order.php' method='post'><input type='hidden' name='order_id' value='" . $row['ID_buy'] . "'><input type='submit' value='Удалить'></form></td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>У вас пока нет заказов.</td></tr>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </table>
</main>
<footer>
    <!-- Здесь можете разместить подвал сайта -->
</footer>
</body>
</html>
