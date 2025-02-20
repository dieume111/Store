<!DOCTYPE html>
<html>
<head>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
	<style>
		.sidebar {
			width: 250px;
			height: 100vh;
			background: #1f2937;
			color: white;
			position: fixed;
			padding-top: 20px;
			font-family: Arial, sans-serif;
		}

		.sidebar h2 {
			text-align: center;
			margin-bottom: 30px;
			font-size: 24px;
			color: #f3f4f6;
		}

		.sidebar a {
			display: flex;
			align-items: center;
			padding: 12px 20px;
			color: #d1d5db;
			text-decoration: none;
			transition: all 0.3s ease;
			margin-bottom: 5px;
		}

		.sidebar a:hover {
			background: #3b82f6;
			color: white;
			transform: translateX(5px);
		}

		.sidebar a i {
			margin-right: 12px;
			width: 20px;
			height: 20px;
		}

		.sidebar .logout {
			margin-top: 50px;
		}
	</style>
</head>
<body>
	<div class="sidebar">
		<h2>Stock System</h2>
		<a href="dashboard.php">
			<i data-lucide="layout-dashboard"></i>
			Dashboard
		</a>
		
		<a href="products.php">
			<i data-lucide="file-bar-chart"></i>
			add product
		</a>
		<a href="productin.php">
			<i data-lucide="plus-circle"></i>
			Add Stock
		</a>
		<a href="productout.php">
			<i data-lucide="list-ordered"></i>
			remove stock
		</a>
		<a href="report.php">
			<i data-lucide="file-bar-chart"></i>
			Reports
		</a>
		<a href="logout.php" class="logout">
			<i data-lucide="log-out"></i>
			Logout
		</a>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.js"></script>
	<script>
		lucide.createIcons();
	</script>
</body>
</html>