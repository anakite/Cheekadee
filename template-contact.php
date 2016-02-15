<?php
/**
 * Template Name: Contact Page
 *
 * This is the template that displays a contact form.
 *
 * @package bswp
 */

if(isset($_POST['submitted'])) {
    if(trim($_POST['contactName']) === '') {
        $nameError = true;
        $hasError = true;
    } else {
        $name = trim($_POST['contactName']);
    }

    if(trim($_POST['email']) === '')  {
        $emailError = true;
        $hasError = true;
    } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
        $emailError = true;
        $hasError = true;
    } else {
        $email = trim($_POST['email']);
    }

    if(trim($_POST['comments']) === '') {
        $commentError = true;
        $hasError = true;
    } else {
        if(function_exists('stripslashes')) {
            $comments = stripslashes(trim($_POST['comments']));
        } else {
            $comments = trim($_POST['comments']);
        }
    }


    if(!isset($hasError)) {
        $emailTo = get_option('admin_email');
        if (!isset($emailTo) || ($emailTo == '') ){
            $emailTo = get_option('admin_email');
        }
        $subject = __('From ','bswp').$name;
        $body = __('Name: ','bswp').$name."\n".__('Email: ','bswp').$email."\n".__('Comments: ','bswp').$comments;
        $headers = __('From: ','bswp') .$name. ' <'.$emailTo.'>' . "\r\n" . __('Reply-To:','bswp') .$name. '<'.$email.'>';

        wp_mail($emailTo, $subject, $body, $headers);
        $emailSent = true;
    }

}

get_header(); ?>

<?php
 ?>

<div class="container">
	<div class="row">

	<div id="primary" class="col-md-9 col-lg-9">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>

				          <?php if(isset($emailSent) && $emailSent == true) { ?>
				                <div class="alert alert-success" role="alert">
				                    <p><?php _e('Thanks, your email was sent successfully.', 'bswp'); ?></p>
				                </div>
				            <?php } else { ?>

				                <?php if(isset($hasError) || isset($captchaError)) { ?>
				                    <div class="alert alert-danger alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong><?php _e('Error!', 'bswp'); ?></strong> <?php _e('Please try again.', 'bswp'); ?>
									</div>
				                <?php } ?>

						        <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
						            <div class="form-group <?php if(isset($nameError)) { echo "has-error has-feedback"; }?>">
						                    <label class="control-label" for="contactName"><?php _e('Name', 'bswp'); ?></label>
						                    <input class="form-control" type="text" name="contactName" id="contactName" value="" />
						                    <?php if(isset($nameError)) { ?>
						                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
						                    <?php } ?>
						              
						               </div>
						               <div class="form-group <?php if(isset($emailError)) { echo "has-error has-feedback"; }?>">
						                    <label class="control-label" for="email"><?php _e('Email', 'bswp'); ?></label>
						                
						                    <input class="form-control" type="text" name="email" id="email" value="" />
						                    <?php if(isset($emailError)) { ?>
						                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
						                    <?php } ?>
						               
						               </div>
						                <div class="form-group <?php if(isset($commentError)) { echo "has-error has-feedback"; }?>">
						                    <label class="control-label" for="commentsText"><?php _e('Message', 'bswp'); ?></label>
						               
						                    <textarea class="form-control" name="comments" id="commentsText" rows="10" cols="20"></textarea>
						                     <?php if(isset($commentError)) { ?>
						                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
						                    <?php } ?>
						                
						               </div>
						               <div class="form-actions">
						                    <button type="submit" class="btn btn-primary"><?php _e('Send Email', 'bswp'); ?></button>
						                    <input type="hidden" name="submitted" id="submitted" value="true" />
						               </div>
						        </form>

				        <?php } ?>
				                    
						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'bswp' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->
					<footer class="entry-footer">
						<?php edit_post_link( __( 'Edit', 'bswp' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar('contact'); ?>
<?php get_footer(); ?>