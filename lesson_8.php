<?php


// Абстрактный класс Vehicle
abstract class Vehicle
{
    // Абстрактные методы, которые должны быть реализованы в подклассах
    abstract public function start();

    abstract public function stop();

    // Можно добавить обычные методы, которые будут доступны всем подклассам
    public function getVehicleType()
    {
        return get_class($this);
    }
}

// Конкретный подкласс Car
class Car extends Vehicle
{
    public function start()
    {
        echo "🚗 Автомобиль заведен<br>";
    }

    public function stop()
    {
        echo "🚗 Автомобиль заглушен<br>";
    }
}

// Конкретный подкласс Bicycle
class Bicycle extends Vehicle
{
    public function start()
    {
        echo "🚲 Велосипед начал движение<br>";
    }

    public function stop()
    {
        echo "🚲 Велосипед остановился<br>";
    }
}

// Создание объектов и тестирование
echo "<h2>Тестирование абстрактного класса Vehicle</h2>";

// Создание объектов
echo "<h3>1. Создание объектов:</h3>";
$car = new Car();
$bicycle = new Bicycle();

echo "Создан объект: " . $car->getVehicleType() . "<br>";
echo "Создан объект: " . $bicycle->getVehicleType() . "<br><br>";

// Тестирование методов для автомобиля
echo "<h3>2. Тестирование автомобиля:</h3>";
$car->start();
echo "Автомобиль едет...<br>";
$car->stop();
echo "<br>";

// Тестирование методов для велосипеда
echo "<h3>3. Тестирование велосипеда:</h3>";
$bicycle->start();
echo "Велосипед катится...<br>";
$bicycle->stop();
echo "<br>";

// Демонстрация полиморфизма
echo "<h3>4. Демонстрация полиморфизма:</h3>";
$vehicles = [$car, $bicycle];

foreach ($vehicles as $index => $vehicle) {
    echo "Транспортное средство " . ($index + 1) . " (" . $vehicle->getVehicleType() . "):<br>";
    $vehicle->start();
    $vehicle->stop();
    echo "<br>";
}

// Попытка создать объект абстрактного класса (раскомментируйте, чтобы увидеть ошибку)
echo "<h3>5. Попытка создать объект абстрактного класса:</h3>";
echo "❌ Нельзя создать объект абстрактного класса Vehicle<br>";
echo "Следующая строка вызовет Fatal Error:<br>";
echo "<code>// \$vehicle = new Vehicle(); // Fatal error!</code><br><br>";

// Дополнительный пример с более сложной логикой
echo "<h3>6. Расширенный пример использования:</h3>";

// Функция для управления любым транспортным средством
function operateVehicle(Vehicle $vehicle)
{
    echo "Начинаем управление транспортным средством:<br>";
    $vehicle->start();
    echo "Транспортное средство в движении...<br>";
    $vehicle->stop();
    echo "Операция завершена.<br><br>";
}

echo "Управление автомобилем:<br>";
operateVehicle($car);

echo "Управление велосипедом:<br>";
operateVehicle($bicycle);

