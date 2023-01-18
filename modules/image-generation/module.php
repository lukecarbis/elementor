<?php
namespace Elementor\Modules\ImageGeneration;

use Elementor\Core\Base\Module as BaseModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends BaseModule {
	public function get_widgets() {
		return [
			'Image_Generation',
		];
	}

	public function get_name() {
		return 'image-generation';
	}
}
