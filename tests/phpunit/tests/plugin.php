<?php

namespace Google\Gutenberg_Bento\Tests;

use WP_UnitTestCase;

class Plugin_Test extends WP_UnitTestCase {
	public function test_boostrap() {
		$this->assertSame( 10, has_action( 'init', '\Google\Gutenberg_Bento\register_bento_assets' ) );
	}
}
