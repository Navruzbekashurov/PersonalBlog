<?php

//namespace App;

//class Demo
//{
//
//    public function __call($name, $params)
//    {
//        return 'Call ' . $name . ' ' . print_r($params, true);
//    }
//
//}
//
//$name = new Demo();
//
//echo $name->move(123,12) . PHP_EOL;
//class User {
//    public readonly string $name;
//
//    public function __construct(string $name) {
//        $this->name = $name;
//    }
//}
//
//$user = new User('Ali');
//echo $user->name;
//$user->name = 'Vali';
//class Dollar
//{
//    public static function doll($value)
//    {
//        if ($value >= 1000){
//            return $value *12450;
//        }
//        return $value;
//    }
//
//}
//
//
//echo Dollar::doll(1000);
//class StringHelper
//{
//    public static function stringToUpper($string)
//    {
//        return mb_strtoupper($string, 'UTF-8');
//
//    }
//    public static function toLowercase($string)
//    {
//
//        return mb_strtolower($string,'UTF-8');
//    }
//}
//echo StringHelper::stringToUpper('vasya'). PHP_EOL;
//echo StringHelper::toLowercase('VASYA'). PHP_EOL;

//use Faker\Guesser\Name;
//
//class Discount
//{
//    private $limit;
//    private $percent;
//
//
//    public function __construct(
//        $limit, $percent
//    )
//    {
//        $this->limit = $limit;
//        $this->percent = $percent;
//    }
//
//    public function calcCost($cost)
//    {
//        if ($cost >= $this->limit) {
//            return $cost * (1 - $this->percent / 100);
//        } else {
//            return $cost;
//        }
//
//    }
//
//}
//
//$discount1 = new Discount(1000, 5);
//$discount2 = new Discount(2000, 7);
//
//echo $discount1->calcCost(1200) . PHP_EOL;
//echo $discount2->calcCost(1200) . PHP_EOL;
//
//
//$cost1 = $discount1->calcCost(1200);
//
//echo $discount2->calcCost($cost1). PHP_EOL;
//
//echo $discount2->calcCost($discount1->calcCost(1200)).PHP_EOL;


//class BankAccount
//{
//    private $balance; // tashqaridan ko‘rinmaydi
//
//    public function __construct($initialBalance = 0)
//    {
//        $this->balance = $initialBalance;
//    }
//
//    // Faqat metodlar orqali olish
//    public function getBalance()
//    {
//        return $this->balance;
//    }
//
//    // Faqat metodlar orqali o‘zgartirish
//    public function deposit($amount)
//    {
//        if ($amount > 0) {
//            $this->balance += $amount;
//        }
//    }
//
//    public function withdraw($amount)
//    {
//        if ($amount > 0 && $amount <= $this->balance) {
//            $this->balance -= $amount;
//        }
//    }
//}
//
//$account = new BankAccount(1000);
//
//// To‘g‘ridan-to‘g‘ri o‘zgartira olmaymiz:
//// $account->balance = 9999; ❌ Error
//
//$account->deposit(500);
//$account->withdraw(200);
//
//echo $account->getBalance(); // 1300

// ✅ YAXSHI: Kengaytirish uchun ochiq, o'zgartirish uchun yopiq
//interface PaymentMethod {
//    public function processPayment($amount);
//}

//class CreditCard implements PaymentMethod {
//    public function processPayment($amount) {
//    }
//}
//
//class PayPal implements PaymentMethod {
//    public function processPayment($amount) {
//        // realizatsiya
//    }
//}
//
//class PaymentProcessor {
//    public function process(PaymentMethod $payment, $amount) {
//        return $payment->processPayment($amount);
//    }
//}

//interface Operation {
//    public function calculate($a, $b);
//}
//
//class Addition implements Operation {
//    public function calculate($a, $b) {
//        return $a + $b;
//    }
//}
//
//
//$new = new Addition();
//
//echo $new->calculate(3,4);

//class Animal {
//    public function eat() {
//        echo "Hayvon ovqat yemoqda\n";
//    }
//}
//
//class Dog extends Animal {
//    public function bark() {
//        echo "Vov-vov!\n";
//    }
//}
//
//$dog = new Dog();
//$dog->eat();
//$dog->bark();

