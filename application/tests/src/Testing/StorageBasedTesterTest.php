<?php

/**
 * @file
 * Contains \Triquanta\Tests\AccessibilityMonitor\Testing|StorageBasedTesterTest.
 */

namespace Triquanta\AccessibilityMonitor\Testing;

use Triquanta\AccessibilityMonitor\Url;

/**
 * @coversDefaultClass \Triquanta\AccessibilityMonitor\Testing\StorageBasedTester
 */
class StorageBasedTesterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The flooding thresholds.
     *
     * @var int[]
     *   Keys are periods in seconds, values are maximum number of requests.
     *   They represent the maximum number of requests that can be made to a
     *   host in the past period.
     */
    protected $floodingThresholds = [];

    /**
     * The result storage.
     *
     * @var \Triquanta\AccessibilityMonitor\StorageInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resultStorage;

    /**
     * The class under test.
     *
     * @var \Triquanta\AccessibilityMonitor\Testing\StorageBasedTester
     */
    protected $sut;

    /**
     * The testers.
     *
     * @var \Triquanta\AccessibilityMonitor\Testing\TesterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $tester;

    public function setUp()
    {
        $this->floodingThresholds[mt_rand()] = mt_rand();

        $this->resultStorage = $this->getMock('\Triquanta\AccessibilityMonitor\StorageInterface');

        $this->tester = $this->getMock('\Triquanta\AccessibilityMonitor\Testing\TesterInterface');

        $this->sut = new StorageBasedTester($this->tester,
          $this->resultStorage, $this->floodingThresholds);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->sut = new StorageBasedTester($this->tester,
          $this->resultStorage, $this->floodingThresholds);
    }

    /**
     * @covers ::run
     */
    public function testRun()
    {
        $url = new Url();

        $this->tester->expects($this->once())
          ->method('run')
          ->with($url);

        $this->resultStorage->expects($this->once())
          ->method('saveUrl')
          ->with($url);

        $this->assertInternalType('bool', $this->sut->run($url));
    }

}