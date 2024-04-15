<?php
session_start(); // Начинаем сессию

// Уничтожение сессии
session_unset(); // Очищаем данные сессии
session_destroy(); // Разрушаем сессию

// Перенаправляем пользователя на страницу входа
header("Location: login.php");
exit;
?>