<?php

/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 25.03.2016                                     |
 * ----------------------------------------------------
 *
 */
namespace Rzn\Order;
use CSalePaySystemAction;
use CSalePersonType;

class PaySystenActionData
{
    protected $paySystemId = null;

    protected $personTypeId = null;

    protected $actionId = null;

    protected $actionFields = null;

    protected $actionParams = null;


    /**
     * Внедрение id существующей платежной системы.
     *
     * @param $id
     */
    public function setPaySystemId($id)
    {
        $this->clear();
        $this->paySystemId = $id;
        return $this;
    }

    /**
     * @param $id
     */
    public function setPersonTypeId($id)
    {
        $this->clear();
        $this->personTypeId = $id;
        return $this;
    }

    public function getPersonTypeId()
    {
        return $this->personTypeId;
    }


    public function retriewe()
    {
        if ($this->actionId) {
            return true;
        }

        if (!$this->paySystemId) {
            throw new Exception('Не указан обязятельный paySystemId');
        }

        if (!$this->personTypeId) {
            return $this->retrieweWithPersonType($this->personTypeId);
        }

        $dbPersonType = CSalePersonType::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array());

        $personTypeIdNeed = null;
        while ($arPersonType = $dbPersonType->Fetch()) {
            $result = $this->retrieweWithPersonType($arPersonType["ID"]);
            if ($result) {
                return $result;
            }
        }
        return false;
    }

    protected function retrieweWithPersonType($personType)
    {
        $action = CSalePaySystemAction::GetList(
            array(),
            array("PAY_SYSTEM_ID" => $this->paySystemId, "PERSON_TYPE_ID" => $personType)
        )->Fetch();
        if (!$action) {
            return false;
        }

        $this->actionId = $action["ID"];
        $this->actionFields = $action;
        $this->actionParams = CSalePaySystemAction::UnSerializeParams($action["PARAMS"]);
        return true;
    }



        public function clear()
    {
        $this->actionId = null;
    }

    /**
     *
     *  Вовращаемые поля
        [ID] => 6
        [PAY_SYSTEM_ID] => 6
        [PERSON_TYPE_ID] => 1
        [NAME] => MasterCard, VISA
        [ACTION_FILE] => /bitrix/php_interface/include/sale_payment/rzn_sberbank
        [RESULT_FILE] =>
        [NEW_WINDOW] => N
        [PARAMS] => Сериализовнный массив параметров
        [TARIF] =>
        [ENCODING] => utf-8
        [LOGOTIP] =>
     *
     * @return bool|null
     */
    public function getFields()
    {
        if (!$this->retriewe()) {
            return false;
        }
        return $this->actionFields;
    }


    public function getParams()
    {
        if (!$this->retriewe()) {
            return false;
        }
        return $this->actionParams;
    }

    public function getParamsValues()
    {
        $params = [];
        if (!$this->retriewe()) {
            return false;
        }
        foreach ($this->actionParams as $name => $valueArray) {
            $params[$name] = $valueArray['VALUE'];
        }
        return $params;

    }

}