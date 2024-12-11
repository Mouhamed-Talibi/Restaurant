<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f4f4f9;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            width: 100%;
            background-color: #2c3e50;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar h1 {
            font-size: 20px;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
        }

        .navbar .user-info img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Sidebar */
        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #1abc9c;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .sidebar .menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar .menu li {
            padding: 15px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .sidebar .menu li i {
            margin-right: 10px;
        }

        .sidebar .menu li:hover {
            background-color: #16a085;
        }

        .sidebar .menu li.active {
            background-color: #0e7764;
        }

        .sidebar .footer {
            padding: 15px 20px;
            text-align: center;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            color: #7f8c8d;
        }

        .card .value {
            font-size: 24px;
            font-weight: bold;
            color: #1abc9c;
            margin-top: 10px;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar .menu li {
                justify-content: center;
            }

            .sidebar .menu li span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Restaurant Admin</h1>
        <div class="user-info">
            <img src="https://via.placeholder.com/35" alt="Admin">
            <span>Admin</span>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <ul class="menu">
                <li class="active"><i class="fas fa-home"></i><span>Dashboard</span></li>
                <li><i class="fas fa-utensils"></i><span>Orders</span></li>
                <li><i class="fas fa-concierge-bell"></i><span>Menus</span></li>
                <li><i class="fas fa-users"></i><span>Staff</span></li>
                <li><i class="fas fa-cogs"></i><span>Settings</span></li>
            </ul>
            <div class="footer">
                <p>&copy; 2024 Restaurant</p>
            </div>
        </div>

        <div class="main">
            <div class="header">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>Total Orders</h3>
                    <div class="value">120</div>
                    <p>Orders today</p>
                </div>

                <div class="card">
                    <h3>Total Revenue</h3>
                    <div class="value">$15,000</div>
                    <p>Revenue this month</p>
                </div>

                <div class="card">
                    <h3>Active Staff</h3>
                    <div class="value">8</div>
                    <p>Currently on shift</p>
                </div>

                <div class="card">
                    <h3>New Customers</h3>
                    <div class="value">45</div>
                    <p>Signed up this week</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
