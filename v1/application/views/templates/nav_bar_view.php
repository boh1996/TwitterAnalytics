<!-- Static navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only"><?= $this->lang->line("toggle_navigation"); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><?= $this->lang->line("app_name"); ?></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<?php foreach ( $headers["headers"] as $section => $header ): ?>
					<?php $header_urls = explode(";", $header->url); ?>
					<?php if ( count($headers["pages"][$header->section]) > 1 ): ?>
						<li class="dropdown" data-section="<?= $header->section; ?>" <?= ( $current_section == $header->section ) ? 'data-class="active active-section-header"' : "" ?>>
							<a href="<?= $base_url . $header_urls[0] ?>" class="dropdown-toggle" data-toggle="dropdown"><?= $this->lang->line($header->header_language_key); ?><b class="caret"></b></a>
							<ul class="dropdown-menu">
								<?php foreach ( $headers["pages"][$header->section] as $page ): ?>
									<?php $page_urls = explode(";", $page->url); ?>
									<li <?= ( in_array(ltrim(uri_string(), "/"), explode(";", $page->url)) ) ? 'class="active active-page-header"' : "" ?>>
										<a href="<?= $base_url . $page_urls[0] ?>"><?= $this->lang->line($page->language_key); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php else: ?>
						<li <?= ( $current_section == $header->section ) ? 'class="active active-section-header"' : "" ?>>
							<a href="<?= $base_url . $header_urls[0] ?>"><?= $this->lang->line($header->language_key); ?></a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
				<li class="<?= ( $signed_in ) ? "hidden" : "" ?> <?= ( $current_section == "login" && $signed_in == false ) ? 'active active-section-header' : "" ?>" data-login="false">
                        <a href="<?= $base_url ?>sign_in"><?= $this->lang->line("sign_in"); ?></a>
                </li>
                <li class="<?= ( ! $signed_in ) ? "hidden" : "" ?> <?= ( $current_section == "login" && $signed_in == true ) ? 'active active-section-header' : "" ?>" data-login="true">
                        <a href="<?= $base_url ?>sign_out"><?= $this->lang->line("sign_out"); ?></a>
                </li>
			</ul>
		</div>
	</div>
</div>