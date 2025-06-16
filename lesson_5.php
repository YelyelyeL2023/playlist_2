<?php


// Базовый класс Shape
class Shape
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

// Подкласс Circle (Круг)
class Circle extends Shape
{
    private $radius;

    public function __construct($name, $radius)
    {
        parent::__construct($name);
        $this->radius = $radius;
    }

    public function calculateArea()
    {
        return pi() * pow($this->radius, 2);
    }

    public function getRadius()
    {
        return $this->radius;
    }
}

// Подкласс Rectangle (Прямоугольник)
class Rectangle extends Shape
{
    private $width;
    private $height;

    public function __construct($name, $width, $height)
    {
        parent::__construct($name);
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateArea()
    {
        return $this->width * $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }
}

// Создание объектов и тестирование
echo "<h2>Тестирование фигур</h2>";

// Создаем круги
$circle1 = new Circle("Малый круг", 5);
$circle2 = new Circle("Большой круг", 10);

// Создаем прямоугольники
$rectangle1 = new Rectangle("Квадрат", 4, 4);
$rectangle2 = new Rectangle("Прямоугольник", 6, 8);

// Тестирование кругов
echo "<h3>Круги:</h3>";
echo "Название: " . $circle1->getName() . "<br>";
echo "Радиус: " . $circle1->getRadius() . "<br>";
echo "Площадь: " . round($circle1->calculateArea(), 2) . "<br><br>";

echo "Название: " . $circle2->getName() . "<br>";
echo "Радиус: " . $circle2->getRadius() . "<br>";
echo "Площадь: " . round($circle2->calculateArea(), 2) . "<br><br>";

// Тестирование прямоугольников
echo "<h3>Прямоугольники:</h3>";
echo "Название: " . $rectangle1->getName() . "<br>";
echo "Ширина: " . $rectangle1->getWidth() . ", Высота: " . $rectangle1->getHeight() . "<br>";
echo "Площадь: " . $rectangle1->calculateArea() . "<br><br>";

echo "Название: " . $rectangle2->getName() . "<br>";
echo "Ширина: " . $rectangle2->getWidth() . ", Высота: " . $rectangle2->getHeight() . "<br>";
echo "Площадь: " . $rectangle2->calculateArea() . "<br><br>";

// Демонстрация полиморфизма
echo "<h3>Все фигуры:</h3>";
$shapes = [$circle1, $circle2, $rectangle1, $rectangle2];

foreach ($shapes as $shape) {
    echo "Фигура: " . $shape->getName() . " - Площадь: " . round($shape->calculateArea(), 2) . "<br>";
}

