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

        $data = $JLocationCa::build('32 ARBOR CR SE , Levis ,Quebec G6V 7N5 , Canada');

        foreach ($data as $k => $s)
        {
            $this->__createLine(...$s);
            array_push($result, $JLocationCa::searchData(...$s));
        }

        dd($result);
        return Command::SUCCESS;
    }

    private function __createLine($address ,  $street , $nameLocation , $statePostal , $state , $postal)
    {
        $this->line('<fg=black>Address : <fg=magenta>' . $address[0] );
        $this->line('<fg=black>Street : <fg=magenta>' . $street[0]);
        $this->line('<fg=black>Location name : <fg=magenta>' . $nameLocation[0]);
        $this->line('<fg=black>State postal : <fg=magenta>' . $statePostal[0]);
        $this->line('<fg=black>State : <fg=magenta>' . $state[0]);
        $this->line('<fg=black>Postal : <fg=magenta>' . $postal[0]);

//        $this->line('
//            <fg=black>Black
//            <fg=red>Red
//            <fg=green>Green
//            <fg=yellow>Yellow
//             <fg=blue>Blue
//             <fg=magenta>Magenta
//             <fg=cyan>Cyan
//             <fg=white;bg=black>White
//             <fg=default;bg=black>Default</>');
    }
}
