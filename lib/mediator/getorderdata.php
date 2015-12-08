<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 08.12.2015                                     |
 * ----------------------------------------------------
 *
 */
namespace Rzn\Order\Mediator;
use Bitrix\Main\Loader;
use Rzn\Order\Exception;
use CSaleOrder;
use CSaleOrderPropsValue;

class GetOrderData
{
    public function __construct()
    {
        Loader::includeModule('sale');
    }

    public function __invoke($params = null)
    {
        // Для тестов бывает нужным любой существующий заказ - пусть это будет последний
        if (isset($params['last']) and $params['last']) {
            $order = CSaleOrder::GetList(['ID' => 'DESC'], false, false, false, ['ID'])->Fetch();
            if (!$order) {
                return null;
            }
            $id = $order['ID'];
        } else {
            if (!isset($params['id'])) {
                throw new Exception('Параметр за ключем id обязателен');
            }
            $id = $params['id'];
        }

        $data = CSaleOrder::GetByID($id);
        if (!$data) {
            return null;
        }

        $dbOrderPropVals = CSaleOrderPropsValue::GetList(
            array(),
            array("ORDER_ID" => $id),
            false,
            false,
            array("ID", "CODE", "VALUE", "ORDER_PROPS_ID", "PROP_TYPE")
        );

        $propsValue = [];
        while ($arOrderPropVals = $dbOrderPropVals->Fetch()) {
            $propsValue[$arOrderPropVals['CODE']] = $arOrderPropVals['VALUE'];
        }
        $data['props'] = $propsValue;
        return $data;
    }
}