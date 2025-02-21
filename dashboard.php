

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - student System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .dashboard {
            margin-left: 250px; /* Same as sidebar width */
            padding: 20px;
            width: calc(100% - 250px);
        }

        .dashboard h2 {
            color: #1f2937;
            margin-bottom: 20px;
        }

        .widgets {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .widget {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            flex: 1 1 calc(33.333% - 40px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .widget:hover {
            transform: translateY(-5px);
        }

        .widget h3 {
            margin-top: 0;
            color: #3b82f6;
        }

        .widget p {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <!-- Include the sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <div class="dashboard">
        <h2>Welcome, </h2>
        
        <!-- Widgets Section -->
        <div class="widgets">
            <div class="widget">
                <h3>Total Stock</h3>
                <p>1,234 Items</p>
            </div>
            <div class="widget">
                <h3>Low Stock Alerts</h3>
                <p>12 Items</p>
            </div>
            <div class="widget">
                <h3>Recent Activity</h3>
                <p>5 new Entries</p>
            </div>
        </div>
    </div>

    <!-- Include Lucide Icons Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
