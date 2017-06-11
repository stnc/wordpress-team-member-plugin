<?php

function CHfw_shortcode_team($atts, $content = NULL)
{
    global $post, $wp_query, $CHfw_meta_key_team;

    extract(shortcode_atts(array(
        'columns' => '6',
        'items' => '',
    ), $atts));

    $posts_per_page = (strlen($items) > 0) ? intval($items) : -1;

    $args = array(
        'post_type' => 'team',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'ignore_sticky_posts' => 1
    );
    $team = new WP_Query($args);

    $output = '';

			/*	echo '<PRE>';
print_r ( $team);
echo '</PRE>';*/

    while ($team->have_posts()) : $team->the_post();
        $member_meta = get_post_meta($post->ID, $CHfw_meta_key_team, true);
        $member_image_id = get_post_thumbnail_id();
        if ($member_image_id) {
            $image_src = wp_get_attachment_image_src($member_image_id, 'CHfw-teamImageSize');
            $member_image = '<img class="photo expand" src="' . $image_src[0] . '" />';
        } else {
            $member_image = '<span class="img-placeholder"></span>';
        }

        // Content
        $member_name = '<h2>' . get_the_title() . '</h2>';
        $member_status = '';
        if (isset($member_meta['CHfw-teamSetting_Status'])) {
            $member_status = '<h3>' . esc_attr($member_meta['CHfw-teamSetting_Status']) . '</h3>';
            unset($member_meta['CHfw-teamSetting_Status']); // Remove "status" from meta array (social icons loop below)
        }

        if ($member_meta) {
            $icon_names = array(
                'CHfw-teamSetting_facebook' => 'facebook',
                'CHfw-teamSetting_github' => 'github',
                'CHfw-teamSetting_twitter' => 'twitter',
                'CHfw-teamSetting_inteagram' => 'instagram',
                'CHfw-teamSetting_googleplus' => 'google-plus',
                'CHfw-teamSetting_linkedin' => 'linkedin',
                'CHfw-teamSetting_youtube' => 'youtube',
            );

            $social_icons = '   <div class="links  ">';

            foreach ($member_meta as $name => $value) {
                if ($value != '') {
                    $social_icons .= '<a class="sc_fw-social-btn sc_fw-' . esc_attr($icon_names[$name]) . '"  href="' . esc_url($value) . '" target="_blank">
                <i   class="fa fa-' . esc_attr($icon_names[$name]) . '"></i>
                </a>';
                }
            }

            $social_icons .= '</div>';
        } else {
            $social_icons = '';
        }
        $output .= '  <div class="ch-team-person">
                               <div class="col-xs-12 col-sm-6 col-lg-'.esc_attr( $columns ) .' padding-team">
                                    <div class="person box has-links hover "> ' . $member_image . ' <div class="overlay_team"></div>
                                        <div class="name">
                                           ' . $member_name . $member_status. '
                                        </div>
                                        <hr>
                                              ' . $social_icons. '
                                    </div>
                                </div>
                            </div>';

    endwhile;
    wp_reset_postdata();
    return $output;
}
add_shortcode('chfw_team', 'chfw_shortcode_team');
	