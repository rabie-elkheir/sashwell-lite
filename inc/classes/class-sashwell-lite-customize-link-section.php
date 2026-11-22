<?php
/**
 * Customizer section that is a single link (the Pro version), shown at the top of the list.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * A section with no controls that renders as an outbound link.
 */
class Sashwell_Lite_Customize_Link_Section extends WP_Customize_Section {

	/**
	 * Section type.
	 *
	 * @var string
	 */
	public $type = 'sashwell-lite-link';

	/**
	 * Link text.
	 *
	 * @var string
	 */
	public $link_text = '';

	/**
	 * Link URL.
	 *
	 * @var string
	 */
	public $link_url = '';

	/**
	 * Data for the JavaScript template.
	 *
	 * @return array
	 */
	public function json() {
		$json              = parent::json();
		$json['link_text'] = $this->link_text;
		$json['link_url']  = esc_url_raw( $this->link_url );
		return $json;
	}

	/**
	 * Show the section even though it has no controls.
	 *
	 * @return bool
	 */
	public function active_callback() {
		return true;
	}

	/**
	 * Section template.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				{{ data.title }}
				<# if ( data.link_text && data.link_url ) { #>
					<a class="button button-secondary alignright" href="{{ data.link_url }}" target="_blank" rel="noopener">{{ data.link_text }}</a>
				<# } #>
			</h3>
		</li>
		<?php
	}
}
