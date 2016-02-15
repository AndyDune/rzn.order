<?php

/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 15.02.2016                                  |
 * ----------------------------------------------------
 *
 */
namespace Rzn\Order\DirectEventListener\Sale\OnOrderListFilter;
class AddFilterNotAffiliate
{
    public function __invoke($filter)
    {
        if (isset($_REQUEST['filter_affiliate_id']) and substr($_REQUEST['filter_affiliate_id'], 0, 1) == '!') {
            unset($filter['AFFILIATE_ID']);
            $filter['!AFFILIATE_ID'] = preg_replace('|[^0-9]|', '', $_REQUEST['filter_affiliate_id']);
        }
        return $filter;
    }
}