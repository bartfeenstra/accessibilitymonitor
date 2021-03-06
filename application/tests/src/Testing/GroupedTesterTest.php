<?php

/**
 * @file
 * Contains \Triquanta\Tests\AccessibilityMonitor\Testing|GroupedTesterTest.
 */

namespace Triquanta\AccessibilityMonitor\Testing;

use Triquanta\AccessibilityMonitor\Url;

/**
 * @coversDefaultClass \Triquanta\AccessibilityMonitor\Testing\GroupedTester
 */
class GroupedTesterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The logger.
     *
     * @var \Psr\Log\LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $logger;

    /**
     * The class under test.
     *
     * @var \Triquanta\AccessibilityMonitor\Testing\GroupedTester
     */
    protected $sut;

    /**
     * The testers.
     *
     * @var \Triquanta\AccessibilityMonitor\Testing\TesterInterface|\PHPUnit_Framework_MockObject_MockObject[]
     */
    protected $testers = [];

    public function setUp()
    {
        $this->logger = $this->getMock('\Psr\Log\LoggerInterface');

        $this->testers[] = $this->getMock('\Triquanta\AccessibilityMonitor\Testing\TesterInterface');
        $this->testers[] = $this->getMock('\Triquanta\AccessibilityMonitor\Testing\TesterInterface');

        $this->sut = new GroupedTester($this->logger);
        foreach ($this->testers as $tester) {
            $this->sut->addTester($tester);
        }
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->sut = new GroupedTester($this->logger);
    }

    /**
     * @covers ::run
     * @covers ::addTester
     */
    public function testRun()
    {
        $url = new Url();

        foreach ($this->testers as $tester) {
            $tester->expects($this->once())
              ->method('run')
              ->with($url);
        }

        $this->assertInternalType('bool', $this->sut->run($url));
    }

}
