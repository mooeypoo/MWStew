<?php
require_once "bootstrap.php";

class SanitizerTest extends PHPUnit_Framework_TestCase {

	public function testSanitizerParams() {
		$params = array(
			'text' => 'response',
			'array' => array( 1, 2, 3 ),
			'object' => array( 'one' => 'two' ),
		);

		$sanitizer = new MWStew\Sanitizer( $params );

		$this->assertEquals(
			'response',
			$sanitizer->getParam( 'text' )
		);
		$this->assertEquals(
			array( 1, 2, 3 ),
			$sanitizer->getParam( 'array' )
		);
		$this->assertEquals(
			array( 'one' => 'two' ),
			$sanitizer->getParam( 'object' )
		);
		$this->assertNull(
			$sanitizer->getParam( 'nonexistent' )
		);
	}

	public function testSanitizerKeyFormat() {
		$this->assertEquals(
			'myExtension',
			MWStew\Sanitizer::getKeyFormat( 'MyExtension' )
		);
		$this->assertEquals(
			'myExtension',
			MWStew\Sanitizer::getKeyFormat( 'My Extension' )
		);
		$this->assertEquals(
			'myExtension',
			MWStew\Sanitizer::getKeyFormat( 'My.Extension' )
		);
		$this->assertEquals(
			'someExtensionSomething',
			MWStew\Sanitizer::getKeyFormat( 'Some-extension something' )
		);
		$this->assertEquals(
			'someExtensionSomeThing',
			MWStew\Sanitizer::getKeyFormat( 'Some-extension someThing' )
		);
	}

}
