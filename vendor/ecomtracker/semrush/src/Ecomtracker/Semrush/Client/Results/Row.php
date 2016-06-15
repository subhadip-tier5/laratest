<?php namespace Ecomtracker\Semrush\Client\Results;

use Ecomtracker\Semrush\Client\Results\Data\Column;
use Ecomtracker\Semrush\Client\Results\Exceptions\InvalidDataException;
use Ecomtracker\Semrush\Client\Results\Exceptions\InvalidFieldException;


class Row
{
    /**
     * @var string[]
     */
    protected $data = [];

    /**
     * Get all the data for this row
     *
     * @return string[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the data for this row
     *
     * @param string[] $data
     * @throws InvalidDataException
     */
    public function setData($data)
    {
        if (!is_array($data)) {
            \Log::error('The data provided was not an array.');
        }else{
        $this->validate($data);
        $this->data = $data;
        }
    }

    /**
     * Get a single value from this row
     *
     * @param $key
     * @return string
     */
    public function getValue($key)
    {
        if (!isset($this->data[$key])) {
            throw new InvalidFieldException("The field [{$key}] was not found in the results.");
        }
        return $this->data[$key];
    }

    /**
     * Validate the data is correct
     *
     * @param string[] $data
     * @throws InvalidFieldException
     */
    protected function validate($data)
    {
        foreach ($data as $code => $item) {
            if (!Column::isValidColumn($code)) {
                throw new InvalidFieldException("The data provided [{$code}] was not a valid field code.");
            }
        }
    }
}