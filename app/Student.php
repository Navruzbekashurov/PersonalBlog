<?php

//namespace App;
//
//class Student
//{
//
//    var $firstName;
//    var $lastName;
//    var $birthDate;
//
//
//    function getFullName()
//    {
//
//        return $this->lastName . ' ' . $this->firstName;
//    }
//
//}
//
//$student1 = new Student();
//
//$student1->firstName = 'Vasya';
//$student1->lastName = 'pupkin';
//
//$student2  = clone $student1;
//$student2->firstName = 'petya';
//
//
//echo $student1->getFullName() . PHP_EOL;
//echo $student2->getFullName() . PHP_EOL;
//$array = [3, 7, 1];
//sort($array);
//print_r($array); // [1, 3, 7]

//function a($a, $b) {
//    $b = $a + 7;  // $b faqat funksiya ichida o'zgaradi
//}
//
//$a = 5;
//a(3, $a);
//echo $a; // 5 - o'zgarmadi
//
//
//function b($a, &$b) {
//    $b = $a + 7;  // $b asl o'zgaruvchini o'zgartiradi
//}
//
//$a = 5;
//b(3, $a);
//echo $a; // 10 - o'zgardi











namespace App;

use InvalidArgumentException;

class Student
{

    private $firstName;
    private $lastName;
    private $birthDate;



    public function __construct($firstName,$lastName,$birthDate=null)
    {
        if (empty($firstName)||empty($lastName)||empty($birthDate)){
            throw new InvalidArgumentException('tolqi yoz');
        }

        $this->firstName=$firstName;
        $this->lastName=$lastName;
        $this->birthDate=$birthDate;

    }
    public function getFullName()
    {

        return $this->lastName . ' ' . $this->firstName . ' ' . $this->birthDate;
    }

    public function rename($firstName, $lastName)
    {

        if (empty($firstName)){
            throw new InvalidArgumentException('type name');
        }
        if (empty($lastName)){
            throw new InvalidArgumentException('type lastname');
        }

        $this->lastName = $lastName;
        $this->firstName = $firstName;

    }

    public function setBirthdaydate($birthDay)
    {
        if (empty($birthDay)){
            throw new InvalidArgumentException();
        }

        $this->birthDate = $birthDay;

    }

}

$student = new Student('navruz','bek','2000-03-21');


$student->rename('vasya','pupkin');
$student->setBirthdaydate('2000-02-02');
//$student->firstName = 'Vasya';
//$student->lastName = 'pupkin';
//$student->birthDate = '2000-02-02';

echo $student->getFullName() . PHP_EOL;
//echo $student->getFullName() . PHP_EOL;


//$student->rename('Petya', 'Ivanov');


