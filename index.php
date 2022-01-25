<?php

error_reporting(-1);

abstract class Employee {
    private $salary;
    private $coffee;
    private $documents;
    private $rank;
    private $isBoss;
    
    protected function __construct($rank, $isBoss, $rate, $coffee, $documents){
        $this->rank = $rank;
        $this->isBoss = $isBoss;
        if ($isBoss){
            $this->salary = $rate * (0.75 + 0.25 * $rank) * 1.5;
            $this->coffee = $coffee * 2;
            $this->documents = 0;
        } else {
            $this->salary = $rate * (0.75 + 0.25 * $rank);
            $this->coffee = $coffee;
            $this->documents = $documents;
        }
    }
    
    function getSalary(){
        return $this->salary;
    }
    
    function getCoffee(){
        return $this->coffee;
    }
    
    function getDocuments(){
        return $this->documents;
    }
}

class Manager extends Employee {
    public function __construct($rank = 1, $isBoss = false, $rate = 500, $coffee = 20, $documents = 200){
        parent::__construct($rank, $isBoss, $rate, $coffee, $documents);
    }
}

class Marketer extends Employee {
    public function __construct($rank = 1, $isBoss = false, $rate = 400, $coffee = 15, $documents = 150){
        parent::__construct($rank, $isBoss, $rate, $coffee, $documents);
    }
}

class Engineer extends Employee {
    public function __construct($rank = 1, $isBoss = false, $rate = 200, $coffee = 5, $documents = 50){
        parent::__construct($rank, $isBoss, $rate, $coffee, $documents);
    }
}

class Analyst extends Employee {
    public function __construct($rank = 1, $isBoss = false, $rate = 800, $coffee = 50, $documents = 5){
        parent::__construct($rank, $isBoss, $rate, $coffee, $documents);
    }
}

class Department {
    private $employees = [];

    function addEmployee($employee, $amount = 1){
        for($i = 0; $i < $amount; $i++){
            $this->employees[] = $employee;
        }
    }

    function getDepartmentEmployeeAmount(){
        return count($this->employees);
    }

    function getDepartmentSalary(){
        $departmentSalary = 0;
        foreach($this->employees as $employee){
            $departmentSalary += $employee->getSalary();
        }
        return $departmentSalary;
    }

    function getDepartmentCoffee(){
        $departmentCoffee = 0;
        foreach($this->employees as $employee){
            $departmentCoffee += $employee->getCoffee();
        }
        return $departmentCoffee;
    }

    function getDepartmentDocuments(){
        $departmentDocuments = 0;
        foreach($this->employees as $employee){
            $departmentDocuments += $employee->getDocuments();
        }
        return $departmentDocuments;
    }

}

$ProcurementDepartment = new Department; //департамент закупок
$SalesDepartment = new Department;  //департамент продаж
$AdvertisingDepartment = new Department; //департамент рекламы
$LogisticsDepartment = new Department;  //департамент логистики


//Департамент закупок: 9×ме1, 3×ме2, 2×ме3, 2×ма1 + руководитель ме2
$ProcurementDepartment->addEmployee(new Manager(), 9);
$ProcurementDepartment->addEmployee(new Manager(2), 3);
$ProcurementDepartment->addEmployee(new Manager(3), 2);
$ProcurementDepartment->addEmployee(new Marketer(), 2);
$ProcurementDepartment->addEmployee(new Manager(2, true));

//Департамент продаж: 12×ме1, 6×ма1, 3×ан1, 2×ан2 + руководитель ма2
$SalesDepartment->addEmployee(new Manager(), 12);
$SalesDepartment->addEmployee(new Marketer(), 6);
$SalesDepartment->addEmployee(new Analyst(), 3);
$SalesDepartment->addEmployee(new Analyst(2), 2);
$SalesDepartment->addEmployee(new Marketer(2, true));

