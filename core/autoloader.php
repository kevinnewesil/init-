<?php namespace core;

	class Autoloader {

		public function registerLoad() {
			spl_autoload_register("\core\Autoloader::load");
		}

		public static function load( $name ) {
			$base = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . \core\Helper::config( 'project' );
			return require_once( $base . DIRECTORY_SEPARATOR . strtolower( str_replace( '\\', '/', $name ) ) . '.php' );
		}

	}