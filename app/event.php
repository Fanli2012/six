<?php
// 事件定义文件
return [
    // 事件绑定
    'bind' => [
    ],
    // 事件监听
    'listen' => [
        'AppInit' => [],
        'HttpRun' => [],
        'HttpEnd' => [],
        'LogLevel' => [],
        'LogWrite' => [],
		// 测试
		'OrderShipped' => [
		    'app\listener\SendEmail',
		    'app\listener\SendSms',
		],
    ],
    // 事件订阅
    'subscribe' => [
    ],
];
