<?php

namespace Gahlawat\Slack;

use Log;
use GuzzleHttp\Client;

class Slack
{
    const DEFAULT_ERROR_MESSAGE = 'Slack incoming webhook error';

    public function send($message, $username=null, $emoji=null, $channel=null)
    {
        if (! config('slack.incoming-webhook')) {
            return;
        }

        $emoji = trim($emoji);
        $channel = trim($channel);
        $username = trim($username);

        $payload['text'] = $message;
        $payload['username'] = empty($username) ? config('slack.default_username') : $username;
        $payload['icon_emoji'] = empty($emoji) ? config('slack.default_emoji') : $emoji;
        $payload['channel'] = $channel;

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $guzzleClient = new Client();

        try {
            $response = $guzzleClient->post(config('slack.incoming-webhook'), [
                'headers' => $headers,
                'body'    => json_encode($payload),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        if ($response->getStatusCode() != 200) {
            Log::error(self::DEFAULT_ERROR_MESSAGE);
        }
    }
}
