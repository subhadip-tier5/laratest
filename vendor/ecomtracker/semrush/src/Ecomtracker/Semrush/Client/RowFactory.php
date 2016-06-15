<?php namespace Ecomtracker\Semrush\Client;

use Ecomtracker\Semrush\Client\Results\Row;

class RowFactory
{
    /**
     * Takes raw API data and converts into a result
     *
     * @param string[] $data
     * @return Row
     */
    public function create($data)
    {
        $row = new Row();
        $row->setData($data);
        return $row;
    }
}