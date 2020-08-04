<?php session_start();?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<title>Приложение-задачник</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Главная</a>
					</li>
					<li class="nav-item">
						<?php if($_SESSION['admin']=="admin"){
							?>
							<?php echo $_SESSION['admin']; ?>
							<a  class="nav-link" href="exit.php">Выти</a>
							<?php
						}
						else{
							?>
							<a class="nav-link" href="exit.php">Войти</a>
							<?php
						}
						?>
					</li>
				</ul>
			</div>
		</nav>

	</header>
	<div class="container">
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Пользователь</th>
					<th scope="col">email</th>
					<th scope="col">Текст</th>
					<th scope="col">Статус</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$id = $_GET['id'];
				$bd = mysqli_connect("127.0.0.1", "root", "", "task");
				$query2 = mysqli_query($bd, "SELECT * FROM task where id='$id'");
				$arr = mysqli_fetch_array($query2);
				do{
					$num++;
					?>
					<tr>
						<td><?php echo $arr['name_user']; ?></td>
						<td><?php echo $arr['email']; ?></td>
						<td><?php echo $arr['task_text']; ?></td>
						<td><input type="checkbox" class="status" id="<?php echo $arr['id']; ?>" <?php echo $arr['status']; ?> <?php if ($_SESSION['admin']=="admin"){echo "";} else {echo "disabled";}?>
						></td>
					</tr>
					<?php
				}
				while ($arr = mysqli_fetch_array($query2));
				?>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		$('.status').change(function(){
			var id = $(this).attr('id');
			var f = $(this).is(":checked");
			if (f==true){
				$.get('status.php', {status:'checked', id:id}, function(data) { 
					alert('Запись отмечена как "выполнено"!')
					location.reload();

				}
				);
			} else {
				$.get('status.php', {status:'', id:id}, function(data) { 
					alert('Запись отмечена как "не выполнено"!')
					location.reload();

				}
				);
			}
			
		});

	</script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>
</html>