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

	public function testFilenameFormat() {
		$this->assertEquals(
			'MyExtension',
			MWStew\Sanitizer::getFilenameFormat( '../../MyExtension' )
		);
		$this->assertEquals(
			'MyExtensionOrSomething',
			MWStew\Sanitizer::getFilenameFormat( '../../MyExtension/../OrSomething' )
		);
		$this->assertEquals(
			'My_Extension_OrSomething',
			MWStew\Sanitizer::getFilenameFormat( 'My_Extension_OrSomething' )
		);
		$this->assertEquals(
			'MyExtension',
			MWStew\Sanitizer::getFilenameFormat( ' My Extension ' )
		);
	}

	public function testSanitizerLowerCamelFormat() {
		$this->assertEquals(
			'myExtension',
			MWStew\Sanitizer::getLowerCamelFormat( 'MyExtension' )
		);
		$this->assertEquals(
			'myExtension',
			MWStew\Sanitizer::getLowerCamelFormat( 'My Extension' )
		);
		$this->assertEquals(
			'myExtension',
			MWStew\Sanitizer::getLowerCamelFormat( 'My.Extension' )
		);
		$this->assertEquals(
			'someExtensionSomething',
			MWStew\Sanitizer::getLowerCamelFormat( 'Some-extension something' )
		);
		$this->assertEquals(
			'someExtensionSomeThing',
			MWStew\Sanitizer::getLowerCamelFormat( 'Some-extension someThing' )
		);
	}

}
