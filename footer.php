<?php
/**
 * WebsiteNI Starter Theme
 * Footer.
 */
defined('ABSPATH') || exit;
$site_name = get_bloginfo(
    'name',
    'display'
);
$custom_logo_id = get_theme_mod(
    'custom_logo'
);
/**
 * Global company details.
 */
$company_name = function_exists('get_field')
    ? get_field('company_name', 'option')
    : '';
$company_address = function_exists('get_field')
    ? get_field('company_address', 'option')
    : '';
$company_phone = function_exists('get_field')
    ? get_field('company_phone', 'option')
    : '';
$company_email = function_exists('get_field')
    ? get_field('company_email', 'option')
    : '';
/**
 * Fall back to WordPress site name.
 */
if (!$company_name) {
    $company_name = $site_name;
}
/**
 * Telephone href-safe value.
 */
$company_phone_href = preg_replace(
    '/[^0-9+]/',
    '',
    $company_phone
);

$privacy_policy_url = get_privacy_policy_url();

$terms_page = get_page_by_path('terms-and-conditions');
$terms_url = $terms_page ? get_permalink($terms_page) : '';
?>
<footer class="footer bg-primary">

    <!-- Main Footer Content -->

    <div class="grid-container">

        <div class="grid-x grid-padding-x footer-main">

            <div class="cell small-12 medium-6 large-4 footer-company">

                <!-- Company Logo -->

                <div class="footer-logo">

                    <a class="company-logo" href="<?php echo esc_url(
                        home_url('/')
                    ); ?>" title="<?php echo esc_attr(
                         $site_name
                     ); ?>" rel="home">

                        <?php if ($custom_logo_id): ?>

                            <?php
                            echo wp_get_attachment_image(
                                $custom_logo_id,
                                'full',
                                false,
                                array(
                                    'class' => 'custom-logo',
                                    'alt' => $site_name,
                                )
                            );
                            ?>

                        <?php else: ?>

                            <img src="<?php echo esc_url(
                                get_template_directory_uri()
                                . '/assets/images/header/companylogo.svg'
                            ); ?>" alt="<?php echo esc_attr(
                                 $site_name
                             ); ?>">

                        <?php endif; ?>

                    </a>

                </div>


                <!-- Contact Details -->

                <div class="footer-contact">

                    <?php if ($company_address): ?>

                        <p class="footer-address">

                            <?php echo wp_kses_post(
                                nl2br(
                                    esc_html(
                                        $company_address
                                    )
                                )
                            ); ?>

                        </p>

                    <?php endif; ?>


                    <?php if ($company_email): ?>

                        <p class="footer-email">

                            Email:

                            <a href="mailto:<?php echo esc_attr(
                                $company_email
                            ); ?>">
                                <?php echo esc_html(
                                    $company_email
                                ); ?>
                            </a>

                        </p>

                    <?php endif; ?>


                    <?php if ($company_phone): ?>

                        <p class="footer-phone">

                            Phone:

                            <a href="tel:<?php echo esc_attr(
                                $company_phone_href
                            ); ?>">
                                <?php echo esc_html(
                                    $company_phone
                                ); ?>
                            </a>

                        </p>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>
    <!-- Sub Footer -->
    <div class="grid-container full sub-footer bg-secondary">
        <div class="grid-container">
            <div class="grid-x grid-padding-x sub-footer-inner">
                <!-- Left -->
                <div class="cell small-12 large-auto footer-left">
                    <div class="footer-mobile-company hide-for-large">
                        <p>
                            &copy;
                            <?php echo esc_html(
                                wp_date('Y')
                            ); ?>
                            <?php echo esc_html(
                                $company_name
                            ); ?>
                        </p>
                    </div>
                    <div class="footer-links wni-flex">
                        <span class="show-for-large">
                            &copy;
                            <?php echo esc_html(
                                wp_date('Y')
                            ); ?>
                            <?php echo esc_html(
                                $company_name
                            ); ?>
                        </span>
                        <?php if ($privacy_policy_url): ?>
                            <a href="<?php echo esc_url($privacy_policy_url); ?>">
                                Privacy Policy
                            </a>
                        <?php endif; ?>
                        <?php if ($terms_url): ?>
                            <a href="<?php echo esc_url($terms_url); ?>">
                                Terms &amp; Conditions
                            </a>
                        <?php endif; ?>
                        <p class="footer-credit-mobile hide-for-large">
                            Created by
                            <a href="https://www.websiteni.com" target="_blank" rel="noopener noreferrer">
                                WebsiteNI
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Right -->
                <div class="cell small-12 large-shrink footer-right show-for-large">
                    Created by
                    <a href="https://www.websiteni.com" target="_blank" rel="noopener noreferrer">
                        WebsiteNI
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
</div><!-- #wrapper-inner -->

</div><!-- #wrapper -->

</div><!-- #smooth-content -->

</div><!-- #smooth-wrapper -->


<?php get_search_form(); ?>

<?php wp_footer(); ?>

</body>

</html>