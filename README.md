# Omnipay: PaymentgateRu (Alfabank)

**PaymentgateRu (Альфабанк) драйвер для библиотеки Omnipay PHP**

[![Build Status](https://api.travis-ci.org/pinguinjkeke/omnipay-paymentgateru.svg)](https://travis-ci.org/pinguinjkeke/omnipay-paymentgateru)
[![Latest Stable Version](https://poser.pugx.org/pinguinjkeke/omnipay-paymentgateru/version.png)](https://packagist.org/packages/pinguinjkeke/omnipay-paymentgateru)
[![Total Downloads](https://poser.pugx.org/pinguinjkeke/omnipay-paymentgateru/d/total.png)](https://packagist.org/packages/pinguinjkeke/omnipay-paymentgateru)

[Omnipay](https://github.com/thephpleague/omnipay) - это независимая от фреймворков библиотека для PHP 5.3+,
поддерживающая работу с несколькими шлюзами.

Данный пакет добавляет поддержку для платежного шлюза Альфабанка paymentgate.ru.

## Установка

Лучший способ - установка через [Composer](http://getcomposer.org/). Просто добавьте в ваш `composer.json`:

```
composer require "pinguinjkeke/omnipay-paymentgateru"
```
Для PHP 5.3 - 7.0 используйте версии 2.*

Запустите composer для обновления:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Простое использование

Ознакомьтесь с документацией по работе с основной библиотекой в репозитории [Omnipay](https://github.com/thephpleague/omnipay).

В этой секции будут описаны простейшие кейсы для работы с библиотекой (списание и возврат средств).
С реализацией остальных методов REST API шлюза вы можете ознакомится в ```src/Message```.

```php
// Авторизация платежа
$response = Gateway::authorize([
    'orderNumber' => $orderUuidOrNumber, // Уникальная строка заказа
    'amount' => $price * 100, // Цена в копейках
    'currency' => 810, // Валюта (по-умолчанию, рубль)
    'description' => 'Какое-либо описание заказа', // Строка с описанием заказа
    'returnUrl' => 'http://yoursite.com/payment/success', // URL успешной оплаты
    'failUrl' => 'http://yoursite.com/payment/failure', // URL провальной оплаты
    'clientId' => 123 // ID пользователя (используется для привязки карты)
])
    ->setUserName('merchant_login')
    ->setPassword('merchant_password')
    ->send();
    
// Чтобы получить id заказа, который присвоил банк
$bankOrderId = $response->getTransactionId();

// Успешно ли все прошло?
$success = $response->isSuccess();

// Возврат средств
$response = Gateway::refund([
    'orderId' => $bankOrderId, // Идентификатор заказа на стороне банка
    'amount' => $price * 100 // Цена в копейках
])
    ->setUserName('merchant_login')
    ->setPassword('merchant_password')
    ->send();

$success = $response->isSuccess();
```
## Подготовка к ФЗ-54
Пакет реализует последние имзенения и поддерживает работу с онлайн-кассами по ФЗ-54.

Класс заказа в вашей системе должен реализовывать интерфейс ```Omnipay\PaymentgateRu\OrderBundle\OrderInterface```
```php
class Order extends EloquentModel implements OrderInterface
{
    // Должен вернуть массив товаров, реализовывающих OrderItemInterface
    public function getItems(): iterable
    {
        return $this->cart;
    }
    
    // Должен вернуть пользователя CustomerInterface
    public function getCustomer(): ?string
    {
        return $this->customer;
    }
    
    public function getCreationDate(): int
    {
        return $order->created_at->getTimestamp();
    }
}
```
Для работы с функционалом доставки, заказ должен реализовывать интерфейс ```Omnipay\PaymentgateRu\OrderBundle\OrderDeliverableInterface```.
```php
class Order extends EloquentModel implements OrderInterface, OrderDeliverableInterface
{
    // Наименование способа доставки или null
    public function getDeliveryType(): ?string
    {
        $this->delivery->name;
    }
    
    // Двухсимвольный код страны доставки RU, EN
    public function getCountry(): ?string
    {
        return $this->delivery->country;
    }
    
    // Город доставки
    public function getCity(): ?string
    {
        return $this->delivery->city;
    }
    
    // Адрес доставки
    public function getPostAddress(): ?string
    {
        return $this->delivery->address;
    }
}
```
Метод заказа ```getCustomer()``` должен возвращать null, если функционал не используется или ```Omnipay\PaymentgateRu\OrderBundle\CustomerInterface```.
```php
class User extends EloquentModel implements CustomerInterface
{
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    public function getPhone(): ?string
    {
        return preg_replace('/\D/', '', $this->phone);
    }
    
    // Альтернативный способ связи с пользователем
    public function getContact(): ?string
    {
        return "Fax: {$this->user->fax}";
    }
}
```
Товар в корзине должен реализовывать интерфейс OrderItemInterface.
```php
class CartProduct extends EloquentModel implements OrderItemInterface
{
    // Название товара
    public function getName(): string
    {
        return $this->name;
    }
    
    // Артикул товара
    public function getCode()
    {
        return $this->product->article;
    }
    
    // Единицы измерения
    public function getMeasure(): string
    {
        return 'шт.';
    }
    
    // Количество товара
    public function getQuantity(): float
    {
        return $this->quantity;
    }
    
    // Цена на один товар
    public function getPrice(): float
    {
        return $this->product->price;
    }
    
    // Валюта в формате ISO-4217
    // По правилам банка, все товары, переданные в одном заказе должны быть в одной валюте!
    public function getCurrency(): string
    {
        return $this->product->currency;
    }
    
    // Цена на товар с учетом количества
    public function getAmount(): float
    {
        return $this->getPrice() * $this->getQuantity();
    }
    
    // Если есть необходимость в передаче дополнительных свойств, иначе - null
    public function getDetailParams(): array
    {
        return [
            'color' => $this->product->color,
            'size' = $this->product->size
        ];
    }
    
    // percent - скидка в процентах, value - фиксированная скидка, null - не используется
    public function getDiscountType(): ?string
    {
        return 'percent';
    }
    
    // Размер скидки
    public function getDiscountValue(): float
    {
        return $this->getPrice() * 0.1;
    }
}
```
Если в рамках вашей системы возможно использование нескольких систем налогообложения для разных товаров
, то взгляните на интерфейс ```OrderItemTaxableInterface```.

К методу авторизации заказа в банке необходимо прикрепить ```Omnipay\PaymentgateRu\OrderBundle\OrderBundle```
и в качестве аргумента конструктора передать ваш заказ ```OrderInterface```
```php
$orderBundle = new OrderBundle(
    $orderRepository->find($orderId)
);

$response = Gateway::authorize([
    'orderNumber' => $orderUuidOrNumber, // Уникальная строка заказа
    'amount' => $price * 100, // Цена в копейках
    'currency' => 810, // Валюта (по-умолчанию, рубль)
    'description' => 'Какое-либо описание заказа', // Строка с описанием заказа
    'returnUrl' => 'http://yoursite.com/payment/success', // URL успешной оплаты
    'failUrl' => 'http://yoursite.com/payment/failure', // URL провальной оплаты
    'clientId' => 123 // ID пользователя (используется для привязки карты)
    'taxSystem
])
    ->setUserName('merchant_login')
    ->setPassword('merchant_password')
    ->setTaxSystem(Gateway::TAX_SYSTEM_COMMON) // Указать систему налогообложения
    ->setOrderBundle($orderBundle)  // Необходимо прикрепить OrderBundle к заказу
    ->send();
```


## Поддержка

Я стараюсь поддерживать пакет по мере обновления документации pyamentgate.

Если вы нашли какие-то проблемы я с радостью рассмотрю issue или приму pull request.
