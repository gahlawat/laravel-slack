<?php

namespace Gahlawat\Slack\Test\Unit;

use Gahlawat\Slack\Slack;
use PHPUnit\Framework\TestCase;

class ObjectTest extends TestCase
{
	public function testObjectCreation()
	{
		$slack = new Slack;

		$this->assertInstanceOf(Slack::class, $slack);
	}
}
