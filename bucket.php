<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <!-- Здесь можете разместить шапку сайта -->
    </header>
    <main>
        <h1>Корзина</h1>
        <?php
        // Проверяем, есть ли товары в корзине
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Отображаем содержимое корзины
            foreach ($_SESSION['cart'] as $tech_id => $quantity) {
                // Здесь выводите информацию о товаре, используя данные из базы данных или сессии
                echo "<p>Товар ID: $tech_id, Количество: $quantity</p>";
            }
        } else {
            echo "<p>Ваша корзина пуста.</p>";
        }
        ?>
        <form action="order.php" method="post">
            <input type="submit" value="Оформить заказ">
        </form>
    </main>
    <footer>
        <!-- Здесь можете разместить подвал сайта -->
    </footer>
</body>
</html>