<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 29.11.2015                                      
 * ----------------------------------------------------
 *
 * Представление зказа в ситеме бирикс.
 * Сохраненеи / чтение главных данных, определение пользователя.
 *
 * Класс выборки саойств заказа CSaleOrder::GetByID возвращает массив с ключами:
 *
ID	Код заказа.
LID	Код сайта, на котором сделан заказ.
PERSON_TYPE_ID	Тип плательщика, к которому принадлежит посетитель, сделавший заказ (заказчик)
PAYED	Флаг (Y/N) оплачен ли заказ.
DATE_PAYED	Дата оплаты заказа.
EMP_PAYED_ID	Код пользователя (сотрудника магазина), который установил флаг оплаченности.
CANCELED	Флаг (Y/N) отменён ли заказ.
DATE_CANCELED	Дата отмены заказа.
EMP_CANCELED_ID	Код пользователя, который установил флаг отмены заказа.
RESPONSIBLE_ID	ID ответственного лица.
REASON_CANCELED	Текстовое описание причины отмены заказа.
STATUS_ID	Код статуса заказа.
DATE_STATUS	Дата изменения статуса заказа.
EMP_STATUS_ID	Код пользователя (сотрудника магазина), который установил текущий статус заказа.
PRICE_DELIVERY	Стоимость доставки заказа.
ALLOW_DELIVERY	Флаг (Y/N) разрешена ли доставка (отгрузка) заказа.
DATE_ALLOW_DELIVERY	Дата, когда была разрешена доставка заказа.
EMP_ALLOW_DELIVERY_ID	Код пользователя (сотрудника магазина), который разрешил доставку заказа.
PRICE	Общая стоимость заказа.
CURRENCY	Валюта стоимости заказа.
DISCOUNT_VALUE	Общая величина скидки.
USER_ID	Код пользователя заказчика.
PAY_SYSTEM_ID	Платежная система, которой (будет) оплачен заказа.
DELIVERY_ID	Способ (служба) доставки заказа.
DATE_INSERT	Дата добавления заказа.
DATE_UPDATE	Дата последнего изменения заказа.
USER_DESCRIPTION	Описание заказа заказчиком.
ADDITIONAL_INFO	Дополнительная информация по заказу.
PS_STATUS	Флаг (Y/N) статуса платежной системы - успешно ли оплачен заказ (для платежных систем, которые позволяют автоматически получать данные по проведенным через них заказам)
PS_STATUS_CODE	Код статуса платежной системы (значение зависит от системы)
PS_STATUS_DESCRIPTION	Описание результата работы платежной системы.
PS_STATUS_MESSAGE	Сообщение от платежной системы.
PS_SUM	Сумма, которая была реально оплачена через платежную систему.
PS_CURRENCY	Валюта суммы.
PS_RESPONSE_DATE	Дата получения статуса платежной системы.
COMMENTS	Произвольные комментарии.
TAX_VALUE	Общая сумма налогов.
STAT_GID	Параметр события в статистике.
SUM_PAID	Сумма, которая уже была оплачена покупателем по данному счету (например, с внутреннего счета).
PAY_VOUCHER_NUM	Номер платежного поручения.
PAY_VOUCHER_DATE	Дата платежного поручения.
 *
 * Совйитсва можно использовать при Add и Update
 *
LID - код сайта, на котором сделан заказ;
PERSON_TYPE_ID - тип плательщика, к которому принадлежит посетитель, сделавший заказ (заказчик);
PAYED - флаг (Y/N) оплачен ли заказ;
DATE_PAYED - дата оплаты заказа;
EMP_PAYED_ID - код пользователя (сотрудника магазина), который установил флаг оплаченности;
CANCELED - флаг (Y/N) отменён ли заказ;
DATE_CANCELED - дата отмены заказа;
EMP_CANCELED_ID - код пользователя, который установил флаг отмены заказа;
REASON_CANCELED - текстовое описание причины отмены заказа;
STATUS_ID - код статуса заказа;
EMP_STATUS_ID - код пользователя (сотрудника магазина), который установил текущий статус заказа;
PRICE_DELIVERY - стоимость доставки заказа;
ALLOW_DELIVERY - флаг (Y/N) разрешена ли доставка (отгрузка) заказа;
DATE_ALLOW_DELIVERY - дата, когда была разрешена доставка заказа;
EMP_ALLOW_DELIVERY_ID - код пользователя (сотрудника магазина), который разрешил доставку заказа;
PRICE - общая стоимость заказа;
CURRENCY - валюта стоимости заказа;
DISCOUNT_VALUE - общая величина скидки;
USER_ID - код пользователя заказчика;
PAY_SYSTEM_ID - платежная система, которой (будет) оплачен заказа;
DELIVERY_ID - способ (служба) доставки заказа;
USER_DESCRIPTION - описание заказа заказчиком;
ADDITIONAL_INFO - дополнительная информация по заказу;
COMMENTS - произвольные комментарии;
TAX_VALUE - общая сумма налогов;
AFFILIATE_ID - код аффилиата, через которого пришел посетитель;
STAT_GID - параметр события в статистике;
PS_STATUS - флаг (Y/N) статуса платежной системы - успешно ли оплачен заказ (для платежных систем, которые позволяют автоматически получать данные по проведенным через них заказам);
PS_STATUS_CODE - код статуса платежной системы (значение зависит от системы);
PS_STATUS_DESCRIPTION - описание результата работы платежной системы;
PS_STATUS_MESSAGE - сообщение от платежной системы;
PS_SUM - сумма, которая была реально оплачена через платежную систему;
PS_CURRENCY - валюта суммы;
PS_RESPONSE_DATE - дата получения статуса платежной системы;
SUM_PAID - сумма, которая уже была оплачена покупателем по данному счету (например, с внутреннего счета);
PAY_VOUCHER_NUM - номер платежного поручения;
PAY_VOUCHER_DATE - дата платежного поручения.
 *
 *
 * Есть в таблице:
 * XML_ID
 * ID_1C
 * EXTERNAL_ORDER
 * BX_USER_ID
 *
