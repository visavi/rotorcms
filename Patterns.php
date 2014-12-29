<?php
namespace A;

?>
http://dron.by/post/patterny-shablony-proektirovanie-v-php-vvedenie.html
Я предполагаю, что читатель осведомлен о понятиях ООП и знает в чем разница между интерфейсом и абстрактным классом. Знает что такое полиморфизм, инкапсуляция и наследование. Если вы не уверены в своих силах, рекомендую к прочтению статью из википедии "Объектно-ориентированное программирование".

https://ru.wikipedia.org/wiki/%D0%9E%D0%B1%D1%8A%D0%B5%D0%BA%D1%82%D0%BD%D0%BE-%D0%BE%D1%80%D0%B8%D0%B5%D0%BD%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%BF%D1%80%D0%BE%D0%B3%D1%80%D0%B0%D0%BC%D0%BC%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5


http://habrahabr.ru/post/214285/
<?php

// Pattern Singleton
// Одиночка (англ. Singleton) — порождающий шаблон проектирования, гарантирующий, что в однопоточном приложении будет единственный экземпляр класса с глобальной точкой доступа.

$a = array('x', 4, 6);
$b = array('y', 5, 3, 'c');
echo !$a[5] ?: 0;

class Database
{
	private static $connection;

	private function __construct()
	{
		echo "Connections created";
	}

	public static function Connect()
	{
		if (!isset(self::$connection))
		{
			self::$connection = new Database;
		}

		return self::$connection;
	}
}

// Pattern Registry
class Registry
{
	private static $_obj = array();

	public static function Set($name, $object)
	{
		self::$_obj[$name] = $object;
	}

	public static function Get($name)
	{
		return self::$_obj[$name];
	}
}

// Patter Factrory
// Фабричный метод (англ. Factory Method также известен как Виртуальный конструктор (англ. Virtual Constructor)) — порождающий шаблон проектирования, предоставляющий подклассам интерфейс для создания экземпляров некоторого класса

interface Product{
    public function GetName();
}

class ConcreteProductA implements Product{
    public function GetName() { return "ProductA"; }
}

class ConcreteProductB implements Product{
    public function GetName() { return "ProductB"; }
}

interface Creator{
    public function FactoryMethod();
}

class ConcreteCreatorA implements Creator{
    public function FactoryMethod() { return new ConcreteProductA(); }
}

class ConcreteCreatorB implements Creator{
    public function FactoryMethod() { return new ConcreteProductB(); }
}

// An array of creators
$creators = array( new ConcreteCreatorA(), new ConcreteCreatorB() );
	var_dump($creators);
// Iterate over creators and create products
for($i = 0; $i < count($creators); $i++){
    $products[] = $creators[$i]->FactoryMethod()->getName();
}

var_dump($products);


// Pattern Facade
// Шаблон фасад (англ. Facade) — структурный шаблон проектирования, позволяющий скрыть сложность системы путем сведения всех возможных внешних вызовов к одному объекту, делегирующему их соответствующим объектам системы.
class Facade
{
	public function TestFacade()
	{
		Registry::Set('DB', Database::Connect());

		var_dump(Registry::Get('DB'));
	}
}

$facade = new Facade;
$facade->TestFacade();




