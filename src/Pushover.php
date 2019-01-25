<?php

    namespace consynki\yii\pushover;

    use coderovich\pushover\Model\Push;
    use coderovich\pushover\PushManager;
    use yii\base\Component;

    /**
     * Class Pushover
     *
     * A component used to send notifications to Pushover
     *
     * @package consynki\yii\pushover
     */
    class Pushover extends Component
    {

        public $user_key;
        public $api_key;
        public $default_sound = 'pushover';

        protected $client;

        public function init()
        {
            parent::init();
        }

        public function send($message, $title = null, $sound = null)
        {

            //work out what sound to use
            $sound = (is_null($sound)) ? $this->default_sound : $sound;

            //setup the message
            $notification = new Push();
            $notification->setMessage($message);
            $notification->setTitle($title);
            $notification->setSound($sound);

            // Push it!
            $client = $this->getClient();
            $client->push($notification);

        }

        private function getClient()
        {
            if (is_null($this->client)) {
                $this->client = new PushManager($this->user_key, $this->api_key);
            }

            return $this->client;
        }
    }
