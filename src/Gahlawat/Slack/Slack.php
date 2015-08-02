<?php namespace Gahlawat\Slack;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Log;

class Slack {

    public function send( $message, $username = "config('slack.default_username')", $emoji = "config('slack.default_emoji')" ) {

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
