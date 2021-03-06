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

$ProcurementDepartment = new Department; //?????????????????????? ??????????????
$SalesDepartment = new Department;  //?????????????????????? ????????????
$AdvertisingDepartment = new Department; //?????????????????????? ??????????????
$LogisticsDepartment = new Department;  //?????????????????????? ??????????????????


//?????????????????????? ??????????????: 9??????1, 3??????2, 2??????3, 2??????1 + ???????????????????????? ????2
$ProcurementDepartment->addEmployee(new Manager(), 9);
$ProcurementDepartment->addEmployee(new Manager(2), 3);
$ProcurementDepartment->addEmployee(new Manager(3), 2);
$ProcurementDepartment->addEmployee(new Marketer(), 2);
$ProcurementDepartment->addEmployee(new Manager(2, true));

//?????????????????????? ????????????: 12??????1, 6??????1, 3??????1, 2??????2 + ???????????????????????? ????2
$SalesDepartment->addEmployee(new Manager(), 12);
$SalesDepartment->addEmployee(new Marketer(), 6);
$SalesDepartment->addEmployee(new Analyst(), 3);
$SalesDepartment->addEmployee(new Analyst(2), 2);
$SalesDepartment->addEmployee(new Marketer(2, true));

//?????????????????????? ??????????????: 15??????1, 10??????2, 8??????1, 2??????1 + ???????????????????????? ????3
$AdvertisingDepartment->addEmployee(new Marketer(), 15);
$AdvertisingDepartment->addEmployee(new Marketer(2), 10);
$AdvertisingDepartment->addEmployee(new Manager(), 8);
$AdvertisingDepartment->addEmployee(new Engineer(), 2);
$AdvertisingDepartment->addEmployee(new Marketer(3, true));

//?????????????????????? ??????????????????: 13??????1, 5??????2, 5??????1 + ???????????????????????? ????1
$LogisticsDepartment->addEmployee(new Manager(), 13);
$LogisticsDepartment->addEmployee(new Manager(2), 5);
$LogisticsDepartment->addEmployee(new Engineer(), 5);
$LogisticsDepartment->addEmployee(new Manager(1, true));

$employeesTotal = $ProcurementDepartment->getDepartmentEmployeeAmount() + $SalesDepartment->getDepartmentEmployeeAmount() + $AdvertisingDepartment->getDepartmentEmployeeAmount() + $LogisticsDepartment->getDepartmentEmployeeAmount();

$salaryTotal = $ProcurementDepartment->getDepartmentSalary() + $SalesDepartment->getDepartmentSalary() + $AdvertisingDepartment->getDepartmentSalary() + $LogisticsDepartment->getDepartmentSalary();

$coffeeTotal = $ProcurementDepartment->getDepartmentCoffee() + $SalesDepartment->getDepartmentCoffee() + $AdvertisingDepartment->getDepartmentCoffee() + $LogisticsDepartment->getDepartmentCoffee();

$docsTotal = $ProcurementDepartment->getDepartmentDocuments() + $SalesDepartment->getDepartmentDocuments() + $AdvertisingDepartment->getDepartmentDocuments() + $LogisticsDepartment->getDepartmentDocuments();

//?????????? ???????????????????? ?? ???????? ??????????????
echo "<pre>?????????????????????? ????????.  ????????.     ????????    ??????.     ????????/.??????.</pre>";

echo "<pre>??????????????     ",$ProcurementDepartment->getDepartmentEmployeeAmount(),"     ",$ProcurementDepartment->getDepartmentSalary(),"    ",$ProcurementDepartment->getDepartmentCoffee(),"     ",$ProcurementDepartment->getDepartmentDocuments(),"     ",round($ProcurementDepartment->getDepartmentSalary()/$ProcurementDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>????????????      ",$SalesDepartment->getDepartmentEmployeeAmount(),"     ",$SalesDepartment->getDepartmentSalary(),"     ",$SalesDepartment->getDepartmentCoffee(),"     ",$SalesDepartment->getDepartmentDocuments(),"     ",round($SalesDepartment->getDepartmentSalary()/$SalesDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>??????????????     ",$AdvertisingDepartment->getDepartmentEmployeeAmount(),"     ",$AdvertisingDepartment->getDepartmentSalary(),"     ",$AdvertisingDepartment->getDepartmentCoffee(),"     ",$AdvertisingDepartment->getDepartmentDocuments(),"     ",round($AdvertisingDepartment->getDepartmentSalary()/$AdvertisingDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>??????????????????   ",$LogisticsDepartment->getDepartmentEmployeeAmount(),"     ",$LogisticsDepartment->getDepartmentSalary(),"     ",$LogisticsDepartment->getDepartmentCoffee(),"     ",$LogisticsDepartment->getDepartmentDocuments(),"     ",round($LogisticsDepartment->getDepartmentSalary()/$LogisticsDepartment->getDepartmentDocuments(), 2),"</pre>";

echo "<pre>??????????????     ",$employeesTotal / 4,"  ",round($salaryTotal / 4, 2),"  ",$coffeeTotal / 4,"     ",$docsTotal / 4,"  ", round($salaryTotal / $docsTotal, 2),"</pre>";

echo "<pre>??????????:      {$employeesTotal}    {$salaryTotal}   {$coffeeTotal}    {$docsTotal}    ", round($salaryTotal / $docsTotal, 2),"</pre>";

