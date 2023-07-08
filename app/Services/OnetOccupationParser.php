<?php

namespace App\Services;

use App\Contracts\OccupationParser;

class OnetOccupationParser implements OccupationParser
{
    private $scope = '';

    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    public function getScope()
    {
        return ucfirst(str_plural(strtolower($this->scope)));
    }

    public function getUrl($occupation_code)
    {
        return 'https://www.onetonline.org/link/table/details/'.substr($this->scope, 0, 2).'/'.$occupation_code.'/'.$this->getScope().'_' . $occupation_code . '.csv?fmt=csv';
    }

    public function list()
    {
        $json = file_get_contents(storage_path('/app/onet_occupations.json'));
        return json_decode($json, true);
    }

    public function get($occupation_code)
    {
        $data = file_get_contents($this->getUrl($occupation_code));
        $rows = explode("\n",$data);
        $s = array();
        foreach($rows as $i => $row) {
            $values = str_getcsv($row);
            if ($i > 0 && count($values) === 3) {
                $s[] = $values;
            }
        }

        return $s;
    }
}