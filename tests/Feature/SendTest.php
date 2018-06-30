<?php

namespace Gahlawat\Slack\Tests\Unit;

use Slack;
use Gahlawat\Slack\Tests\TestCase;

class SendTest extends TestCase
{

    // Tests
    // testSUccessfulRequest
    // testFailedRequest
    // testFailedRequestWithEmptyMessage
    // testFailedRequestWithWrongUrl
    // testFailedRequestWith

    // *
    //  * @expectedException ArgumentCountError

    // public function testFailedSlackRequestWithEmptyMessage()
    // {

        // dump(config('slack.webhook_url'));
        // config(['slack.webhook_url' => env('SAMPLE_WEBHOOK')]);
        // dd(config('slack.webhook_url'));
        // dd(2);
        // Slack::create(env('SAMPLE_WEBHOOK'))->send('hi');
    // }

    // public function testFailedSlackRequestWithWrongEndpoint()
    // {
    //     // $this->expectException(\Exception::class);
    //     $response = Slack::send('hi');

    //     $this->assertEquals(null, $response);
    // }

    public function testSuccessfulSlackRequest()
    {
        $response = Slack::create()->send('hi');
    	// $response = Slack::create(env('SAMPLE_WEBHOOK'))->send('hi');

        dd($response);

    	$this->assertEquals(200, $response->getStatusCode());
    }
}
