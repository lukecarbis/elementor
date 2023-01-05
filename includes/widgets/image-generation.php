<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor image generation.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Widget_Image_Generation extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve image generation name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'image-generation';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve image generation title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Image Generation', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve image generation icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-before-after';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'dall-e', 'ai', 'generate' ];
	}

	/**
	 * Register image generation controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Generate', 'elementor' ),
			]
		);

		$this->add_control(
			'prompt',
			[
				'label' => esc_html__( 'Prompt', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'An impressionist oil painting of sunflowers in an empty vase.', 'elementor' ),
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small' => esc_html__( 'Small', 'elementor' ),
					'medium' => esc_html__( 'Medium', 'elementor' ),
					'large' => esc_html__( 'Large', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'generate',
			[
				'label' => esc_html__( 'Generate', 'elementor' ),
				'show_label' => false,
				'type' => Controls_Manager::BUTTON,
				'dynamic' => [
					'active' => true,
				],
				'text' => __( 'Generate', 'elementor' ),
				'event' => 'elementor:generateImage',
			]
		);

		$this->add_control(
			'url',
			[
				'label' => esc_html__( 'Generated Image URL', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => Utils::get_placeholder_image_src(),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render image generation output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'generated_image_src', 'src', $settings['url'] );
		$this->add_render_attribute( 'generated_image_alt', 'alt', $settings['prompt'] );
		$this->add_render_attribute( 'generated_image_size', 'class', 'elementor-size-' . $settings['size'] );

		$image_html = sprintf(
			'<img %1$s %2$s %3$s />',
			$this->get_render_attribute_string( 'generated_image_src' ),
			$this->get_render_attribute_string( 'generated_image_alt' ),
			$this->get_render_attribute_string( 'generated_image_size' )
		);

		// PHPCS - the variable $image_html holds safe data.
		echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render image generation output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'generated_image_src', 'src', settings.url );
		view.addRenderAttribute( 'generated_image_alt', 'alt', settings.prompt );
		view.addRenderAttribute( 'generated_image_size', 'class', 'elementor-size-' + settings.size );

		html = '<img ' +
			view.getRenderAttributeString( 'generated_image_src' ) +
			view.getRenderAttributeString( 'generated_image_alt' ) +
			view.getRenderAttributeString( 'generated_image_size' ) +
			' />';

		print( html );
		#>
		<?php
	}
}
