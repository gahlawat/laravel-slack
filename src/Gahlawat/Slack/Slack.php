<?php

namespace Gahlawat\Slack;

use GuzzleHttp\Client;
use Log;

class Slack
{
    const DEFAULT_ERROR_MESSAGE = 'Slack incoming webhook error';
    const DEFAULT_EMOJI = ':ghost:';
    const DEFAULT_BOT = 'jivesh-bot';

    protected $defaultUsername = self::DEFAULT_BOT;
    protected $defaultEmoji = self::DEFAULT_EMOJI;

    public function __construct()
    {
        if (config('slack.default_username')) {
            $this->defaultUsername = config('slack.default_username');
        }

        if (config('slack.default_emoji')) {
            $this->defaultEmoji = config('slack.default_emoji');
        }
    }

    public function send($message, $username = '', $emoji = '')
    {
        if (!trim($username)) {
            $username = $this->defaultUsername;
        }

        if (!trim($emoji)) {
            $emoji = $this->defaultEmoji;
        }

        $sendData = [
            'text' => $message,
            'username' => $username,
            'icon_emoji' => $emoji,
        ];

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $guzzleClient = new Client();

        try {
            $response = $guzzleClient->post(config('slack.incoming-webhook'), [
                'headers' => $headers,
                'body' => json_encode($sendData),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        if ($response->getStatusCode() != 200) {
            Log::error(self::DEFAULT_ERROR_MESSAGE);
        }
    }
}
