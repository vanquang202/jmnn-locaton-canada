<?php

namespace Jmnn\LocationCa;

use Illuminate\Support\Facades\DB;

class LocationCanada
{
    private $regex = "/(?i)([\p{L}\d\s?\,?]+?)\s?\,?([\p{L}+?\s?]+)?\,?\s?((SK|QC|ON|NS|NL|NB|MB|BC|AB|PE|YT|NU|NT|Québec|Quebec|Ontario|British Columbia|Montreal|Victoria|Saskatchewan|Calgary|Newfoundland|Nova Scotia|Alberta)([\s\w]+))\,?\s?(Canada)?/";

    public function build($search = "")
    {
        $result = [];
        $searchArray = explode(";",$search);

        foreach ($searchArray as $s)
        {
            array_push($result,$this->__matchData($s));
        }

        return $result;
    }

    public function searchData($address ,  $street , $nameLocation , $statePostal , $state , $postal)
    {
        return DB::table('location_american')
            ->orWhere('address',$address)
            ->orWhere('address',$nameLocation)
            ->orWhere('address',$street)
            ->orWhere('name',$address)
            ->orWhere('name',$state)
            ->orWhere('code',$state)
            ->get()
            ->toArray();
    }

    private function __matchData($search)
    {
        preg_match($this->regex, $search, $matches, PREG_OFFSET_CAPTURE, 0);
        return $matches;
    }

}
