<?php


class Car
{
    private $brand;      // Приватное свойство
    public $model;       // Публичное свойство
    protected $year;     // Защищенное свойство

    public function __construct($brand, $model, $year)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    // Методы для демонстрации доступа к свойствам изнутри класса
    public function getCarInfo()
    {
        return "Марка: {$this->brand}, Модель: {$this->model}, Год: {$this->year}";
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function getYear()
    {
        return $this->year;
    }
}

// Создание объекта класса Car
$car = new Car("Toyota", "Camry", 2023);

echo "<h2>Тестирование доступа к свойствам класса Car</h2>";

// Демонстрация работы метода класса (доступ ко всем свойствам изнутри класса)
echo "<h3>1. Доступ к свойствам через метод класса:</h3>";
echo $car->getCarInfo() . "<br><br>";

// Попытка обратиться к публичному свойству
echo "<h3>2. Обращение к публичному свойству (\$model):</h3>";
echo "Модель автомобиля: " . $car->model . "<br>";
echo "✅ Успешно! Публичное свойство доступно извне класса.<br><br>";

// Попытка изменить публичное свойство
$car->model = "Corolla";
echo "Изменили модель на: " . $car->model . "<br><br>";

// Попытка обратиться к приватному свойству
echo "<h3>3. Обращение к приватному свойству (\$brand):</h3>";
echo "Попытка получить марку: ";
// Раскомментируйте следующую строку, чтобы увидеть ошибку:
// echo $car->brand;
echo "❌ ОШИБКА! Нельзя обратиться к приватному свойству извне класса.<br>";
echo "Для доступа используем метод: " . $car->getBrand() . "<br><br>";

// Попытка обратиться к защищенному свойству
echo "<h3>4. Обращение к защищенному свойству (\$year):</h3>";
echo "Попытка получить год: ";
// Раскомментируйте следующую строку, чтобы увидеть ошибку:
// echo $car->year;
echo "❌ ОШИБКА! Нельзя обратиться к защищенному свойству извне класса.<br>";
echo "Для доступа используем метод: " . $car->getYear() . "<br><br>";

echo "<h3>Выводы:</h3>";
echo "<strong>private</strong> - доступно только внутри того же класса<br>";
echo "<strong>public</strong> - доступно везде (внутри класса, в наследниках, извне)<br>";
echo "<strong>protected</strong> - доступно внутри класса и его наследников<br><br>";

// Демонстрация с наследованием для показа работы protected
class SportsCar extends Car
{
    public function getCarAge()
    {
        $currentYear = date('Y');
        // Можем обратиться к protected свойству в наследнике
        return $currentYear - $this->year;
    }

    public function showProtectedAccess()
    {
        return "Год выпуска из наследника: " . $this->year;
    }
}

echo "<h3>5. Демонстрация наследования и protected:</h3>";
$sportsCar = new SportsCar("Ferrari", "488", 2020);
echo $sportsCar->showProtectedAccess() . "<br>";
echo "Возраст автомобиля: " . $sportsCar->getCarAge() . " лет<br>";

