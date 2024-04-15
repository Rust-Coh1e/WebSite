<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Техника</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         select, input[type="submit"], input[type="number"] {
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
        .add-to-cart-form {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0px;
            border-radius: 0px;
        }

        .add-to-cart-button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            height: auto;
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
            <li><a href="Сontacts.php">Контакты</a></li>
            <li><a href="employee.php">Работники</a></li>
            <li><a href="shops.php">Магазины</a></li>
            <li><a href="employee_manage.php">Управление</a></li>
            <li><a href="welcome.php">ЛК</a></li>
            <li><a href="cart.php">Корзина</a></li>
        </ul>
    </nav>
</header>

<table>

    <body>
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
        $email = $_SESSION['email'];
        $user_id = $_SESSION['ID_user'];
        // Подготовка SQL-запроса для получения данных о товарах в корзине пользователя
        $sql = "SELECT cart.id, cart.tech_id, Tech.Name_tech, Tech.Price, cart.quantity
                FROM cart
                INNER JOIN Tech ON cart.tech_id = Tech.ID_Tech
                WHERE cart.ID_user = ?";
        
        // Создаем подготовленное выражение
        $stmt = $conn->prepare($sql);
        
        // Привязываем параметры
        $stmt->bind_param("i", $user_id);
        
        // Выполняем запрос
        $stmt->execute();
        
        // Получаем результат запроса
        $result = $stmt->get_result();
        $total_price = 0;
        // Проверяем, есть ли товары в корзине
        if ($result->num_rows > 0) {
            echo "<h2>Корзина</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Название товара</th><th>Цена</th><th>Количество</th><th>Действие</th></tr>";
            // Выводим данные о товарах в корзине
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["Name_tech"] . "</td>";
                echo "<td>" . $row["Price"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td><form action='remove_from_cart.php' method='post'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <input type='submit' value='Удалить'>
                          </form></td>";
                echo "</tr>";
                $total_price += $row["Price"] * $row["quantity"];
            }
            echo "<tr class='total'><td colspan='5'>Общая сумма: " . $total_price . "</td></tr>";
            echo "</table>";
            
        } else {
            echo "Ваша корзина пуста";
        }
        
        // Закрываем подготовленное выражение и соединение с базой данных
        $stmt->close();
        $conn->close();
        ?>
    </body>
</table>

<!-- Добавьте кнопку для оформления заказа -->
<form action="checkout.php" method="post">
    <input type="submit" value="Оформить заказ">
</form>

<!-- Здесь может быть ваша подвал сайта -->

</body>
</html>
