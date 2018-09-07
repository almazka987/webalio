		<?php wp_footer(); ?>
	<div id="push"></div>
</section>
<!-- end main-container -->
<!-- begin Footer -->
<footer id="footer">
	<div class="container top-footer">
		<div class="row">
			<div class="col-sm-4">
				<p><?php _e("Яковленко Алена", "webalio"); ?><br>
					<?php _e("Веб-верстка, разработка сайтов", "webalio"); ?>
				</p>
			</div>
			<div class="col-sm-6 col-md-4">
				<div id="contacts" class="footer-contacts">
					<span class="contact-item skype"><a href="skype:almazka987?chat"><i class="fab fa-skype fa-fw" aria-hidden="true"></i>@almazka987</a></span>
                    <span class="contact-item paper-plane"><a href="https://t.me/almazka987" target="blank"><i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>@almazka987</a></span>
                    <span class="contact-item github"><a href="https://github.com/aliowebdeveloper" target="blank"><i class="fab fa-github-alt fa-fw" aria-hidden="true"></i>aliowebdeveloper</a></span>
                    <span class="contact-item mail"><a href="mailto:aliowebdeveloper@gmail.com"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>aliowebdeveloper@gmail.com</a></span>
                </div>
			</div>
			<div class="col-sm-4">
				<?php get_sidebar( 'footer3_sidebar' ); ?>
			</div>
		</div>
		</div>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-12 copy">Frantic Coding from Alio © <?php echo date('Y'); ?></div>
				</div>
			</div>
		</div>
</footer>
<div id="alio_to_top"><a href="#"></a></div>
</body>
</html>