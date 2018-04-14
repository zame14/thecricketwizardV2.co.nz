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
        <div class="form-group">
            <input type="text" class="search form-control" placeholder="What team are you looking for?" />
        </div>
        <div class="table-responsive">
            <table class="table table-striped results">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Team Name</th>
                        <th scope="col">Province</th>
                        <th scope="col">Country</th>
                    </tr>
                    <tr class="warning no-result">
                        <td colspan="4"><i class="fa fa-warning"></i> No team found</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    foreach (getTeams() as $team) {
                        echo '
                        <tr class="clickable-row" data-href="' . $team->link() . '">
                            <td>' . $i . '</th>
                            <td>' . $team->getTitle() . '</td>
                            <td>' . $team->getProvince() . '</td>
                            <td>' . $team->getCountry() . '</td>
                        </tr>';
                        $i++;
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->