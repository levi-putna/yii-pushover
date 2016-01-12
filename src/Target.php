<?php

namespace consynki\yii\pushover;

use Yii;
use yii\base\ErrorException;
use yii\helpers\VarDumper;
use yii\log\Logger;

/**
 * Class Target
 *
 * Log Target for sending logs to Pushover
 * @package consynki\yii\pushover
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

        foreach ($this->messages as $message) {
            list($msg, $level, $category, $timestamp, $traces) = $message;

            Yii::$app->pushover->send($this->formatMessage($message), ucfirst($category));
        }

    }

    public function formatMessage($message){
        list($text, $level, $category, $timestamp) = $message;

        $level = Logger::getLevelName($level);

        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure

            if ($text instanceof \Exception) {
                $text = (string) $text;
            } else {
                $text = VarDumper::export($text);
            }
        }


        $prefix = $this->getMessagePrefix($message);

        return "Level: " . ucfirst($level) . " \n\n Time: " . date('F j, Y, g:i a (T)', $timestamp) . "\n\n Message:\n $text \n\n {$prefix} \n\n";
    }

    public function getMessagePrefix($message)
    {
        if ($this->prefix !== null) {
            return call_user_func($this->prefix, $message);
        }

        if (Yii::$app === null) {
            return '';
        }

        $request = Yii::$app->getRequest();
        $ip = $request instanceof Request ? $request->getUserIP() : '-';

        /* @var $user \yii\web\User */
        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;

        if ($user && ($identity = $user->getIdentity(false))) {
            $userID = $identity->getId();
        } else {
            $userID = '-';
        }

        /* @var $session \yii\web\Session */
        $session = Yii::$app->has('session', true) ? Yii::$app->get('session') : null;
        $sessionID = $session && $session->getIsActive() ? $session->getId() : '-';

        return "IP Address: $ip \n\n User ID: $userID \n\n Session: $sessionID";
    }
}