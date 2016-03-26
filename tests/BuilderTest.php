<?php

class BuilderTest extends PHPUnit_Framework_TestCase {

	public function testBuilderInstance() {
		$params = array(
			'text' => 'response',
			'array' => array( 1, 2, 3 ),
			'object' => array( 'one' => 'two' ),
		);

		$builder = new MWStew\Builder( '', 'My Extension' );
	}
}
