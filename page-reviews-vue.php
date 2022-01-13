<?php

/*
Template name: Reviews Page Vue
*/

acf_form_head();
get_header();

//the_content();
?>

<div class="review-wrap">
<div class="review-form">
        <h2>Leave Your Review Here</h2>
        <?php acf_form(array(
            'post_id'       => 'new_post',
            'new_post'      => array(
                'post_type'     => 'reviews',
                'post_status'   => 'publish'
            ),
            'submit_value'  => 'Leave Your Review'
        )); ?>
    </div>
    <div class="review-list">
        <?php echo do_shortcode('[latestReviews]'); ?>
    </div>
</div>



<script>
    let rateGroup = document.querySelector('.acf-radio-list');
    rateGroup.classList.add("rating__group");
    let rateLi = rateGroup.querySelectorAll('li');
    for (var i = 0; i < rateLi.length; i++) {
        let rateInput = rateLi[i].querySelector('input');
        rateInput.classList.add("rating__star");
        rateLi[i].outerHTML = rateInput.outerHTML;
    }
</script>

<?php
get_footer();