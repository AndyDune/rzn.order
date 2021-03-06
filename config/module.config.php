<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 01.11.14
 * ----------------------------------------------------
 *
 */

return array(

    'view_helpers' => [
    ],

    'bitrix_direct_events' => [
        'sale' => [
            'OnOrderListFilter' => [
                'invokables' => [
                    'AddFilterNotAffiliate'
                    => ['name' => 'Rzn\Order\DirectEventListener\Sale\OnOrderListFilter\AddFilterNotAffiliate',
                        'priority' => 90
                    ],
                ]
            ]
        ]
    ],
    'configurable_event_manager' => [
    ],

    'mediator' => [
        'channels' => [
            'getOrderData' =>
                [
                    'invokable' => 'Rzn\Order\Mediator\GetOrderData',
                ],
        ]

    ],

    //'mediator' => require(__DIR__ . '/module.mediator.config.php'),
    //'waterfall' => require(__DIR__ . '/module.waterfall.config.php'),
    'service_manager' => [
        'invokables' => [
            'pay_system_action' => [
                'name' => 'Rzn\Order\PaySystenActionData',
            ],

            'rzn_order' => [
                'name' => 'Rzn\Order\Order',
                'shared' => false, // сервис заказа не сохраняется для повторного вызова
                'injector' => [
                    'inject' => [
                        'handler' => 'initializer',
                    ],
                    'injectOrderItemObject' => [
                        'handler' => 'setter',
                        'options' => [
                            'set' => 'invokable',
                            'class' => 'Rzn\Order\OrderItem',
                            'method' => 'setOrderItemBlankObject'
                        ]
                    ],

                ],

            ]
        ]
    ],

);
