<?php
class One {
    public $name;
    public $age;

    function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
}
class Two {
    public $name;
    public $age;
    public $gender;
    public $property;

    function __construct($name, $age, $gender, $property) {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
        $this->property = $property;
    }
}
class Three {
    public $race;
    public $country;

    function __construct($race, $country) {
        $this->race = $race;
        $this->country = $country;
    }
}

$name1 = ['last', 'first', 'middle'];
$name2 = ['first'];
$age1 = ['children', 'worker'];
$age2 = ['children'];
$gender = ['male', 'female'];
$property = ['house', 'car'];
$race = ['Asian', 'American'];
$country = ['Vietnam', 'USA'];

// Create two Person objects
$new = [1, 2, 3];
$old = [4, 5 ,6];
// $old = new Three($race, $country);

print_r($new);
$new[] = $old;
print_r($new);
