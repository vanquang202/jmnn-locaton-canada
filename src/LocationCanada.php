<?php

namespace Jmnn\LocationCa;

use Illuminate\Support\Facades\DB;

class LocationCanada
{
    private $regex = "/(([a-z0-9A-Z_\x{00C0}-\x{00FF}\x{1EA0}-\x{1EFF}\d?\s?\,?]*?)\s?\,?+([\/?\(?\)?\"?\.?\'?\’?\-?\d?a-z0-9A-Z_\x{00C0}-\x{00FF}\x{1EA0}-\x{1EFF}+?\s?]+)?)?\,?\s?((SK|QC|ON|NS|NL|NB|MB|BC|AB|PE|YT|NU|NT|Québec|Saskatchewan|Quebec|Ontario|Nova Scotia|Newfoundland and Labrador|New Brunswick|Manitoba|British Columbia|Alberta|Prince Edward Island|Yukon|Nunavut|Northwest Territories)([\s\w]+)?)\,?\s?(Canada)?/u";

    public function __construct()
    {
        $regexVietnameseCharacter = "a-z0-9A-Z_\x{00C0}-\x{00FF}\x{1EA0}-\x{1EFF}";
        $groupLevelThree = "([$regexVietnameseCharacter\d?\s?\,?]*?)";
        $groupLevelTwo = "([\!?\/?\(?\)?\"?\.?\'?\’?\-?$regexVietnameseCharacter+?\d?\s?]+)";
        $groupLevelOne = "((SK|QC|ON|NS|NL|NB|MB|BC|AB|PE|YT|NU|NT|Québec|Saskatchewan|Quebec|Ontario|Nova Scotia|Newfoundland and Labrador|New Brunswick|Manitoba|British Columbia|Alberta|Prince Edward Island|Yukon|Nunavut|Northwest Territories)([\s\w]+)?)";

        $this->regex = "/($groupLevelThree\s?\,?+$groupLevelTwo?)?\,?\s?$groupLevelOne\,?\s?(Canada)?/u";

    }

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

    public function searchData($address = ["Default"], $locationStreet = ["Default"],  $street = ["Default"], $nameLocation = ["Default"], $statePostal = ["Default"] , $state = ["Default"], $postal = ["Default"])
    {
        return DB::table('location_american')
            ->orWhere('address',$address[0])
            ->orWhere('address',$nameLocation[0])
            ->orWhere('address',$street[0])
            ->orWhere('name',$address[0])
            ->orWhere('name',$state[0])
            ->get()
            ->toArray();
    }

    private function __matchData($search)
    {
        preg_match($this->regex, $search, $matches, PREG_OFFSET_CAPTURE, 0);
        return $matches;
    }

}
