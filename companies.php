
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
                <li><a href="Companies.php">Производители</a></li>
                <li><a href="tech.php">Товары</a></li>
                <li><a href="employee.php">Работники</a></li>
                <li><a href="shops.php">Магазины</a></li>
                <li><a href="employee_manage.php">Управление</a></li>
            </ul>
        </nav>
    </header>

    <h1>Производители</h1>

    <!-- Ваш остальной контент -->

</body>
</html>

<?php   
    include "setup.php";
    echo"<table><tr>
    <th>ID</th>
    <th>Название</th>
    </tr>";
    $kkk= mysqli_query($obj, "select DISTINCT ID_companies, Name_company from companies");
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

