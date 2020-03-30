<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.1
 */
 
$jude_theme_obj = wp_get_theme();
?>
<div class="update-nag" id="jude_admin_notice">
	<h3 class="jude_notice_title"><?php
		// Translators: Add theme name and version to the 'Welcome' message
		echo esc_html(sprintf(__('Welcome to %1$s v.%2$s', 'jude'),
				$jude_theme_obj->name . (JUDE_THEME_FREE ? ' ' . esc_html__('Free', 'jude') : ''),
				$jude_theme_obj->version
				));
	?></h3>
	<?php
	if (!jude_exists_trx_addons()) {
		?><p><?php echo wp_kses_data(__('<b>Attention!</b> Plugin "ThemeREX Addons is required! Please, install and activate it!', 'jude')); ?></p><?php
	}
	?><p>
		<a href="<?php echo esc_url(admin_url().'themes.php?page=jude_about'); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> <?php
			// Translators: Add theme name
			echo esc_html(sprintf(__('About %s', 'jude'), $jude_theme_obj->name));
		?></a>
		<?php
		if (jude_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'jude'); ?></a>
			<?php
		}
		if (function_exists('jude_exists_trx_addons') && jude_exists_trx_addons() && class_exists('trx_addons_demo_data_importer')) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'jude'); ?></a>
			<?php
		}
		?>
        <a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'jude'); ?></a>
		<span> <?php esc_html_e('or', 'jude'); ?> </span>
        <a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Options', 'jude'); ?></a>
        <a href="#" class="button jude_hide_notice"><i class="dashicons dashicons-dismiss"></i> <?php esc_html_e('Hide Notice', 'jude'); ?></a>
	</p>
</div>