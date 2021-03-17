<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Meuapp - Sistema</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="shortcut icon" href="favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
<body>
	<div class="container">
		<h1>PHP + MySQL + Redis <small>sistema</small> <span class="label label-success">novo</span></h1>
		<img class="img-responsive" src="logo.png" alt="Logo" width="64" height="64"> 
		<p>
		<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Selecione <span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Menu</li>
					<li><a href="index.php">Home</a></li>
					<li><a href="info.php">PHP Info</a></li>
					<li class="divider"></li>
					<li class="disabled"><a href="#">Fechar</a></li>
				</ul>
		</div>
		</p>
		<hr />

		<div class="panel panel-info">
			<div class="panel-heading">Lista</div>
			<div class="panel-body">
			
			<?php

				$redis = new Redis();
				$redis->connect('meucache', 6379);
				//$redis->auth('REDIS_PASSWORD');

				$key = 'PRODUCTS';

				if (!$redis->get($key)) {
					$source = 'Database MySQL';
					$database_name     = 'meubanco';
					$database_user     = 'meuuser';
					$database_password = 'meupass10';
					$mysql_host        = 'meudb';

					$pdo = new PDO('mysql:host=' . $mysql_host . '; dbname=' . $database_name, $database_user, $database_password);
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$sql  = "SELECT * FROM products";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$products[] = $row;
					}

					$redis->set($key, serialize($products));
					$redis->expire($key, 10);

				} else {
					$source = 'Cache Redis';
					$products = unserialize($redis->get($key));

				}

				echo '<p class="text-primary"> Dados recuperados do servidor: <strong>'. $source . '</strong></p>';
				//print_r($products);
				
				echo '<table id="datatable2-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
				<thead>
				  <tr>
					<th>ID</th>
					<th>Nome</th>
					<th>Valor</th>
				  </tr>
				</thead>
				<tbody>';
				foreach($products as $linha):
				  echo '<tr>
					<td>'. $linha['product_id'] .'</td>
					<td>'. $linha['product_name'] .'</td>
					<td>R$ '. $linha['price'] .'</td>
				  </tr>';
				endforeach;
				echo '</tbody>
			  </table>'; 
			  
			?>				

			</div>
		</div>
	</div>	
</body>
</html>