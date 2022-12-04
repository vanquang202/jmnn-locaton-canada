<?php

namespace Jmnn\LocationCa\Console\Commands;

use Illuminate\Console\Command;
use JLocationCa;

class LocationCanada extends Command
{
    protected $signature = 'canada:build';

    protected $description = 'Build location canada';

    public function handle(JLocationCa $JLocationCa)
    {
        $result = [];
        $str = 'Stony Plain, AB';
        $data = $JLocationCa::build($str);

        foreach ($data as $s)
        {
            $this->__createLine(...$s);
            array_push($result, $JLocationCa::searchData(...$s));
        }
        dd($result);
        return Command::SUCCESS;
    }

    private function __createLine($address = [null], $locationStreet = [null],  $street = [null], $nameLocation = [null], $statePostal = [null] , $state = [null], $postal = [null])
    {

        $this->line('<fg=black>Address : <fg=magenta>' . $address[0] );
        $this->line('<fg=black>Location street : <fg=magenta>' . $locationStreet[0] );
        $this->line('<fg=black>Street : <fg=magenta>' . $street[0]);
        $this->line('<fg=black>Location name : <fg=magenta>' . $nameLocation[0]);
        $this->line('<fg=black>State : <fg=magenta>' . $state[0]);
        $this->line('<fg=black>State postal : <fg=magenta>' . $statePostal[0]);
        $this->line('<fg=black>Postal : <fg=magenta>' . $postal[0]);
    }
}
