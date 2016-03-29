<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 29.11.2015                                      
 * ----------------------------------------------------
 *
 * Свойства заказа
 *
*/

namespace Rzn\Order;
use CSaleOrderPropsValue;
use ArrayAccess;

class Props implements ArrayAccess
{
    /**
     * @var Order
     */
    protected $order;

    protected $propsCodeValue = null;

    public function __construct($order)
    {
        $this->order = $order;
        $this->retrieve();
    }

    public function retrieve()
    {
        if (!$id = $this->order->getId()) {
            return false;
        }
        $res = CSaleOrderPropsValue::GetList(["SORT" => "ASC"],
            [
                'ORDER_ID' => $id,
                "PERSON_TYPE_ID" => $this->order->getPersonTypeId()
            ]);
        while($row = $res->Fetch()) {
            $this->propsCodeValue[$row['CODE']] = $row['VALUE'];
        }
        return true;
    }

    public function toArray()
    {
        return $this->propsCodeValue;
    }

    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        return !empty($this->propsCodeValue[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($this->propsCodeValue[$key]))
            return $this->propsCodeValue[$key];
        else
            return null;

    }

    public function offsetSet($key, $value)
    {
        $this->propsCodeValue[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($this->propsCodeValue[$key]);
    }
}