*/

namespace Rzn\Order;
use CSaleOrder;
use Exception;

class Order 
{
    protected $id = null;
    protected $data = [];

    protected $items = null;

    protected $itemBlankObject;

    protected $userId = null;

    /**
     * @var null|callable
     */
    protected $dataFilter = null;

    public function retrieveWithXId($id)
    {
        $this->clear();
        $result = CSaleOrder::GetList(["ID"=>"DESC"], ['XML_ID' => $id])->Fetch();
        if ($result) {
            $this->fillWithData($result);
            return true;
        }
        return false;
    }

    public function retrieveWithId($id)
    {
        $this->clear();
        $result = CSaleOrder::GetByID($id);
        if ($result) {
            $this->fillWithData($result);
            return true;
        }
        return false;
    }

    public function fillWithData($data)
    {
        $this->id = $data['ID'];
        unset($data['ID']);
        $this->data = $data;
    }

    public function setStatus($value)
    {
        if ($this->dataFilter) {
            $value = $this->dataFilter($value, 'STATUS_ID');
        }

        $this->data['STATUS_ID'] = $value;
        return $this;
    }

    /**
     * PERSON_TYPE_ID
     */
    public function setPersonType($value)
    {
        if ($this->dataFilter) {
            $value = $this->dataFilter($value, 'PERSON_TYPE_ID');
        }

        $this->data['PERSON_TYPE_ID'] = $value;
    }



    public function getStatus()
    {
        return $this->data['STATUS_ID'];
    }

    /**
     * Внедрение фильтра, который подготавливает данные перед сохранением.
     *
     * @param $object
     * @return $this
     */
    public function setDataFilter($object)
    {
        if (!is_callable($object)) {
            throw new Exception('Фильтр данных должен имет возможность запускаться как функция');
        }
        $this->dataFilter = $object;
        return $this;
    }


    public function setPrice($value)
    {
        $this->data['PRICE'] = $value;
        return $this;
    }

    public function setXml($value)
    {
        $this->data['XML_ID'] = $value;
        return $this;
    }

    public function setCurrency($value = 'RUB')
    {
        $this->data['CURRENCY'] = $value;
        return $this;
    }


    public function setUserId($id)
    {
        $this->userId = $id;
        $this->data['USER_ID'] = $id;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }


    public function getId()
    {
        return $this->id;
    }


    public function save()
    {
        if (!$this->userId) {
            throw new Exception('Для нормального сохранения нужно указать USER_ID');
        }
        $this->data['LID'] = SITE_ID;
        if ($this->id) {
            CSaleOrder::Update($this->id, $this->data);
        } else {
            $id = CSaleOrder::Add($this->data);
            if ($id) {
                $this->retrieveWithId($id);
            }
        }
        return $this->id;
    }

    public function setOrderItemBlankObject($object)
    {
        $this->itemBlankObject = $object;
    }

    public function getOrderItemObject()
    {
        $object = clone($this->itemBlankObject);
        $object->setOrder($this);
        return $object;
    }


    public function setId($id)
    {
        if ($this->id and $this->id != $id) {
            $this->clear();
        }
        $this->id = $id;

        return $this;
    }

    public function clear()
    {
        $this->id = null;
        $this->items = null;
        $this->data = [];
        $this->userId = null;
        return $this;
    }

    /**
     *
     * @return \Bitrix\Main\Entity\DeleteResult|bool
     * @throws \Exception
     */
    public function delete()
    {
        if (!$this->id) {
            return false;
        }
    }


    public function getItems()
    {
        if (!$this->id) {
            return null;
        }
        if ($this->items === null) {
            $itemsObject = $this->getOrderItemObject();
            $this->items = $itemsObject->itemsForOrder();
        }
        return $this->items;
    }
}