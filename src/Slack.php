<?php

namespace Gahlawat\Slack;

use Log;
use GuzzleHttp\Client;

class Slack
{
    /**
     * Message text
     */
    const TEXT       = 'text';

    /**
     * Receiver channel
     */
    const CHANNEL    = 'channel';

    /**
     * Sender botname
     */
    const USERNAME   = 'username';

    /**
     * Sender display icon
     */
    const ICON_EMOJI = 'icon_emoji';

    /**
     * HTTP client
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * Display icon of message sender
     * @var string
     */
    private $icon;

    /**
     * Message to be sent
     * @var string
     */
    private $message;

    /**
     * Slack account url for sending message
     * @var string
     */
    private $webhook;

    /**
     * Username or group of message receiver
     * @var string
     */
    private $channel;

    /**
     * Display name of message sender
     * @var string
     */
    private $botname;

    /**
     * Slack constructor
     * @param string $webhook
     */
    public function __construct($webhook = null)
    {
        $this->setWebhook($webhook ?? config('slack.webhook_url'));

        $this->from(config('slack.botname', null));

        $this->withIcon(config('slack.icon', null));

        $this->httpClient = new Client;
    }

    /**
     * Statically create a new Slack object
     * @param  string $webhook
     * @return Slack
     */
    public static function create($webhook = null)
    {
        return new static($webhook);
    }

    /**
     * Assign custom incoming webhook
     * @param string $webhook
     */
    public function setWebhook($webhook)
    {
        $this->webhook = trim($webhook);

        if (! filter_var($this->webhook, FILTER_VALIDATE_URL)) {
            throw new \TypeError('Incoming Webhook URL Invalid');
        }

        return $this;
    }

    /**
     * Set '#channel' or '@username' of message receiver
     * @param string $channel
     */
    public function to($channel)
    {
        $this->channel = trim($channel);

        return $this;
    }

    /**
     * Set display icon emoji ot image url
     * @param string $icon
     */
    public function withIcon($icon)
    {
        $this->icon = trim($icon);

        return $this;
    }

    /**
     * Send the message
     * @param  string $message
     * @return boolean
     */
    public function send($message)
    {
        $this->message = trim($message);

        if (empty($this->message)) {
            return false;
        }

        return $this->fireRequest($this->getPayload());
    }

    /**
     * Get Slack payload to be sent
     * @return array
     */
    private function getPayload()
    {
        return [
            self::TEXT       => $this->message,
            self::CHANNEL    => $this->channel,
            self::USERNAME   => $this->botname,
            self::ICON_EMOJI => $this->icon,
        ];
    }

    /**
     * Send request to Slack
     * @return boolean
     */
    private function fireRequest($payload)
    {
        try {
            $response = $this->httpClient->post($this->webhook, [
                'json' => $payload,
            ]);
        } catch (\Exception $e) {
            return false;
        }

        return $this->getResponseMessage($response);
    }

    /**
     * Get Response message from slack
     * @param  GuzzleHttp\Psr7\Response $response [description]
     * @return boolean
     */
    private function getResponseMessage($response)
    {
        if ($response->getStatusCode() == 200) {
            return true;
        }

        return str_replace('_', ' ', title_case('hello_there'));
    }

    /**
     * Username of sender to be displayed in app
     * @param Slack $botname
     */
    public function from($botname)
    {
        $this->botname = trim($botname);

        return $this;
    }

    public function send1($message, $username = null, $emoji = null, $channel = null)
    {
        if (! config('slack.incoming-webhook')) {
            return;
        }

        $emoji    = trim($emoji);
        $channel  = trim($channel);
        $username = trim($username);

        $payload['text']       = $message;
        $payload['username']   = empty($username) ? config('slack.default_username') : $username;
        $payload['icon_emoji'] = empty($emoji) ? config('slack.default_emoji') : $emoji;
        $payload['channel']    = $channel;

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $guzzleClient = new Client;

        try {
            $response = $guzzleClient->post(config('slack.incoming-webhook'), [
                'headers' => $headers,
                'body'    => json_encode($payload),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $response ?? null;
    }
}
