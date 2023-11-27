<?php if (!isset($_SESSION)) session_start();?>
<div class="container-fluid">
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse justify-content-center" id="navbarNavDarkDropdown">
		<ul class="navbar-nav">
			<li class="nav-item col-sm-12 col-md-auto">
				<button type="button" class="btnNav col-12" onclick="window.location.href='public.php'">Home</button>
			</li>
			<li class="nav-item dropdown col-sm-12 col-md-auto">
				<button type="button" class="btnNav col-12 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Serviços</button>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="viewClinicas.php">Clinicas</a></li>
				</ul>
			</li>
			<li class="nav-item col-sm-12 col-md-auto">
				<button type="button" class="btnNav col-12" onclick="window.location.href=''">Quem Somos</button>
			</li>
			<li class="nav-item col-sm-12 col-md-auto">
				<button type="button" class="btnNav col-12" onclick="window.location.href=''">Contato</button>
			</li>
			<li class="nav-item">
				<?php 
				if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
					echo '<button type="button" class="btnNav col-sm-12 col-md-12 col-lg-auto" onclick="window.location.href='."'../controller/logout.php'".'">sair</button>';

				} else {
					echo '<button type="button" class="btnNav col-sm-12 col-md-12 col-lg-auto" onclick="window.location.href='."'../view/login.php'".'">Acessar Conta</button>';
				}
				?>
			</li>
		</ul>
	</div>
</div>