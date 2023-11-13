<div class="container-fluid">
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse justify-content-center" id="navbarNavDarkDropdown">
		<ul class="navbar-nav">
			<li class="nav-item">
				<button type="button" class="btnNav col-sm-12 col-md-auto" onclick="window.location.href='public.php'">Home</button>
			</li>
			<li class="nav-item dropdown">
				<button type="button" class="btnNav col-sm-12 col-md-auto dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Serviços</button>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="#">Clinicas</a></li>
					<li><a class="dropdown-item" href="#">Exames</a></li>
				</ul>
			</li>
			<li class="nav-item">
				<button type="button" class="btnNav col-sm-12 col-md-auto" onclick="window.location.href=''">Quem Somos</button>
			</li>
			<li class="nav-item">
				<button type="button" class="btnNav col-sm-12 col-md-auto" onclick="window.location.href=''">Contato</button>
			</li>
			<li class="nav-item">
				<?php 
				if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
					echo "<button type='button' class='btnNav col-sm-12 col-md-auto' onclick='window.location.href=../controller/logout.php'>Sair</button>";

				} else {
					echo '<button type="button" class="btnNav col-sm-12 col-md-auto" onclick="window.location.href='."'../view/login.php'".'">Acessar Conta</button>';
				}
				?>
			</li>
		</ul>
	</div>
</div>