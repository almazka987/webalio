<?php

class Test_Avada_Functions extends WP_UnitTestCase {

	public function test_avada() {
		$avada = Avada();
		$this->assertTrue( is_object( $avada ) );
	}

	public function test_avada_font_awesome_name_handler() {
		$this->assertEquals( 'fa-', avada_font_awesome_name_handler( '' ) );
		$this->assertEquals( 'fa-facebook', avada_font_awesome_name_handler( 'icon-facebook' ) );
		$this->assertEquals( 'fa-facebook', avada_font_awesome_name_handler( 'fa-facebook' ) );
		$this->assertEquals( 'fa-facebook', avada_font_awesome_name_handler( 'facebook' ) );
	}
}
