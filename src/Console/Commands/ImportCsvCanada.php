<?php

namespace Jmnn\LocationCa\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCsvCanada extends Command
{
    protected $signature = 'canada:import';

    protected $description = 'Import database canada';

    // Level database
    private $STATE_LEVEL = 1;
    private $CITY_LEVEL = 2;
    private $STREET_LEVEL = 3;

    // Key csv
    private $NAME_KEY = 0;
    private $POSTAL_KEY = 1;
    private $CODE_KEY = 2;
    private $TIMEZONE_KEY = 3;
    private $LAT_KEY = 4;
    private $LONG_KEY = 5;
    private $STREET_NO_KEY = 6;
    private $STREET_KEY = 7;
    private $NAME_PCS_KEY = 8;
    private $TYPE_PCS_KEY = 9;
    private $DIR_PCS_NO_KEY = 10;
    private $UNIT_KEY = 11;
    private $ADDRESS_KEY = 12;
    private $STATE_KEY = 13;
    private $STANDARD_KEY = 14;
    private $TYPE_KEY = 15;

    public function handle()
    {
        $this->__importStreet();
        return Command::SUCCESS;
    }

    private function __importState()
    {
        $pathState = __DIR__.'/../../public/Asset/Csv/Canada/state.csv';
        $this->__loadFileData($pathState, $this->STATE_LEVEL);
    }

    private function __importCity()
    {
        $pathState = __DIR__.'/../../public/Asset/Csv/Canada/val.csv';
        $this->__loadFileData($pathState, $this->CITY_LEVEL);
    }

    private function __importStreet()
    {
        $files = [
            "AB",
            "BC",
            "MB",
            "NB",
            "NS",
            "NT",
            "ON",
            "PE",
            "QC",
            "SK"
        ];

        foreach ($files as $file)
        {
            $pathState = __DIR__.'/../../public/Asset/Csv/Canada/street/ODA_'.$file.'_v1.csv';
            $this->__loadFileData($pathState, $this->STREET_LEVEL,$file);
        }

    }

    private  function __loadFileData($path, $level , $code = null)
    {
        $fileOpen = fopen($path,"r");
        $count = 0;

        while (($data = fgetcsv($fileOpen, 3000, ",")) !== FALSE) {
            if($count == 0)
            {
                $count ++;
                continue;
            }

            $code = $code ?? $data[$this->CODE_KEY];
            $name = $data[$this->NAME_KEY];

            if($level == 3) $name = $data[$this->NAME_PCS_KEY];

            if($level == 1) $fullAddress = $data[$this->NAME_KEY];
            else $fullAddress = $data[$this->ADDRESS_KEY];

            $street = $data[$this->STREET_KEY] ?? Null;
            $street_no = $data[$this->STREET_NO_KEY] ?? Null;


            $state = config('location_ca.state')[$code ?? $data[$this->CODE_KEY]] ?? 'No state';

            $postal = $data[$this->POSTAL_KEY];
            $fullStatePostal = $code . " ". $postal;

            $lat = $data[$this->LAT_KEY];
            $long = $data[$this->LONG_KEY];

            $result = [
                "name" => $name,
                "state" => $state,
                "level" => $level,
                "code" => $code,
                "address" => $fullAddress,
                "postal" => $postal,
                "full_state_postal" => $fullStatePostal,
                "lat" => $lat,
                "long" => $long,
                "street" => $street,
                "no_street" => $street_no
            ];

            $check = $this->__convertData($result);
            $this->line($check['message']);

        }

    }

    private function __convertData($data)
    {
        try {
            $l = DB::table('location_american')
                        ->where('name',$data['name'])
                        ->where('level',$data['level']);
            $location = $l->first();

            if($location) $l->update($data);
            if(!$location) DB::table('location_american')->insert($data);

            return [
                "status" => true,
                "message" => "<fg=black>". $data['name'] . " Status : <fg=cyan>Done : <fg=green> Success",
            ];
        }catch (\Illuminate\Database\QueryException $e)
        {
            return [
              "status" => false,
              "message" => "<fg=black>". $data['name'] . " Status : <fg=yellow>Error | Message <fg=red>" . $e->getMessage()
            ];
        }
    }
}
