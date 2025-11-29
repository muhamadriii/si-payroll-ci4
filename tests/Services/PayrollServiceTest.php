<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\PayrollService;

class PayrollServiceTest extends TestCase
{
    public function testGross()
    {
        $s = new PayrollService(22);
        $this->assertSame(3000.00, $s->gross(2500.00, 300.00, 200.00));
    }

    public function testAbsentPenalty()
    {
        $s = new PayrollService(20);
        $this->assertSame(250.00, $s->absentPenalty(2500.00, 2));
    }

    public function testTotal()
    {
        $s = new PayrollService(20);
        $r = $s->total(2500.00, 300.00, 200.00, 100.00, 2);
        $this->assertSame(3000.00, $r['gross']);
        $this->assertSame(250.00, $r['absent_penalty']);
        $this->assertSame(350.00, $r['deduction_amount']);
        $this->assertSame(2650.00, $r['total']);
    }
}

