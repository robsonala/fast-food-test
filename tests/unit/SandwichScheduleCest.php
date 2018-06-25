<?php

use Codeception\Util\Stub as Stub;
use Helper\Unit as HelperUnit;

class SandwichScheduleCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    public function test_setQtyOrders(UnitTester $I)
    {
        $obj = Stub::construct('\SandwichSchedule\SandwichSchedule');
        $reflection = new HelperUnit($obj);
        
        // TEST VALID
        $randValue = rand(1,999);
        $obj->setQtyOrders($randValue);
        $I->assertEquals($reflection->ordersPlaced, $randValue);

        // TEST INVALID
        try {
            $obj->setQtyOrders(null);
        } catch (\Exception $e) {
            $I->assertEquals($e->getMessage(), '`qtyOrders` must be an Integer value');
        }
    }

    public function test_addSchedule(UnitTester $I)
    {
        $obj = Stub::construct('\SandwichSchedule\SandwichSchedule');
        $reflection = new HelperUnit($obj);

        // TEST VALID
        $time = 60;
        $reflection->addSchedule($time, 'lorem ipsum dolor sit amet');
        
        $I->assertEquals($reflection->currentSecondUsed, $time);
        $I->assertEquals($reflection->schedule, ['00:00 - lorem ipsum dolor sit amet']);


        $reflection->addSchedule($time, 'lorem ipsum dolor sit amet');
        $I->assertCount(2, $reflection->schedule);

        // TEST INVALID
        try {
            $reflection->addSchedule(null, null);
        } catch (\Exception $e) {
            $I->assertEquals($e->getMessage(), '`time` must be an Integer value');
        }
    }

    public function test_calculate(UnitTester $I)
    {
        $obj = Stub::construct('\SandwichSchedule\SandwichSchedule');
        $reflection = new HelperUnit($obj);

        $qtyToOrder = 2;

        $obj->setQtyOrders($qtyToOrder);
        $obj->calculate();

        $I->assertCount(($qtyToOrder * 2) + 1, $reflection->schedule);

        $I->assertEquals($reflection->currentSecondUsed, (\SandwichSchedule\SandwichSchedule::TIMETOMAKE * 2 + \SandwichSchedule\SandwichSchedule::TIMETOSERVE * 2));
    }

    public function test_output(UnitTester $I)
    {
        $obj = Stub::construct('\SandwichSchedule\SandwichSchedule');
        $reflection = new HelperUnit($obj);

        $obj->setQtyOrders(1);
        $obj->calculate();

        $I->assertContains('1 sandwich order places', $obj->output());
    }
}
