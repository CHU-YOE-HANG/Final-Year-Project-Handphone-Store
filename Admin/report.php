<?php include("dataconnect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <!-- Chart.js for the sales chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body{
            font-style: italic;
        }

        .admin-panel {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }

        th, td {
            padding: 30px;
            text-align: left;
            border-bottom: 4px solid #ddd;
        }

        th {
            background-color:rgba(204, 73, 73, 0.76);
            color: white;
        }

        tr:hover {
            background-color:rgb(210, 177, 106);
        }

        .table-container {
            overflow-x: auto;
        }

        h2{
            font-size:35px;
        }
        
        footer {
        text-align: center;
        padding: 20px;
        background-color: #333;
        color: #fff;
        font-size: 20px;
        }
        .admin-panel-container
        {
            max-width: 1300px;
            margin: auto;
            padding: 20px;
        }

        form.search-sort-form {
        margin-bottom: 30px;
        text-align: center;
        }

        form.search-sort-form input,
        form.search-sort-form select
        {
            padding: 10px 14px;
            margin: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            
        }

        form.search-sort-form button
        {
            background-color:rgb(179, 155, 84);
            padding: 10px 14px;
            margin: 6px;
        }

        .clear-button {
            text-decoration: none;
            background-color: #888;
            color: white;
            padding: 10px 14px;
            margin: 6px;
            border-radius: 8px;
        
        }

        .clear-button:hover {
            background-color: #555;
        }

        .total-summary {
            font-size: 20px;
            margin-top: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }

        /* New styles for the dashboard components */
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            flex: 1;
            min-width: 250px;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .card-title {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }

        .card-value {
            font-size: 28px;
            font-weight: bold;
            color: rgba(204, 73, 73, 0.76);
        }

        .chart-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            flex: 1;
            min-width: 300px;
        }

        .channels-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            flex: 1;
            min-width: 300px;
        }

        .monthly-sales-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            flex: 1;
            min-width: 300px;
        }

        .channel-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .channel-name, .product-name {
            font-weight: bold;
        }

        .channel-value, .product-value {
            color: rgba(204, 73, 73, 0.76);
        }
        
        /* New styles for side-by-side layout */
        .charts-side-by-side {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-wrapper {
            width: 100%;
            height: 300px; /* Smaller height for the chart */
        }
        
    </style>
</head>
<body>
    <div id="menu"></div>

    <script>
        fetch('A.menu.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('menu').innerHTML = data;
            });
    </script>
    <section class="admin-panel-container">
        <h2>Report</h2>
        
        <form method="GET" class="search-sort-form">
                <input type="text" name="search" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <select name="sort">
                    <option value="">Sort by</option>
                    <option value="name_asc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_asc' ? 'selected' : '' ?>>Name: A-Z</option>
                    <option value="name_desc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_desc' ? 'selected' : '' ?>>Name: Z-A</option>
                </select>
                <button class="buttons" type="submit">Apply</button>
                <a class="button clear-button" href="report.php">Clear Filters</a>
        </form>

        <?php
        // Get data for dashboard components
        mysqli_select_db($connect, "phone_shop");
        
        // Total Orders
        $totalOrdersQuery = "SELECT COUNT(*) as total_orders FROM payment";
        $totalOrdersResult = mysqli_query($connect, $totalOrdersQuery);
        $totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total_orders'];
        
        // Total Sales
        $totalSalesQuery = "SELECT SUM(TPrice) as total_sales FROM payment";
        $totalSalesResult = mysqli_query($connect, $totalSalesQuery);
        $totalSales = mysqli_fetch_assoc($totalSalesResult)['total_sales'];
        
        // Sales by Channel (example data - you'll need to adjust based on your actual data structure)
        $channels = [
            'Online Store' => 45,
            'Mobile App' => 30,
            'In-Store' => 25
        ];
        
        // Get monthly product sales data
        $monthlySalesQuery = "SELECT Cphone as product_name, SUM(Cquantity) as total_quantity 
                             FROM payment 
                             WHERE MONTH(Cdate) = MONTH(CURRENT_DATE()) 
                             AND YEAR(Cdate) = YEAR(CURRENT_DATE())
                             GROUP BY Cphone
                             ORDER BY total_quantity DESC
                             LIMIT 5";
        $monthlySalesResult = mysqli_query($connect, $monthlySalesQuery);
        
        $monthlyProducts = [];
        while($row = mysqli_fetch_assoc($monthlySalesResult)) {
            $monthlyProducts[$row['product_name']] = $row['total_quantity'];
        }
        
        // Sales data for chart (last 7 days)
        $chartQuery = "SELECT DATE(Cdate) as date, SUM(TPrice) as daily_sales 
                      FROM payment 
                      WHERE Cdate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      GROUP BY DATE(Cdate) 
                      ORDER BY DATE(Cdate)";
        $chartResult = mysqli_query($connect, $chartQuery);
        
        $chartDates = [];
        $chartValues = [];
        
        while($row = mysqli_fetch_assoc($chartResult)) {
            $chartDates[] = date('M j', strtotime($row['date']));
            $chartValues[] = $row['daily_sales'];
        }
        ?>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-container">
            <div class="dashboard-card">
                <div class="card-title">Total Orders</div>
                <div class="card-value"><?php echo $totalOrders; ?></div>
            </div>
            
            <div class="dashboard-card">
                <div class="card-title">Total Sales</div>
                <div class="card-value">RM <?php echo number_format($totalSales, 2); ?></div>
            </div>
        </div>
        
        <!-- Side by side charts and channels -->
        <div class="charts-side-by-side">
            <!-- Sales Chart -->
            <div class="chart-container">
                <div class="card-title">Sales Last 7 Days</div>
                <div class="chart-wrapper">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            
            <!-- Channels -->
            <div class="channels-container">
                <div class="card-title">Sales by Channel</div>
                <?php foreach($channels as $channel => $percentage): ?>
                    <div class="channel-item">
                        <span class="channel-name"><?php echo $channel; ?></span>
                        <span class="channel-value"><?php echo $percentage; ?>%</span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Monthly Product Sales -->
            <div class="monthly-sales-container">
                <div class="card-title">Top Products This Month</div>
                <?php if(!empty($monthlyProducts)): ?>
                    <?php foreach($monthlyProducts as $product => $quantity): ?>
                        <div class="product-item">
                            <span class="product-name"><?php echo $product; ?></span>
                            <span class="product-value"><?php echo $quantity; ?> sold</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No sales data for this month yet.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Existing Table Section -->
        <div class="table-container">
            

            <table>
                <tr id="nophp">
                    <th>Date</th>
                    <th>Buyers Name</th>
                    <th>Order item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>

                <?php
                $search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                $query = "SELECT * FROM payment";
                if (!empty($search)) {
                    $query .= " WHERE UName LIKE '%$search%'";
                }
                if ($sort == 'name_asc') {
                    $query .= " ORDER BY UName ASC";
                } elseif ($sort == 'name_desc') {
                    $query .= " ORDER BY UName DESC";
                }

                $result = mysqli_query($connect, $query);
                $count = mysqli_num_rows($result);
                $totalRevenue = 0;
                
                while($row = mysqli_fetch_assoc($result)){
                    $totalRevenue += $row['TPrice'];
                ?>
                    <tr>
                        <td><?php echo $row['Cdate']?></td>
                        <td><?php echo $row['UName']?></td>
                        <td><?php echo $row['Cphone']?></td>
                        <td><?php echo $row['Cquantity']?></td>
                        <td><?php echo $row['TPrice']?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
            
            <div class="total-summary">
                <p>Number of customers: <?php echo $count; ?></p>
                <p>Total Revenue: RM <?php echo number_format($totalRevenue, 2); ?></p>
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
    
     <script>
        // Sales Chart - Changed to Doughnut
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($chartDates); ?>,
                datasets: [{
                    data: <?php echo json_encode($chartValues); ?>,
                    backgroundColor: [
                        'rgba(204, 73, 73, 0.8)',
                        'rgba(179, 155, 84, 0.8)',
                        'rgba(210, 177, 106, 0.8)',
                        'rgba(204, 73, 73, 0.6)',
                        'rgba(179, 155, 84, 0.6)',
                        'rgba(210, 177, 106, 0.6)',
                        'rgba(204, 73, 73, 0.4)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': RM ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>