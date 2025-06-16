<?php


class AppVersion
{
    // Приватное статическое свойство для хранения версии приложения
    private static $version = "1.0.0";

    // Статический метод для получения текущей версии
    public static function getVersion()
    {
        return self::$version;
    }

    // Статический метод для обновления версии
    public static function updateVersion($newVersion)
    {
        // Валидация формата версии (простая проверка)
        if (empty($newVersion) || !is_string($newVersion)) {
            echo "❌ Ошибка: Версия должна быть непустой строкой<br>";
            return false;
        }

        // Проверка формата версии (x.x.x)
        if (!preg_match('/^\d+\.\d+\.\d+$/', $newVersion)) {
            echo "❌ Ошибка: Версия должна быть в формате x.x.x (например, 1.2.3)<br>";
            return false;
        }

        $oldVersion = self::$version;
        self::$version = $newVersion;

        echo "✅ Версия приложения обновлена с $oldVersion на $newVersion<br>";
        return true;
    }

    // Дополнительный статический метод для получения информации о версии
    public static function getVersionInfo()
    {
        return [
            'version' => self::$version,
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'major.minor.patch'
        ];
    }

    // Статический метод для сравнения версий
    public static function compareVersion($compareVersion)
    {
        return version_compare(self::$version, $compareVersion);
    }

    // Статический метод для проверки, является ли версия новее
    public static function isNewerThan($compareVersion)
    {
        return version_compare(self::$version, $compareVersion) > 0;
    }
}

// Тестирование статических методов
echo "<h2>Тестирование класса AppVersion</h2>";

echo "<h3>1. Получение начальной версии:</h3>";
$currentVersion = AppVersion::getVersion();
echo "Текущая версия приложения: <strong>$currentVersion</strong><br><br>";

echo "<h3>2. Информация о версии:</h3>";
$versionInfo = AppVersion::getVersionInfo();
echo "Версия: {$versionInfo['version']}<br>";
echo "Время проверки: {$versionInfo['timestamp']}<br>";
echo "Формат: {$versionInfo['format']}<br><br>";

echo "<h3>3. Обновление версии:</h3>";

// Успешные обновления
AppVersion::updateVersion("1.1.0");
echo "Новая версия: <strong>" . AppVersion::getVersion() . "</strong><br><br>";

AppVersion::updateVersion("2.0.0");
echo "Новая версия: <strong>" . AppVersion::getVersion() . "</strong><br><br>";

AppVersion::updateVersion("2.1.5");
echo "Новая версия: <strong>" . AppVersion::getVersion() . "</strong><br><br>";

echo "<h3>4. Тестирование валидации:</h3>";

// Тесты с ошибками
AppVersion::updateVersion("");           // Пустая строка
AppVersion::updateVersion("invalid");    // Неправильный формат
AppVersion::updateVersion("1.2");        // Неполная версия
AppVersion::updateVersion(123);          // Не строка

echo "Текущая версия остается: <strong>" . AppVersion::getVersion() . "</strong><br><br>";

echo "<h3>5. Сравнение версий:</h3>";
$testVersions = ["1.0.0", "2.0.0", "2.1.5", "3.0.0"];

foreach ($testVersions as $testVersion) {
    $comparison = AppVersion::compareVersion($testVersion);
    $currentVer = AppVersion::getVersion();

    if ($comparison > 0) {
        $result = "$currentVer новее чем $testVersion";
    } elseif ($comparison < 0) {
        $result = "$currentVer старше чем $testVersion";
    } else {
        $result = "$currentVer равна $testVersion";
    }

    echo "Сравнение с $testVersion: $result<br>";
}

echo "<br>";

echo "<h3>6. Проверка на более новую версию:</h3>";
$checkVersions = ["2.0.0", "2.1.5", "3.0.0"];

foreach ($checkVersions as $checkVersion) {
    $isNewer = AppVersion::isNewerThan($checkVersion);
    $currentVer = AppVersion::getVersion();

    if ($isNewer) {
        echo "✅ Версия $currentVer новее чем $checkVersion<br>";
    } else {
        echo "❌ Версия $currentVer НЕ новее чем $checkVersion<br>";
    }
}

echo "<br>";

echo "<h3>7. Демонстрация обновлений версий:</h3>";
$versionUpdates = ["2.2.0", "2.2.1", "3.0.0", "3.1.0"];

foreach ($versionUpdates as $newVer) {
    echo "Обновление до версии $newVer:<br>";
    AppVersion::updateVersion($newVer);
    echo "Текущая версия: " . AppVersion::getVersion() . "<br><br>";
}

echo "<h3>8. Финальная информация:</h3>";
$finalInfo = AppVersion::getVersionInfo();
echo "<div style='background: #e8f5e8; padding: 15px; border: 1px solid #4caf50; border-radius: 5px;'>";
echo "<strong>Финальная версия приложения:</strong><br>";
echo "Версия: <strong>{$finalInfo['version']}</strong><br>";
echo "Проверено: {$finalInfo['timestamp']}<br>";
echo "Формат версионирования: {$finalInfo['format']}<br>";
echo "</div>";

// Демонстрация использования без создания объекта
echo "<h3>9. Использование без создания объекта:</h3>";
echo "Прямой вызов: " . AppVersion::getVersion() . "<br>";
echo "Статические методы можно вызывать без создания экземпляра класса<br>";

