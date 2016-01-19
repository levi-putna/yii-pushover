Yii2 PushOver
=====================

Yii2 Pushover provides a component and log targets to send Pushover (https://pushover.net/) messages.

## Install
```
composer require consynki/yii2-pushover "*"
```

Or add `"consynki/yii2-pushover": "*"` to your composer.json file and run composer update

In config file:

```php
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
                'levels' => ['error'],
                'except' => ['yii\web\HttpException:404'],
            ]
        ],
    ],
]
```

You only need to confider the log target if you wish to send messages to pushover via the logging system. If you wish you
can manual send messages directly via the component.

The log trace will support any additional standard [Yii2 log target](http://www.yiiframework.com/doc-2.0/yii-log-target.html) params.

It is recommended to limit the number of messages that are sent via pushover to critical issues. The best option is to only send errors,
in addition you can ignore particular common error types events 404

If application doesn't have `pushover` component, no errors will try to be logged to pushover. This is useful for development environments, for example.

## Usage

### Pushover Component

If you would like to send a message without using the log target you can simply use the component directly

```php
Yii::$app->pushover->send($message, $title, $sound);
```

### Log Target

Exceptions and PHP errors are caught without effort. Standart `Yii::(error|warning|info|trace)` logging works as usual, but you also can use the following format:

```php
Yii::error('Error Message', 'Error Category')
```

