<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package understrap
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- .entry-header -->

    <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>

    <div class="entry-content">
        <?php the_content(); ?>
        <form id="enterFixtureForm">
            <h2>Select Competition</h2>
            <p>Select which competition the fixture was played in from the drop down list below.  To add a new competition, click the <span class="fa fa-plus-circle"></span> button.</p>
            <div class="tab">
                <select id="select-comp" class="form-control">
                    <option value="0">Select competition</option>
                    <?php
                    foreach(getCompetitions($_SESSION['cw']['teamid']) as $competition) {
                        echo '<option value="' . $competition->getTitle() . '">' . $competition->getTitle() . '</option>';
                    }
                    ?>
                </select><div class="fa fa-plus-circle add-new-comp" onclick="openModal('#newCompModal');"></div>
            </div>
            <div class="steps-wrapper">
                <span class="step active"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>
        </form>

    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
<div id="newCompModal" class="modal">
    <div class="modal-content wpb_animate_when_almost_visible wpb_bounceInDown bounceInDown">
        <span class="fa fa-times" onclick="closeModal()"></span>
        <h2>Add a new Competition</h2>
        <div class="registration-form-wrapper">
            <?php
            //echo do_shortcode("{!{cred_form form='add-competition'}!}");
            cred_form('add-competition',$post_id=false);
            ?>
        </div>
    </div>
</div>