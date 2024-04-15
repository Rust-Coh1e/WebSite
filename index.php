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
            <li><a href="news.php">Новости</a></li>
            <li><a href="Companies.php">Производители</a></li>
            <li><a href="Сontacts.php">Контакты</a></li>
            <li><a href="employee.php">Работники</a></li>
            <li><a href="shops.php">Магазины</a></li>

            <li><a href="welcome.php">ЛК</a></li>
            <li><a href="cart.php">Корзина</a></li>

            
        </ul>
    </nav>
</header>

<h2>Выберите критерий отбора и сортировки</h2>
<form action="" method="GET">
    <label for="type">Выберите тип техники:</label>
    <select name="type" id="type">
        <option value="">Все</option>
        <option value="5" <?php if(isset($_GET['type']) && $_GET['type'] == '5') echo 'selected'; ?>>Headphones</option>
        <option value="2" <?php if(isset($_GET['type']) && $_GET['type'] == '2') echo 'selected'; ?>>Laptops</option>
        <option value="3" <?php if(isset($_GET['type']) && $_GET['type'] == '3') echo 'selected'; ?>>Smartphones</option>
        <option value="4" <?php if(isset($_GET['type']) && $_GET['type'] == '4') echo 'selected'; ?>>Tablets</option>
        <option value="6" <?php if(isset($_GET['type']) && $_GET['type'] == '6') echo 'selected'; ?>>Televisions</option>
    </select>
    <br>
    <label for="sort">Выберите критерий сортировки:</label>
    <select name="sort" id="sort">
        <option value="Name_tech" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'Name_tech') echo 'selected'; ?>>Название</option>
        <option value="Price" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'Price') echo 'selected'; ?>>Цена</option>
        <option value="Count" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'Count') echo 'selected'; ?>>Количество</option>
    </select>
    <br>
    <input type="radio" name="order" value="ASC" <?php if(!isset($_GET['order']) || (isset($_GET['order']) && $_GET['order'] == 'ASC')) echo 'checked'; ?>> По возрастанию
    <input type="radio" name="order" value="DESC" <?php if(isset($_GET['order']) && $_GET['order'] == 'DESC') echo 'checked'; ?>> По убыванию
    <br>
    <input type="submit" value="Поиск и сортировка">
</form>
<br>

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




// Получение критериев отбора и сортировки из формы
$type = isset($_GET["type"]) ? $_GET["type"] : ""; // Проверяем, установлен ли параметр типа техники
$sort = isset($_GET["sort"]) ? $_GET["sort"] : "Name_tech"; // Проверяем, установлен ли параметр сортировки
$order = isset($_GET["order"]) ? $_GET["order"] : "ASC"; // Проверяем, установлен ли параметр направления сортировки

// Подготовка SQL-запроса с учетом критериев
$sql = "SELECT Tech.ID_Tech, Tech.Name_tech, Tech.Price, Tech.Count, Companies.Name_company AS companies, Types.Name_type AS type_tech
FROM Tech INNER JOIN Companies ON Tech.ID_companies = Companies.ID_companies INNER JOIN Types ON Tech.ID_type = Types.ID_types";

if (!empty($type)) {
    $sql .= " WHERE ID_type = $type"; // Добавляем условие WHERE только если параметр типа техники установлен
}

$sql .= " ORDER BY $sort $order";
$result = $conn->query($sql);

// Вывод результатов запроса как ранее
if ($result->num_rows > 0) {
    
    
    echo "<h2>Информация о технике</h2>";
    echo"<table><tr>
    <th>ID</th>
    <th>Название</th>
    <th>Цена</th>
    <th>Количество</th>
    <th>Производитель</th>
    <th>Тип</th>
    <th>Действие</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ID_Tech"]."</td><td>".$row["Name_tech"]."</td><td>".$row["Price"]."</td><td>".$row["Count"]."</td><td>".$row["companies"]."</td><td>".$row["type_tech"]."</td>
        <td>
        <form class='add-to-cart-form' action='add_to_cart.php' method='POST'>
            <input type='hidden' name='tech_id' value='".$row["ID_Tech"]."'>
            <input type='number' name='quantity' value='1' min='1' max='".$row["Count"]."' style='width: 60px; margin-right: 10px;'>
            <input type='submit' value='Добавить' class='add-to-cart-button' name = 'add_to_cart' >
        </form>
    
    
        </td></tr>";
    }
    echo "</table>";
} else {    
    echo "Нет данных, удовлетворяющих вашему запросу.";
}

$conn->close();

?>
</body>
</html>


