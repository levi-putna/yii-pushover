Yii2 PushOver
=====================

Yii2 Pushover provides a component and log targets to send Pushover (https://pushover.net/) messages.

## Install
```
php composer.phar require consynki/yii2-pushover "dev-master"
```

In config file:

```php
'bootstrap' => ['log', 'raven'],
'components' => [
    'pushover' => [
        'class' => 'consynki\yii\pushover\Pushover',
    	'user_key' => '<your-user-key>',
    	'api_key' => '<your-api-key>',

    ],
    'log' => [
        'targets' => [
            [
                'class' => 'consynki\yii\pushover\Target',
                'levels' => ['error']
            ]
        ],
    ],
]