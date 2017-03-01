</div>
<script type="text/javascript">
    function sidebar_phone(tagName, className)
    {
        var all = document.getElementsByTagName(tagName || "*");
        for(var i=0; i < all.length; i++)
        {
            if(all[i].className.match(new RegExp('(\\s|^)' + className + '(\\s|$)')))
            {
                if(all[i].style.display == "none")
                    all[i].style.display = "";
                else
                    all[i].style.display = "none";
            }
        }
    }
</script>
<div style="display:none"><?php echo stripslashes(get_option('tang_tongji')); ?></div>
<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/scripts.js"></script> 
<!--[if !IE]> -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.corner.js"></script>
<!-- <![endif]-->
</body>
</html>