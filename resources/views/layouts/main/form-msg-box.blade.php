<!-- Msg Box -->
<div class="row">
    <?php  Helper::showErrors( $errors ); ?>
</div>
<div class="row">
    <?php if( isset( $SuccessArray )):?>
       <?php  Helper::showSuccess( $SuccessArray ); ?>
    <?php endif;?>
</div>
<!-- ENDOF Msg Box -->
