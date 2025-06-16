<?php


// Трейт Loggable для записи логов
trait Loggable
{
    private $logFile = 'user_log.txt';

    public function log($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[{$timestamp}] {$message}" . PHP_EOL;

        // Запись в файл
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);

        // Дублирование в консоль (для веб-интерфейса)
        echo "<div style='background: #f0f0f0; padding: 10px; margin: 5px 0; border-left: 4px solid #007cba;'>";
        echo "<strong>LOG:</strong> [{$timestamp}] {$message}";
        echo "</div>";
    }

    // Дополнительный метод для чтения логов
    public function getLogs()
    {
        if (file_exists($this->logFile)) {
            return file_get_contents($this->logFile);
        }
        return "Лог файл не найден.";
    }

    // Метод для очистки логов
    public function clearLogs()
    {
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
            $this->log("Лог файл очищен");
        }
    }
}

// Класс User с использованием трейта Loggable
class User
{
    use Loggable;

    private $users = []; // Имитация базы данных пользователей

    public function register($username, $email)
    {
        // Валидация данных
        if (empty($username) || empty($email)) {
            $this->log("ОШИБКА: Попытка регистрации с пустыми данными (username: '$username', email: '$email')");
            echo "❌ Ошибка регистрации: Имя пользователя и email не могут быть пустыми<br><br>";
            return false;
        }

        // Проверка формата email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->log("ОШИБКА: Некорректный email при регистрации пользователя '$username': $email");
            echo "❌ Ошибка регистрации: Некорректный формат email<br><br>";
            return false;
        }

        // Проверка на существование пользователя
        if ($this->userExists($username, $email)) {
            $this->log("ОШИБКА: Попытка регистрации существующего пользователя '$username' с email '$email'");
            echo "❌ Ошибка регистрации: Пользователь с таким именем или email уже существует<br><br>";
            return false;
        }

        // Успешная регистрация
        $this->users[] = [
            'username' => $username,
            'email' => $email,
            'registered_at' => date('Y-m-d H:i:s')
        ];

        $this->log("Пользователь $username успешно зарегистрирован");
        echo "✅ Пользователь '$username' успешно зарегистрирован с email '$email'<br><br>";
        return true;
    }

    // Вспомогательный метод для проверки существования пользователя
    private function userExists($username, $email)
    {
        foreach ($this->users as $user) {
            if ($user['username'] === $username || $user['email'] === $email) {
                return true;
            }
        }
        return false;
    }

    // Метод для получения списка зарегистрированных пользователей
    public function getUsers()
    {
        return $this->users;
    }

    // Метод логина с использованием трейта для логирования
    public function login($username)
    {
        foreach ($this->users as $user) {
            if ($user['username'] === $username) {
                $this->log("Пользователь $username вошел в систему");
                echo "✅ Пользователь '$username' успешно вошел в систему<br><br>";
                return true;
            }
        }

        $this->log("ОШИБКА: Неудачная попытка входа пользователя '$username'");
        echo "❌ Ошибка входа: Пользователь '$username' не найден<br><br>";
        return false;
    }
}

// Тестирование
echo "<h2>Тестирование трейта Loggable и класса User</h2>";

// Создание объекта User
$userManager = new User();

echo "<h3>1. Регистрация пользователей:</h3>";

// Успешные регистрации
$userManager->register("john_doe", "john@example.com");
$userManager->register("jane_smith", "jane@gmail.com");
$userManager->register("alex_brown", "alex.brown@yahoo.com");

// Попытки регистрации с ошибками
echo "<h3>2. Тестирование валидации:</h3>";
$userManager->register("", "empty@test.com");           // Пустое имя
$userManager->register("test_user", "invalid-email");   // Некорректный email
$userManager->register("john_doe", "duplicate@test.com"); // Дублирующееся имя

echo "<h3>3. Попытки входа в систему:</h3>";
$userManager->login("john_doe");      // Существующий пользователь
$userManager->login("nonexistent");  // Несуществующий пользователь

echo "<h3>4. Список зарегистрированных пользователей:</h3>";
$users = $userManager->getUsers();
if (!empty($users)) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Имя пользователя</th><th>Email</th><th>Дата регистрации</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['username']}</td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['registered_at']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "Нет зарегистрированных пользователей<br>";
}

echo "<h3>5. Содержимое лог-файла:</h3>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
echo htmlspecialchars($userManager->getLogs());
echo "</pre>";

// Демонстрация множественного использования трейта
echo "<h3>6. Дополнительный класс с трейтом Loggable:</h3>";

class Order
{
    use Loggable;

    public function createOrder($orderId, $amount)
    {
        $this->log("Создан заказ #$orderId на сумму $amount руб.");
        echo "📦 Заказ #$orderId создан на сумму $amount руб.<br>";
    }
}

$orderManager = new Order();
$orderManager->createOrder("ORD-001", 2500);
$orderManager->createOrder("ORD-002", 1750);

echo "<h3>7. Логи заказов:</h3>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
echo htmlspecialchars($orderManager->getLogs());
echo "</pre>";

