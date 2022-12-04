<?php

namespace Jmnn\LocationCa;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jmnn\LocationCa\Tests\TestCase;
use NunoMaduro\Collision\ConsoleColor;

class TestLocationCanada extends TestCase
{
    private $locationCanada;
    private $color;

    public function __construct()
    {
        $this->locationCanada = new LocationCanada();
        $this->color = new ConsoleColor();

        parent::__construct();
    }

    public function test_state_location_canada()
    {
        $countSuccess = 0;
        $countFailed = 0;
        $resultFailed = [];

        $data = $this->__getLocationData();

        foreach ($data as $v)
        {
            $result = $this->locationCanada->build($v->address);

            $check = [
                $result[0][$v->level == 1 ? 4 : 3][0],
                $result[0][1][0]
            ];

            if(in_array($v->name ,$check)) {
                $countSuccess++;
                echo $v->name . $this->__color("blue", " : SUCCESS");
            } else {
                $countFailed++;
                array_push($resultFailed,$v->name . $this->__color("red", " : FAILED $check[0]"));

                echo $v->name . $this->__color("red", " : FAILED $check[0]");
            }

            echo "\n";
            ob_flush();

        }

        foreach ($resultFailed as $message)
        {
            echo "\n" . $message;
        }

        echo "\n Success : " . $this->__color("blue", $countSuccess) . " Failed : ". $this->__color("red", $countFailed ) ;

        $this->assertTrue(true);
    }

    private function __color($color , $messgae)
    {
        return $this->color->apply($color , $messgae);
    }

    private function __getLocationData() : Collection
    {
        return DB::table('location_american')
            ->whereIn('level',[1,2])
            ->get();
    }

}