//class Animal {
//    public function makeSound() {
//        echo "Hayvon tovush chiqarmoqda\n";
//    }
//}
//
//class Dog extends Animal {
//    public function makeSound() {
//        echo "Vov-vov!\n";
//    }
//}
//
//class Cat extends Animal {
//    public function makeSound() {
//        echo "Miyov!\n";
//    }
//}
//
//// Polimorfizm amalda
//$animals = [new Dog(), new Cat()];
//
//foreach ($animals as $animal) {
//    $animal->makeSound();
//    // Dog -> Vov-vov
//    // Cat -> Miyov
//}

//use DivisionByZeroError;
//
//try {
//    $x = 10 / 0; // nolga bo‘lish xatosi
//} catch (DivisionByZeroError $e) {
//    echo "Xato: " . $e->getMessage();
//}
//class Base
//{
//
//
//    public function first()
//    {
//        return "first";
//
//    }
//}
//
//
//class Sub extends Base
//{
//
//    public $date = 2000-03-21;
//
//    public function first()
//    {
//       return parent::first();
//        //return "first_2";
//
//    }
//
//
//    public function second()
//    {
//
//        return "second";
//
//    }
//
//}
//
//
//
//$base = new Base();
//
//echo $base->first().PHP_EOL;
//
//
//$sub = new Sub();
//
//echo $sub->first().PHP_EOL;
//echo $sub->second().PHP_EOL;
//class Base
//{
//    public function first()
//    {
//        return "first";
//    }
//
//    protected function second()
//    {
//
//        return "second" . $this->third();
//
//    }
//
//    private function third()
//    {
//
//        return PHP_EOL."second";
//    }
//}
//class Sub extends Base
//{
//
//    public $date = 2000-03-21;
//    public function first()
//    {
////        return parent::first();
//        return "first_2 " . $this->second();
//    }
//}
//
//$base = new Base();
//
//echo $base->first().PHP_EOL;
//
//
//$sub = new Sub();
//
//echo $sub->first().PHP_EOL;
////echo $sub->second().PHP_EOL;

//class ImmutableUser
//{
//    private $name;
//
//    public function __construct($name)
//    {
//        $this->name = $name;
//    }
//
//    public function withName($newName)
//    {
//        return new self($newName);
//    }
//
//    public function getName()
//    {
//        return $this->name;
//    }
//}
//
//$name = new ImmutableUser("Ali");
//
//$name2 = $name->withName("Vali");
//
//echo $name->getName() . PHP_EOL;
//echo $name2->getName() . PHP_EOL;
//
//
//echo $name->getName();


//class User
//{
//    private $name;
//
//    public function setName($name)
//    {
//        $this->name = $name;
//    }
//
//    public function getName()
//    {
//        return $this->name;
//    }
//}
//
//$user = new User();
//$user->setName("Ali");
//echo $user->getName(); // Ali
//
//
//class Bird
//{
//    public function sound()
//    {
//        echo "Chirp";
//    }
//}
//
//class Cat
//{
//    public function sound()
//    {
//echo
//"Meow";}
//}
//$animals = [new Bird(), new Cat()];
//foreach ($animals as $a) {
//    $a->sound();
//}// Chirp// Meow


//class Dog
//{
//
//    public $name;
//    public static $weight = 25;
//
//    public function run()
//    {
//       echo self::eat();
//        return $this->bark();
//
//
//    }
//
//
//    public function bark()
//    {
//        return "vov vov";
//
//    }
//
//    public static function eat()
//    {
//        return "eating";
//
//    }
//
//
//}
//
//
//$tarzan = new Dog();
//
//$tarzan->name = "tarzan";
//
//echo $tarzan->run();
//echo $tarzan->name;
//
//echo Dog::$weight;

//echo Dog::eat();

//namespace point;
//interface Point
//{
//public function getPointCoordinates();
//}
//
//namespace canvas;
//class Canvas
//{
//    public function paint(Point $point)
//    {
//        list($x,$y,$z) = $point->getPointCoordinates();
//        return "[x=$x;y=$y;z=$z;]\n";
//    }
//}
//namespace decartpoint;
//
//class DecartPoint implements \point\Point
//{
//    public $x;
//    public $y;
//    public $z;
//    public function __construct($x,$y,$z)
//    {
//        $this->x = $x;
//        $this->y = $y;
//        $this->z = $z;
//    }
//    public function getPointCoordinates()
//    {
//        return [$this->x,$this->y,$this->z];
//    }
//}
//
//
//use canvas\Canvas;
//
//
//
//$canvas = new Canvas();
//$point = new DecartPoint(3,5,7);
//
//
//echo $canvas->paint($point);
//
//echo get_class($canvas) . PHP_EOL;
//echo get_class($point) . PHP_EOL;





