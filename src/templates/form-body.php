<?php
/**
 * Form template.
 *
 * @author ivanic
 */

?>
<form action="<?php echo esc_url( $args['action'] ); ?>" method="POST">
    <?php // Not escaping content below because it is unmodified the_content. ?>
    <?php echo $args['content']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    <input type="hidden" name="shokka-forms-submit" value="<?php echo esc_html( $args['nonce'] ); ?>"/>
    <input type="hidden" name="form_id" value="<?php echo esc_html( $args['formID'] ); ?>"/>
    <input type="hidden" name="action" value="shokka_forms_submit_form"/>
</form>