//Департамент рекламы: 15×ма1, 10×ма2, 8×ме1, 2×ин1 + руководитель ма3
$AdvertisingDepartment->addEmployee(new Marketer(), 15);
$AdvertisingDepartment->addEmployee(new Marketer(2), 10);
$AdvertisingDepartment->addEmployee(new Manager(), 8);
$AdvertisingDepartment->addEmployee(new Engineer(), 2);
$AdvertisingDepartment->addEmployee(new Marketer(3, true));

//Департамент логистики: 13×ме1, 5×ме2, 5×ин1 + руководитель ме1
$LogisticsDepartment->addEmployee(new Manager(), 13);
$LogisticsDepartment->addEmployee(new Manager(2), 5);
$LogisticsDepartment->addEmployee(new Engineer(), 5);
$LogisticsDepartment->addEmployee(new Manager(1, true));

$employeesTotal = $ProcurementDepartment->getDepartmentEmployeeAmount() + $SalesDepartment->getDepartmentEmployeeAmount() + $AdvertisingDepartment->getDepartmentEmployeeAmount() + $LogisticsDepartment->getDepartmentEmployeeAmount();

$salaryTotal = $ProcurementDepartment->getDepartmentSalary() + $SalesDepartment->getDepartmentSalary() + $AdvertisingDepartment->getDepartmentSalary() + $LogisticsDepartment->getDepartmentSalary();

$coffeeTotal = $ProcurementDepartment->getDepartmentCoffee() + $SalesDepartment->getDepartmentCoffee() + $AdvertisingDepartment->getDepartmentCoffee() + $LogisticsDepartment->getDepartmentCoffee();

$docsTotal = $ProcurementDepartment->getDepartmentDocuments() + $SalesDepartment->getDepartmentDocuments() + $AdvertisingDepartment->getDepartmentDocuments() + $LogisticsDepartment->getDepartmentDocuments();

//вывод статистики в виде таблицы
echo "<pre>Департамент сотр.  тугр.     кофе    стр.     тугр/.стр.</pre>";

echo "<pre>Закупок     ",$ProcurementDepartment->getDepartmentEmployeeAmount(),"     ",$ProcurementDepartment->getDepartmentSalary(),"    ",$ProcurementDepartment->getDepartmentCoffee(),"     ",$ProcurementDepartment->getDepartmentDocuments(),"     ",round($ProcurementDepartment->getDepartmentSalary()/$ProcurementDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>Продаж      ",$SalesDepartment->getDepartmentEmployeeAmount(),"     ",$SalesDepartment->getDepartmentSalary(),"     ",$SalesDepartment->getDepartmentCoffee(),"     ",$SalesDepartment->getDepartmentDocuments(),"     ",round($SalesDepartment->getDepartmentSalary()/$SalesDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>Рекламы     ",$AdvertisingDepartment->getDepartmentEmployeeAmount(),"     ",$AdvertisingDepartment->getDepartmentSalary(),"     ",$AdvertisingDepartment->getDepartmentCoffee(),"     ",$AdvertisingDepartment->getDepartmentDocuments(),"     ",round($AdvertisingDepartment->getDepartmentSalary()/$AdvertisingDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>Логистики   ",$LogisticsDepartment->getDepartmentEmployeeAmount(),"     ",$LogisticsDepartment->getDepartmentSalary(),"     ",$LogisticsDepartment->getDepartmentCoffee(),"     ",$LogisticsDepartment->getDepartmentDocuments(),"     ",round($LogisticsDepartment->getDepartmentSalary()/$LogisticsDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>Среднее     ",$employeesTotal / 4,"  ",round($salaryTotal / 4, 2),"  ",$coffeeTotal / 4,"     ",$docsTotal / 4,"  ", round($salaryTotal / $docsTotal, 2),"</pre>";

echo "<pre>Всего:      {$employeesTotal}    {$salaryTotal}   {$coffeeTotal}    {$docsTotal}    ", round($salaryTotal / $docsTotal, 2),"</pre>";

