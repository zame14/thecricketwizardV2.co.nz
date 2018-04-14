<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */
?>
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                &copy; Copyright <?=date('Y')?> The Cricket Wizard <i>-</i> <span>Website by: <a href="https://www.azwebsolutions.co.nz" target="_blank">A-Z Web Solutions Ltd</a></span>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
<div id="registrationModal" class="modal">
    <div class="modal-content wpb_animate_when_almost_visible wpb_bounceInDown bounceInDown">
        <span class="fa fa-times" onclick="closeModal()"></span>
        <h2>Create a Cricket Wizard Team Administrator account</h2>
        <div class="registration-form-wrapper">
            <?php
            echo do_shortcode("[contact-form-7 id=16 title=Registration Form]");
            ?>
        </div>
    </div>
</div>
</body>
</html>