
<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title></title>

		<link href="<?= $assets_path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
	</head>

	<body>
		<div class="container">

		<!-- Static navbar -->
		<div class="navbar navbar-default" role="navigation">
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
			  	<ul class="nav navbar-nav">
					<li class="active"><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
					  	<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Nav header</li>
							<li><a href="#">Separated link</a></li>
							<li><a href="#">One more separated link</a></li>
					  	</ul>
					</li>
			  	</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active">
						<a href="#"><?= $this->lang->line("viewer_section"); ?></a>
					</li>
					<li>
						<a href="#"><?= $this->lang->line("control_panel"); ?></a>
					</li>
				</ul>
			</div>
			</div>

			<div class="jumbotron">
				<h1>Navbar example</h1>
				<p>This example is a quick exercise to illustrate how the default, static navbar and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
				<p>
					<a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>
				</p>
			</div>

		</div>

		<script src="<?= $assets_path; ?>jquery.min.js"></script>
		<script src="<?= $assets_path; ?>bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
