<?
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * ----------------------------------------------------
 */
//$zendPrefix = '';
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
CModule::AddAutoloadClasses(
    "rzn.order",
    []
);

$eventManager = EventManager::getInstance();
/**
 * Выборка заказов не от филлиата
 * Вот моменты, которые мы будем использовать (bitrix/modules/sale/admin/order.php)
 if (IntVal($filter_affiliate_id)>0) $arFilter["AFFILIATE_ID"] = IntVal($filter_affiliate_id);
foreach(GetModuleEvents("sale", "OnOrderListFilter", true) as $arEvent)
    $arFilterTmp = ExecuteModuleEventEx($arEvent, Array($arFilterTmp));
 */

$eventManager->addEventHandlerCompatible("sale", "OnOrderListFilter", function($filter) {
    if (isset($_REQUEST['filter_affiliate_id']) and substr($_REQUEST['filter_affiliate_id'], 0, 1) == '!') {
        unset($filter['AFFILIATE_ID']);
        $filter['!AFFILIATE_ID'] = preg_replace('|[^0-9]|', '', $_REQUEST['filter_affiliate_id']);
    }
    return $filter;
});
