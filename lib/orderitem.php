<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 29.11.2015
 * ----------------------------------------------------
 *
 * ID    Код записи.
 * PRODUCT_ID    Уникальный в рамках модуля код товара.
 * PRODUCT_PRICE_ID    Дополнительный код товара.
 * PRICE    Стоимость единицы товара.
 * CURRENCY    Валюта стоимости единицы товара.
 * WEIGHT    Вес единицы товара.
 * QUANTITY    Количество единиц товара.
 * LID    Сайт, на котором сделана покупка.
 * DELAY    Флаг "товар отложен" (Y/N)
 * CAN_BUY    Флаг "товар можно купить" (Y/N)
 * NAME    Название товара.
 * CALLBACK_FUNC*    Название функции обратного вызова для поддержки актуальности корзины.
 * MODULE    Модуль, добавляющий товар в корзину.
 * NOTES    Особые заметки, например, тип цены.
 * ORDER_CALLBACK_FUNC*    Название функции обратного вызова для оформления заказа.
 * ORDER_ALLOW_DELIVERY    Доставка заказа корзины разрешена. (Для корзин, уже привязанных к заказу.)
 * ORDER_PAYED    Заказ корзины оплачен. (Для корзин, уже привязанных к заказу.)
 * ORDER_PRICE    Стоимость заказа корзины. (Для корзин, уже привязанных к заказу.)
 * ORDER_CANCELED    Флаг отмены заказа.
 * DETAIL_PAGE_URL    Ссылка на страницу детального просмотра товара.
 * FUSER_ID    Внутренний код владельца корзины (не совпадает с кодом пользователя)
 * USER_ID    Реальный идентификатор пользователя. (не путать с FUSER_ID)
 * ORDER_ID    Код заказа, в который вошла эта запись (товар). Для товаров, которые помещены в корзину, но ещё не заказаны, это поле равно NULL.
 * DATE_INSERT    Дата добавления товара в корзину.
 * DATE_UPDATE    Дата последнего изменения записи.
 * CANCEL_CALLBACK_FUNC*    Название функции обратного вызова для отмены заказа.
 * PAY_CALLBACK_FUNC*    Название функции обратного вызова, которая вызывается при установке флага заказа "Доставка разрешена".
 * PRODUCT_PROVIDER_CLASS**    Имя класса, реализующего интерфейс IBXSaleProductProvider. Торговый каталог записывает в это поле имя класса CCatalogProductProvider.
 * DISCOUNT_PRICE    Скидка на товар. Значение устанавливается только после оформления заказа.
 *
 */

namespace Rzn\Order;
use CSaleBasket;


class OrderItem
{
    /**
     * @var Order
     */
    protected $order;

    protected $id = null;

    protected $data = [];

    /**
     * @param Order $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function getItemsForOrder($useKey = null)
    {
        if (!$orderId = $this->getOrder()->getId()) {
            return null;
        }

        if (!$useKey) {
            $useKey = 'ID';
        }

        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "LID" => SITE_ID,
                "ORDER_ID" => $orderId
            ),
            false,
            false
        );
        while ($row = $dbBasketItems->Fetch()) {
            $object = clone($this);

            $object->fillWithData($row);
            if ($useKey) {
                $result[$row[$useKey]] = $object;
            } else {
                $result[] = $object;
            }

            /*
            if (strlen($arItems["CALLBACK_FUNC"]) > 0)
            {
                CSaleBasket::UpdatePrice($arItems["ID"],
                    $arItems["CALLBACK_FUNC"],
                    $arItems["MODULE"],
                    $arItems["PRODUCT_ID"],
                    $arItems["QUANTITY"]);
                $arItems = CSaleBasket::GetByID($arItems["ID"]);
            }
            $arBasketItems[] = $arItems;
  */
        }
        return $result;
  }

    public function setPrice($value)
    {
        $this->data['PRICE'] = $value;
        return $this;
    }

    public function setName($value)
    {
        $this->data['NAME'] = $value;
        return $this;
    }

    public function setCurrency($value = 'RUB')
    {
        $this->data['CURRENCY'] = $value;
        return $this;
    }

    public function setQuantity($value = 1)
    {
        $this->data['QUANTITY'] = $value;
        return $this;
    }

    public function setDetailPageUrl($value = 1)
    {
        $this->data['DETAIL_PAGE_URL'] = $value;
        return $this;
    }

    public function setProductId($value)
    {
        $this->data['PRODUCT_ID'] = $value;
        return $this;
    }

    public function save($data = [])
    {
        if (!$orderId = $this->getOrder()->getId()) {
            return null;
        }

        if (!$this->data['PRODUCT_ID']) {
            throw new \Exception('Не указан PRODUCT_ID');
        }

        unset($data['ID']);
        if (is_array($data) and count($data)) {
            $this->data = array_merge_recursive($this->data, $data);
        }
        $this->data['ORDER_ID'] = $orderId;
        $this->data['LID'] = SITE_ID;
        if ($this->id) {
            CSaleBasket::Update($this->id, $this->data);
        } else {
            CSaleBasket::Add($this->data);
        }
    }

    public function delete()
    {
        if (!$this->id) {
            return false;
        }
        CSaleBasket::Delete($this->id);
        return true;
    }

    public function fillWithData($data)
    {
        $this->id = $data['ID'];
        unset($data['ID']);
        $this->data = $data;
    }

}