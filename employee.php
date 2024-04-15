
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
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

    <h1>Наши Работники</h1>

    <!-- Ваш остальной контент -->

</body>
</html>

<?php   
    include "setup.php";
    echo"<table><tr>
    <th>ID</th>
    <th>Имя</th>
    <th>Телефон</th>
    <th>Должность</th>
    <th>Магазин</th>
    </tr>";
    $kkk= mysqli_query($obj, "SELECT Employee.ID_Emp, Employee.Name, Employee.Phone, Position.job_title AS Position, Shops.Adress AS Store_Adress
    FROM Employee
    INNER JOIN Position ON Employee.ID_pos = Position.ID_pos
    INNER JOIN Shops ON Employee.ID_shop = Shops.ID_shop;");
    foreach ($kkk as $row)
    {
    echo"<tr>";
    foreach ($row as $key => $result)
    {
        echo"<td>".$result."</td>";
    }
    echo"</tr>";
    }
    echo"</table>"
    
?>

