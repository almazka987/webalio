<?php get_header(); ?>
<!-- begin Content -->
		<div class="content">
				<article>
				<!-- begin section About -->
				<div class="container">
				<div class="row">
					<div class="col-md-offset-6 col-md-6">
						<h2 id="about">Обо мне</h2>
						<p>Приветствую всех, кто зашел на мой сайт! Меня зовут Алена, я живу в городе Омске. Веб-версткой занимаюсь около трех лет, и на данный момент мной сверстано уже много сайтов различной тематики и сложности.</p>
						<p>Верстаю сайты по готовому PSD-шаблону. Выполняю верстку с нуля, а также могу править и доводить до ума уже сверстанные страницы.</p>
						<p>Имея со мной дело, Вы можете быть уверены в моей отзывчивости к Вам, ответственности в выполнении ТЗ.<br>
						Смело обращайтесь, сегодня отличный день для нашего с Вами сотрудничества.
						</p>
					</div>
				</div>
				</div>
				<div class="container services">
					<div class="row">
						<div class="col-md-4 item">
							<img src="<?php bloginfo('template_url') ?>/img/antenna.png" height="159" width="159" alt="//">
							<h3>Знаю и умею:</h3>
							<ul>
								<li>HTML, HTML5, CSS</li>
								<li>SASS, Compass, GIT</li>
								<li>JS, jQuery</li>
								<li>WordPress, Bootstrap</li>
								<li>PHP, MySQL</li>
								<li>Adobe Photoshop</li>
							</ul>
						</div>
						<div class="col-md-4 item">
							<img src="<?php bloginfo('template_url') ?>/img/rocket.png" height="159" width="159" alt="//">
							<h3>В итоге:</h3>
							<ul>
								<li>Качественный валидный HTML5/CSS код, оптимизированный для поисковых машин</li>
								<li>Оптимизированная графика, изображения оптимального веса и качества для web</li>
								<li>js-скрипты на основе библиотеки jQuery</li>
							</ul>
						</div>
						<div class="col-md-4 item">
							<img src="<?php bloginfo('template_url') ?>/img/astronavt-mini.png" height="159" width="159" alt="//">
							<h3>Мой подход</h3>
							<p>В подходе к делам я перфекционистка, поэтому особое внимание уделяю структурированности кода, комментариям, грамотным именам классов.<br>
							Также в работе мне помогает такое качество, как усидчивость.
							</p>
						</div>
					</div>
				</div>
				<!-- end section About -->
				<!-- begin section Works -->
				<section class="odd">
					<div class="bg-top"></div>
					<div class="bg-middle">	
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div class="works">
										<h2 id="works">Мои работы:</h2>
										<ul id="filter">
											<li class="filter active" data-filter="all"><span>Все</span></li>
											<li class="filter" data-filter=".sites"><span>Сайты-визитки</span></li>
											<li class="filter" data-filter=".lendings"><span>Лендинги</span></li>
											<li class="filter" data-filter=".eshops"><span>Интернет-магазины</span></li>
										</ul>
										<ul id="container">
											<?php if(have_posts()) : ?>
												<?php while (have_posts()) : the_post(); ?>
													<li class="mix <?php the_field('tag'); ?>">
														<img src="<?php the_field('mini'); ?>" height="320" width="300" alt="<?php the_title(); ?>">
														<span class="blank">
															<span class="layer"><h4><?php the_title(); ?></h4></span>
															<a href="<?php the_field('link'); ?>" class="stage-lnk link" target="_blank"><b></b><span>Перейти на сайт</span></a>
															<a href="<?php the_field('full-img'); ?>" class="stage-lnk zoom" rel="prettyPhoto[gallery]"><b></b><span>Увеличить скриншот</span></a>
														</span>
													</li>
												<?php endwhile; ?>
											<?php endif ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="bg-bottom"></div>
				</section>
				<!-- end section Works -->
				<!-- begin section Order -->
				<section class="container order">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
									<h2 id="order">Как заказать верстку</h2>
									<p>
									Чтобы заказать web-верстку, просто свяжитесь со мной через Skype - <span>almazka987</span> или напишите на мой e-mail по адресу <span>almazka@flylady.su</span>. Желательно сразу выслать PSD-макет или скриншот проекта, для того, чтобы я могла оценить сложность работы и сказать Вам срок и стоимость выполнения. В переписке будут оговорены все спорные и дополнительные вопросы.
									</p>
							</div>
						</div>
					</div>
				</section>
				<!-- end section Order -->
				</article>
		</div>
<?php get_footer(); ?>