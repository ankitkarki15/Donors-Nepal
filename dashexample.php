<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #2d2d2d;
            color: white;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: gray;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #3b3b3b;
            color: white;
        }
        .dashboard-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar p-3">
            <div class="text-center mb-4">
                <h3>E-Shop Admin</h3>
            </div>
            <nav>
                <a href="#" class="d-block py-2">Dashboard</a>
                <a href="#" class="d-block py-2">Orders</a>
                <a href="#" class="d-block py-2">Products</a>
                <a href="#" class="d-block py-2">Customers</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <!-- Header -->
            <header class="d-flex justify-content-between align-items-center mb-4">
                <input type="search" class="form-control w-50" placeholder="Search...">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/placeholder.svg" alt="Avatar" class="rounded-circle" style="width: 30px; height: 30px;">
                        <span class="ms-2">John Doe</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
            </header>

            <!-- Dashboard Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <h5>Total Revenue</h5>
                        <h3>$45,231.89</h3>
                        <p>+20.1% from last month</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <h5>New Customers</h5>
                        <h3>+1,234</h3>
                        <p>+15.2% from last month</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <h5>Total Orders</h5>
                        <h3>2,345</h3>
                        <p>+4.5% from last month</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <h5>Pending Orders</h5>
                        <h3>12</h3>
                        <p>-2 from yesterday</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#3210</td>
                                    <td>John Brown</td>
                                    <td>Laptop Pro</td>
                                    <td>2023-04-04</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td class="text-end">$1,200.00</td>
                                </tr>
                                <tr>
                                    <td>#3209</td>
                                    <td>Mary Davis</td>
                                    <td>Smartphone X</td>
                                    <td>2023-04-03</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td class="text-end">$999.99</td>
                                </tr>
                                <tr>
                                    <td>#3208</td>
                                    <td>Robert Johnson</td>
                                    <td>Wireless Earbuds</td>
                                    <td>2023-04-03</td>
                                    <td><span class="badge bg-primary">Shipped</span></td>
                                    <td class="text-end">$149.99</td>
                                </tr>
                                <tr>
                                    <td>#3207</td>
                                    <td>Emily Wilson</td>
                                    <td>Smart Watch</td>
                                    <td>2023-04-02</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td class="text-end">$299.99</td>
                                </tr>
                                <tr>
                                    <td>#3206</td>
                                    <td>Michael Lee</td>
                                    <td>Tablet Pro</td>
                                    <td>2023-04-02</td>
                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                    <td class="text-end">$599.99</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
