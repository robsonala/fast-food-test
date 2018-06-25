<?php
namespace SandwichSchedule;

class SandwichSchedule
{
    const TIMETOMAKE = 60; // SECONDS
    const TIMETOSERVE = 30; // SECONDS

    /** List of tasks */
    protected $schedule;

    /** Sum of seconds used */
    protected $currentSecondUsed;
    
    /** Number of orders placed */
    protected $ordersPlaced;

    public function __construct($qtyOrders = null)
    {
        if (isset($qtyOrders))
        {
            $this->setQtyOrders($qtyOrders);
        }

        $this->schedule = [];
        $this->currentSecondUsed = 0;
    }
    
    public function setQtyOrders($qtyOrders)
    {
        if (!is_int($qtyOrders))
        {
            throw new \Exception('`qtyOrders` must be an Integer value');
        }

        $this->ordersPlaced = $qtyOrders;
    }

    protected function addSchedule($time, $description)
    {
        if (!is_int($time))
        {
            throw new \Exception('`time` must be an Integer value');
        }

        if (!$description)
        {
            throw new \Exception('`description` must be set');
        }

        $this->schedule[] = gmdate('i:s', $this->currentSecondUsed) . ' - ' . $description;
        $this->currentSecondUsed+= $time;
    }

    public function calculate()
    {
        if (!isset($this->ordersPlaced))
        {
            throw new \Exception('Set `qtyOrders` value');
        }

        for ($i=1; $i<=$this->ordersPlaced; $i++)
        {
            $this->addSchedule(self::TIMETOMAKE, 'Make Sandwich ' . $i);
            $this->addSchedule(self::TIMETOSERVE, 'Serve Sandwich ' . $i);
        }

        $this->addSchedule(0, 'Take a break :)');
    }

    public function output()
    {
        $ouput = $this->ordersPlaced . ' sandwich order places ' . chr(10) . chr(10);

        foreach ($this->schedule as $k=>$schedule)
        {
            $ouput.=($k+1) . '. ' . $schedule . chr(10);
        }

        return $ouput . chr(10);
    }
}