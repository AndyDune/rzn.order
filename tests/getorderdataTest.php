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
namespace Rzn\Order\Test;

use PHPUnit_Framework_TestCase;
use Rzn\Library\Registry;
use Rzn\Order\Mediator\GetOrderData;
use CSaleOrder;
use Bitrix\Main\Loader;

class GetOrderDataTest extends PHPUnit_Framework_TestCase
{
    protected $backupGlobals = false;

    public function testUse()
    {
        Loader::includeModule('sale');

        $order = CSaleOrder::GetList(['ID' => 'ASC'], false, false, false, ['ID'])->Fetch();
        if (!$order) {
            return;
        }
        $orderId = $order['ID'];
        /** @var callable $object */
        $object = new GetOrderData();
        $data = $object(['last' => true]);
        $this->assertArrayHasKey('PRICE', $data);
        $this->assertNotEquals($orderId, $data['ID']);

        $data = $object(['id' => $orderId]);
        $this->assertArrayHasKey('PRICE', $data);
        $this->assertEquals($orderId, $data['ID']);

        $sm = Registry::getServiceManager()->get('mediator');
        $data = $sm->publish('getOrderData', ['id' => $orderId]);
        $this->assertEquals($orderId, $data['ID']);
    }

    public function testWithError()
    {
        /** @var \Rzn\Order\Order $orderService */
        $orderService = Registry::getServiceManager()->get('rzn_order');

        $orderService->setPrice(10)
        ->setXml(10)
            ->setStatus(0)
            //->setCurrency()
            ->setUserId(1)
            ->setPersonType(10);
        $id = $orderService->prepareData()->save();
        /** @var \CApplicationException $saveError */
        $saveError = $orderService->getSaveError();

        $this->assertEquals('EMPTY_CURRENCY', $saveError->GetID());

        $this->assertEmpty($id, 'Заказ не должен быть сохранен');

        $orderService->clear();
        $orderService->setPrice(10)
            ->setXml(10)
            ->setStatus(0)
            ->setCurrency()
            ->setUserId(1)
            ->setPersonType(10);
        $id = $orderService->prepareData()->save();
        /** @var \CApplicationException $saveError */
        $saveError = $orderService->getSaveError();

        $this->assertEquals('ERROR_NO_PERSON_TYPE', $saveError->GetID());

        $this->assertEmpty($id, 'Заказ не должен быть сохранен');


    }
}