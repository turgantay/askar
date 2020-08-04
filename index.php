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
		<div class="row">
			<form method="POST">
				<select name="sort">
					<option value="name_user">Пользователь</option>
					<option value="email">email</option>
					<option value="status">Статус</option>
				</select> &nbsp
				<button type="submit">Сортировать</button>
			</form>&nbsp
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
				Добавить запись
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Добавить запись</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-group">
									<label for="name_user">Имя</label>
									<input type="text" name="name_user" class="form-control" id="name_user">
								</div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
								</div>
								<div class="form-group">
									<label for="text">Текст</label>
									<textarea class="form-control" id="text" name="text" rows="3"></textarea>
								</div>

							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
							<button type="button" class="btn btn-primary" id="insert">Добавить</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Пользователь</th>
					<th scope="col">email</th>
					<th scope="col">Статус</th>
					<th scope="col">Смотреть</th>
				</tr>
			</thead>
			<tbody>
				<?php
				
				$page = $_GET['page'];
				if (empty($page)) {
					$page = 3;
				}
				if(empty($_POST['sort'])){
					$sort = 'id';
				}
				else{
					$_SESSION['sort'] = $_POST['sort'];
					$sort = $_SESSION['sort'];

				}
				if(empty($_SESSION['sort'])){
					$_SESSION['sort'] = 'id';
				}
				$sort = $_SESSION['sort'];
				$bd = mysqli_connect("127.0.0.1", "root", "", "task");
				$query1 = mysqli_query($bd, "SELECT * From task");
				$rows = $query1->num_rows;
				$offset = $page-3;
				$query2 = mysqli_query($bd, "SELECT * FROM task ORDER BY $sort LIMIT $offset,3 ");
				$arr = mysqli_fetch_array($query2);
				do{
					$num++;
					?>
					<a href="single.php?id=<?php echo $arr['id']; ?>">
					<tr>

						<td><?php echo $arr['name_user']; ?></td>
						<td><?php echo $arr['email']; ?></td>
						<td><input type="checkbox" class="status" id="<?php echo $arr['id']; ?>" <?php echo $arr['status']; ?> <?php if ($_SESSION['admin']=="admin"){echo "";} else {echo "disabled";}?>
						></td>
						<td><a href="single.php?id=<?php echo $arr['id']; ?>">Смотреть</a></td>
					</tr>
					
					<?php
				}
				while ($arr = mysqli_fetch_array($query2));
				?>
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<?php if($_GET['page']>3){?>
					<li class="page-item"><a class="page-link" href="?page=<?php echo $_GET['page']-3; ?>"><</a></li>
					<?php
				}
				$pages = $rows/3+1;
				for ($i=1; $i < $pages; $i++) { 
					?>
					<li class="page-item"><a class="page-link" href="?page=<?php echo $i*3; ?>"><?php echo $i; ?></a></li>
					<?php
				}
				if($i>($_GET['page']/3+1)){
					?>
					<li class="page-item"><a class="page-link" href="?page=<?php echo $_GET['page']+3; ?>">></a></li>
				<?php } ?>
			</ul>
		</nav>
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
		$('#myModal').on('shown.bs.modal', function () {
			$('#myInput').trigger('focus')
		})

		$('#insert').click(function(){
			var name_user = $('#name_user').val();
			var email = $('#email').val();
			var text = $('#text').val()
			$.get('insert.php', {name_user:name_user, email:email, text:text}, function(data) { 
				alert("Запись добвлен успешно!")
					location.reload();

				});
		})


	</script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>
</html>