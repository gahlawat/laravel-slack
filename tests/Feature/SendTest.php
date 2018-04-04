<?php

namespace Gahlawat\Slack\Tests\Unit;

use Slack;
use Gahlawat\Slack\Tests\TestCase;

class SendTest extends TestCase
{
    /**
     * @expectedException ArgumentCountError
     */
    public function testFailedSlackRequestWithEmptyMessage()
    {
    	Slack::send();
    }

    public function testFailedSlackRequestWithWrongEndpoint()
    {
        $this->expectException(\ErrorException::class);

        $res = Slack::send('hi');
    }

    public function testSuccessfulSlackRequest()
    {
    	config(['slack.incoming-webhook' => env('SAMPLE_WEBHOOK')]);

    	$response = Slack::send('hi');

    	$this->assertEquals(200, $response->getStatusCode());
    }
}
