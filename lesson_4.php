<?php


class BankAccount
{
    private $owner;
    private $balance;
    private $accountNumber;
    private $currency;

    public function __construct($owner, $balance, $accountNumber, $currency)
    {
        $this->owner = $owner;
        $this->balance = $balance;
        $this->accountNumber = $accountNumber;
        $this->currency = $currency;
    }

    public function deposit($amount)
    {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Внесено {$amount} {$this->currency}. Новый баланс: {$this->balance} {$this->currency}<br>";
        } else {
            echo "Сумма для внесения должна быть положительной.<br>";
        }
    }

    public function withdraw($amount)
    {
        if ($amount > 0) {
            if ($this->balance >= $amount) {
                $this->balance -= $amount;
                echo "Снято {$amount} {$this->currency}. Новый баланс: {$this->balance} {$this->currency}<br>";
            } else {
                echo "Недостаточно средств на счету. Доступно: {$this->balance} {$this->currency}<br>";
            }
        } else {
            echo "Сумма для снятия должна быть положительной.<br>";
        }
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function displayAccountInfo()
    {
        echo "=== Информация о счете ===<br>";
        echo "Владелец: {$this->owner}<br>";
        echo "Номер счета: {$this->accountNumber}<br>";
        echo "Текущий баланс: {$this->balance} {$this->currency}<br>";
        echo "Валюта: {$this->currency}<br>";
        echo "========================<br><br>";
    }
}

// Создание объектов с разными параметрами
$account1 = new BankAccount("Иван Петров", 5000, "RU1234567890", "RUB");
$account2 = new BankAccount("Anna Smith", 1500, "US9876543210", "USD");
$account3 = new BankAccount("Jean Dupont", 2000, "FR1122334455", "EUR");

// Тестирование первого счета
echo "<h3>Тестирование счета Ивана Петрова:</h3>";
$account1->displayAccountInfo();
$account1->deposit(1500);
$account1->withdraw(800);
echo "Текущий баланс: " . $account1->getBalance() . " RUB<br><br>";

// Тестирование второго счета
echo "<h3>Тестирование счета Anna Smith:</h3>";
$account2->displayAccountInfo();
$account2->deposit(500);
$account2->withdraw(2500); // Попытка снять больше доступного
$account2->withdraw(300);
echo "Текущий баланс: " . $account2->getBalance() . " USD<br><br>";

// Тестирование третьего счета
echo "<h3>Тестирование счета Jean Dupont:</h3>";
$account3->displayAccountInfo();
$account3->deposit(800);
$account3->withdraw(-100); // Попытка снять отрицательную сумму
$account3->withdraw(1200);
echo "Текущий баланс: " . $account3->getBalance() . " EUR<br><br>";

// Финальная информация по всем счетам
echo "<h3>Итоговая информация по всем счетам:</h3>";
$account1->displayAccountInfo();
$account2->displayAccountInfo();
$account3->displayAccountInfo();

