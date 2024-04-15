<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
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
            <li><a href="employee_manage.php">Управление</a></li>
            <li><a href="welcome.php">ЛК</a></li>
            <li><a href="cart.php">Корзина</a></li>


            
        </ul>
    </nav>
</header>

    <h1>Наши контакты</h1>
    <p>Адрес: ул. Примерная, д. 123, г. Примерный</p>
        <p>Телефон: +7 (123) 456-78-90</p>
        <p>Email: info@example.com</p>

    <p>Вы можете связаться с нами, заполнив форму ниже:</p>
    <form action="send_email.php" method="post">
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="message">Сообщение:</label><br>
        <textarea id="message" name="message" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>