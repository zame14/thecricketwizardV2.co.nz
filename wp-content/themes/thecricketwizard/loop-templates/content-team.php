<?php
$team = new Team($post);
$_SESSION['cw']['teamid'] = $team->id();
print_r($_SESSION);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="row">
            <div class="col-xl-12 page-title">
                <h1><?=$team->getTitle()?></h1>
            </div>
        </div>
    </div>
    <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->
</article>