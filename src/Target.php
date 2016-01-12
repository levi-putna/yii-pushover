<?php

namespace consynki\yii\pushover;

use Yii;
use yii\base\ErrorException;
use yii\log\Logger;

/**
 * Created by PhpStorm.
 * User: leviputna
 * Date: 12/01/2016
 * Time: 2:40 PM
 */
class Target extends \yii\log\Target
{

    /**
     * @var array Raven client options.
     * @see \Raven_Client::__construct for more details
     */
    public $clientOptions = [];

    public function init()
    {
        parent::init();

    }

//    protected function getContextMessage()
//    {
//        return '';
//    }

    /**
     * Exports log [[messages]] to a specific destination.
     */
    public function export()
    {

        Yii::$app->pushover->send('test', 'message');

    }
}