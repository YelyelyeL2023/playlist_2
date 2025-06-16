<?php

class BankAccount {
    private $owner;
    private $balance;
    private $accountNumber;
    private $currency;

    public function __construct($owner, $accountNumber, $currency, $initialBalance = 0) {
        $this->owner = $owner;
        $this->accountNumber = $accountNumber;
        $this->currency = $currency;
        $this->balance = $initialBalance;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Внесено {$amount} {$this->currency}. Новый баланс: {$this->balance} {$this->currency}<br>";
        } else {
            echo "Сумма для внесения должна быть положительной.<br>";
        }
    }

    public function withdraw($amount) {
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

    public function getBalance() {
        return $this->balance;
    }

    public function displayAccountInfo() {
        echo "=== Информация о счете ===<br>";
        echo "Владелец: {$this->owner}<br>";
        echo "Номер счета: {$this->accountNumber}<br>";
        echo "Текущий баланс: {$this->balance} {$this->currency}<br>";
        echo "Валюта: {$this->currency}<br>";
        echo "========================<br>";
    }
}

// Пример использования
$account = new BankAccount("Иван Петров", "123456789", "RUB", 1000);

$account->displayAccountInfo();
$account->deposit(500);
$account->withdraw(200);
$account->withdraw(2000); // Попытка снять больше, чем есть на счету
echo "Текущий баланс: " . $account->getBalance() . " RUB<br>";
