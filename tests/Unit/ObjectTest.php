<?php

namespace Gahlawat\Slack\Tests\Unit;

use Gahlawat\Slack\Slack;
use Gahlawat\Slack\Tests\TestCase;

class ObjectTest extends TestCase
{
	public function testObjectCreation()
	{
		$slack = new Slack;

		$this->assertInstanceOf(Slack::class, $slack);
	}
}
