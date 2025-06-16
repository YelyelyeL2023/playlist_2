<?php


// Интерфейс DataFormat
interface DataFormat
{
    public function encode($data);

    public function decode($data);
}

// Класс для работы с JSON форматом
class JsonFormat implements DataFormat
{
    public function encode($data)
    {
        $result = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($result === false) {
            throw new Exception("Ошибка кодирования JSON: " . json_last_error_msg());
        }
        return $result;
    }

    public function decode($data)
    {
        $result = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Ошибка декодирования JSON: " . json_last_error_msg());
        }
        return $result;
    }
}

// Класс для работы с XML форматом
class XmlFormat implements DataFormat
{
    public function encode($data)
    {
        if (!is_array($data)) {
            throw new Exception("Для XML кодирования данные должны быть массивом");
        }

        $xml = new SimpleXMLElement('<root/>');
        $this->arrayToXml($data, $xml);
        return $xml->asXML();
    }

    public function decode($data)
    {
        if (!is_string($data)) {
            throw new Exception("Для XML декодирования данные должны быть строкой");
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($data);

        if ($xml === false) {
            $errors = libxml_get_errors();
            $errorMessage = "Ошибка парсинга XML: ";
            foreach ($errors as $error) {
                $errorMessage .= $error->message;
            }
            throw new Exception($errorMessage);
        }

        return $this->xmlToArray($xml);
    }

    // Вспомогательный метод для конвертации массива в XML
    private function arrayToXml($data, $xml)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key;
            }

            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }

    // Вспомогательный метод для конвертации XML в массив
    private function xmlToArray($xml)
    {
        $array = [];

        foreach ($xml as $key => $value) {
            if ($value->count() > 0) {
                $array[$key] = $this->xmlToArray($value);
            } else {
                $array[$key] = (string)$value;
            }
        }

        return $array;
    }
}

// Тестирование
echo "<h2>Тестирование интерфейса DataFormat</h2>";

// Создание объектов
$jsonFormat = new JsonFormat();
$xmlFormat = new XmlFormat();

// Тестовые данные
$testData = [
    'name' => 'Иван Петров',
    'age' => 30,
    'city' => 'Москва',
    'hobbies' => ['чтение', 'программирование', 'спорт'],
    'address' => [
        'street' => 'Ленинский проспект',
        'house' => '15',
        'apartment' => '42'
    ]
];

echo "<h3>Исходные данные:</h3>";
echo "<pre>";
print_r($testData);
echo "</pre>";

// Тестирование JSON формата
echo "<h3>1. Тестирование JSON формата:</h3>";

try {
    // Кодирование в JSON
    $jsonEncoded = $jsonFormat->encode($testData);
    echo "<h4>Закодированные JSON данные:</h4>";
    echo "<pre>" . htmlspecialchars($jsonEncoded) . "</pre>";

    // Декодирование из JSON
    $jsonDecoded = $jsonFormat->decode($jsonEncoded);
    echo "<h4>Декодированные JSON данные:</h4>";
    echo "<pre>";
    print_r($jsonDecoded);
    echo "</pre>";

    // Проверка соответствия
    echo "<h4>Результат:</h4>";
    if ($testData === $jsonDecoded) {
        echo "✅ JSON кодирование/декодирование прошло успешно!<br><br>";
    } else {
        echo "❌ Ошибка в JSON кодировании/декодировании<br><br>";
    }

} catch (Exception $e) {
    echo "❌ Ошибка JSON: " . $e->getMessage() . "<br><br>";
}

// Тестирование XML формата
echo "<h3>2. Тестирование XML формата:</h3>";

try {
    // Кодирование в XML
    $xmlEncoded = $xmlFormat->encode($testData);
    echo "<h4>Закодированные XML данные:</h4>";
    echo "<pre>" . htmlspecialchars($xmlEncoded) . "</pre>";

    // Декодирование из XML
    $xmlDecoded = $xmlFormat->decode($xmlEncoded);
    echo "<h4>Декодированные XML данные:</h4>";
    echo "<pre>";
    print_r($xmlDecoded);
    echo "</pre>";

    echo "<h4>Результат:</h4>";
    echo "✅ XML кодирование/декодирование выполнено<br>";
    echo "ℹ️ Примечание: XML формат может изменить структуру массивов<br><br>";

} catch (Exception $e) {
    echo "❌ Ошибка XML: " . $e->getMessage() . "<br><br>";
}

// Демонстрация полиморфизма
echo "<h3>3. Демонстрация полиморфизма:</h3>";

function processData(DataFormat $formatter, $data, $formatName)
{
    try {
        echo "<h4>Обработка данных через {$formatName}:</h4>";
        $encoded = $formatter->encode($data);
        echo "Кодирование: ✅ Успешно<br>";

        $decoded = $formatter->decode($encoded);
        echo "Декодирование: ✅ Успешно<br>";

        return $decoded;
    } catch (Exception $e) {
        echo "❌ Ошибка: " . $e->getMessage() . "<br>";
        return null;
    }
}

$simpleData = ['message' => 'Привет, мир!', 'timestamp' => date('Y-m-d H:i:s')];

$formats = [
    'JSON' => $jsonFormat,
    'XML' => $xmlFormat
];

foreach ($formats as $name => $formatter) {
    processData($formatter, $simpleData, $name);
    echo "<br>";
}

// Тестирование обработки ошибок
echo "<h3>4. Тестирование обработки ошибок:</h3>";

// Некорректный JSON
try {
    $invalidJson = '{"name": "test", "invalid": }';
    $jsonFormat->decode($invalidJson);
} catch (Exception $e) {
    echo "JSON ошибка: " . $e->getMessage() . "<br>";
}

// Некорректный XML
try {
    $invalidXml = '<root><name>test</name><unclosed>';
    $xmlFormat->decode($invalidXml);
} catch (Exception $e) {
    echo "XML ошибка: " . $e->getMessage() . "<br>";
}

