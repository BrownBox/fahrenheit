<?php
bb_theme::section('name=panels-bottom&file=panels-bottom.php&inner_class=inline-block');
bb_theme::section('name=footer&file=footer.php&inner_class=row hide-for-print&type=footer');
bb_theme::section('name=copyright&file=copyright.php&inner_class=row hide-for-print&type=footer');
?>
                        </section>
                    </div><!-- end off-canvas-content -->
                </div><!-- end off-canvas-wrapper-inner -->
            </div><!-- end off-canvas-wrapper -->
        </div><!-- end everything -->
        <?php wp_footer(); ?>
        <script>
            var zurb = jQuery.noConflict();
            zurb(document).foundation();

            if (typeof ajaxurl === 'undefined') {
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            }
<?php if ( ! is_admin() ) { ?>
            var $buoop = {c:2};
            function $buo_f() {
                var e = document.createElement("script");
                e.src = "//browser-update.org/update.js";
                document.body.appendChild(e);
            }
<?php } ?>
            try {
                document.addEventListener("DOMContentLoaded", $buo_f, false);
            } catch(e) {
                window.attachEvent("onload", $buo_f);
            }
        </script>
    </body>
</html>