<?php namespace Gahlawat\Slack;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Log;

class Slack {

    protected $defaultUsername;
    protected $defaultEmoji;

    public function __construct() {

        if ( config('slack.default_username') ) {
            $this->defaultUsername  = config('slack.default_username');
        } else {
            $this->defaultUsername  = 'jivesh-bot';
        }

        if ( config('slack.default_emoji') ) {
            $this->defaultEmoji  = config('slack.default_emoji');
        } else {
            $this->defaultEmoji = ':ghost:';
        }

    }

    public function send( $message, $username = "", $emoji = "" ) {

        if ( !trim($username) ) {
            $username = $this->defaultUsername;
        }

        if ( !trim($emoji) ) {
            $emoji = $this->defaultEmoji;
        }

        $sendData = [
            'text'       => $message,
            'username'   => $username,
            'icon_emoji' => $emoji,
        ];
        $headers['Content-Type'] = 'application/json';

        $guzzleClient = new Client();

        try {
            $response = $guzzleClient->post( config('slack.incoming-webhook'), [
                'headers' => $headers,
                'body'    => json_encode($sendData),
            ]);
        } catch ( Exception $e) {
            Log::error($e->getMessage());
        }

        if ( $response->getStatusCode() != 200 ) {
            Log::error('Slack incoming webhook error');
        }
    }

}
