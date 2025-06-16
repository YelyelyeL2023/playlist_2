<?php


class User
{
    private $username;
    private $email;
    private $password;

    // Геттеры
    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        // Для безопасности возвращаем замаскированный пароль
        return str_repeat('*', strlen($this->password));
    }

    // Сеттеры с валидацией
    public function setUsername($username)
    {
        if (!is_string($username)) {
            echo "❌ Ошибка: Имя пользователя должно быть строкой.<br>";
            return false;
        }

        if (empty(trim($username))) {
            echo "❌ Ошибка: Имя пользователя не может быть пустым.<br>";
            return false;
        }

        $this->username = trim($username);
        echo "✅ Имя пользователя успешно установлено: {$this->username}<br>";
        return true;
    }

    public function setEmail($email)
    {
        if (!is_string($email)) {
            echo "❌ Ошибка: Email должен быть строкой.<br>";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "❌ Ошибка: Некорректный формат email: {$email}<br>";
            return false;
        }

        $this->email = $email;
        echo "✅ Email успешно установлен: {$this->email}<br>";
        return true;
    }

    public function setPassword($password)
    {
        if (!is_string($password)) {
            echo "❌ Ошибка: Пароль должен быть строкой.<br>";
            return false;
        }

        if (strlen($password) < 6) {
            echo "❌ Ошибка: Пароль должен содержать не менее 6 символов.<br>";
            return false;
        }

        $this->password = $password;
        echo "✅ Пароль успешно установлен (длина: " . strlen($password) . " символов)<br>";
        return true;
    }

    // Дополнительный метод для отображения информации о пользователе
    public function displayUserInfo()
    {
        echo "<h3>Информация о пользователе:</h3>";
        echo "Имя пользователя: " . ($this->username ?? 'не установлено') . "<br>";
        echo "Email: " . ($this->email ?? 'не установлен') . "<br>";
        echo "Пароль: " . ($this->password ? $this->getPassword() : 'не установлен') . "<br><br>";
    }
}

// Создание объекта и тестирование
echo "<h2>Тестирование класса User</h2>";

$user = new User();

echo "<h3>1. Установка корректных значений:</h3>";
$user->setUsername("john_doe");
$user->setEmail("john.doe@example.com");
$user->setPassword("securepassword123");

echo "<br>";
$user->displayUserInfo();

echo "<h3>2. Получение значений через геттеры:</h3>";
echo "Username: " . $user->getUsername() . "<br>";
echo "Email: " . $user->getEmail() . "<br>";
echo "Password: " . $user->getPassword() . "<br><br>";

echo "<h3>3. Тестирование валидации (некорректные данные):</h3>";

// Тестирование некорректного username
$user->setUsername("");  // Пустая строка
$user->setUsername("   ");  // Только пробелы
$user->setUsername(123);  // Не строка

echo "<br>";

// Тестирование некорректного email
$user->setEmail("invalid-email");  // Некорректный формат
$user->setEmail("@example.com");   // Неполный email
$user->setEmail(123);              // Не строка

echo "<br>";

// Тестирование некорректного пароля
$user->setPassword("123");    // Слишком короткий
$user->setPassword("");       // Пустой
$user->setPassword(123456);   // Не строка

echo "<br>";

echo "<h3>4. Создание второго пользователя:</h3>";
$user2 = new User();
$user2->setUsername("jane_smith");
$user2->setEmail("jane.smith@gmail.com");
$user2->setPassword("mypassword2024");

$user2->displayUserInfo();

echo "<h3>5. Сравнение пользователей:</h3>";
echo "Пользователь 1: " . $user->getUsername() . " (" . $user->getEmail() . ")<br>";
echo "Пользователь 2: " . $user2->getUsername() . " (" . $user2->getEmail() . ")<br>";

