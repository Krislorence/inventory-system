<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: register.php");
    exit();
}
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Inventory System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    
    <style>
       body{
            background-color: black;
        }
        .sidebar .nav-menu a{
            color: black;
        }
        .app-container .sidebar{
            background-color: transparent;
        }

        .nav-link:hover, .nav-link.active {
            color: black;
            transform: scale(1.0) translateY(-3px);
            background-color: white;
            box-shadow: 0 0 25px rgba(212, 212, 214, 0.64);
        }

        .nav-link:hover{
            color: black;
            transform: scale(1.0) translateY(-3px);
            background-color: white;
            box-shadow: 0 0 25px rgba(212, 212, 214, 0.64);
            }
        .about-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .about-card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            border: 1px solid #1515b7;
            box-shadow: 1 4px 10px rgba(10, 22, 191, 0.02);
            margin-bottom: 24px;
        }

        .about-card h2 {
            font-size: 18px;
            color: black;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            
        }

        .about-card p {
            font-size: 14px;
            color: #0c0e10;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        
        .feature-list {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 16px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #07090b;
            background: transparent;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #2b2e35;
        }
        .feature-item:hover{
            color: black;
            transform: scale(1.0) translateY(-5px);
            background: lightyellow;
            box-shadow: 0 0 25px rgba(201, 228, 0, 0.64);
        }

        .feature-item i {
            font-size: 16px;
        }

        .tech-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .tech-badge {
            background: transparent;
            color: black;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .tech-badge:hover{
            color: black;
            transform: scale(1.0) translateY(-5px);
            background: lightyellow;
            box-shadow: 0 0 25px rgba(201, 228, 0, 0.64);
        }
        .team-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-top: 12px;
        }

        .team-member {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 10px;
            transition: background 0.2s;
        }

        .team-member:hover {
           color: black;
            transform: scale(1.0) translateY(-5px);
            background: lightyellow;
            box-shadow: 0 0 25px rgba(201, 228, 0, 0.64);
        }

        .member-info h4 {
            font-size: 14px;
            color: #0f172a;
        }

        .member-info p {
            font-size: 12px;
            color: black;
            margin: 0;
        }
        .btn-new-item{
            background-color: rgba(191, 225, 20, 0.749);

        }

        .btn-new-item:hover{
            color: black;
            transform: scale(1.1) translateY(-5px);
            background-color: white;
            box-shadow: 0 0 25px rgba(247, 247, 246, 0.64);
        }

        .logout-link{
            background-color: rgba(226, 10, 10, 0.64);
            color: black;
        }
        .logout-link:hover{
            color: black;
            transform: scale(1.1) translateY(-5px);
            background-color: rgba(228, 0, 11, 0.64);
            box-shadow: 0 0 25px rgba(228, 0, 0, 0.64);
        }
    </style>
</head>
<body>

    <div class="app-container">
        <aside class="sidebar">
            <div class="haha">
                <a href="additem.php" class="btn-new-item">
                    <i class="fa-solid fa-plus"></i> New Item
                </a>

                <ul class="nav-menu">
                    <li>
                        <a href="index.php" class="nav-link">
                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="view.php" class="nav-link">
                            <i class="fa-solid fa-box-archive"></i>
                            Inventory Records
                        </a>
                    </li>
                    <li>
                        <a href="viewreports.php" class="nav-link">
                            <i class="fa-solid fa-chart-line"></i>
                            Reports
                        </a>
                    </li>
                    
                    <li>
                        <a href="about.php" class="nav-link active">
                            <i class="fa-solid fa-circle-info"></i>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="nav-link">
                            <i class="fa-solid fa-gear"></i>
                            Account Settings
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <a href="logout.php" class="logout-link" onclick="return confirm('sure kana dyan yah?')">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Log out
                </a>
            </div>
        </aside>
        <main class="main-content">
            
            <header class="top-bar">
                <div class="user-greeting">
                    <h1>About our Inventory System</h1>
                    <p style="color: black">Learn more about our system, ANO J??</p>
                </div>
            </header>

            <div class="about-grid">
                <div>
                    <div class="about-card">
                        <h2><i class="fa-solid fa-circle" style="color: black;"></i> Overview</h2>
                        <p>
                             <strong>This Inventory System</strong> is one of a web-based solution designed to be fast reliable, and easy to use for tracking items hehe
                        </p>
                        <p>
                            The purpose of this system is to help businesses and administrators keep track of their product/item stock real-time, avoid sudden stockouts, and generate clear reports for overall operations.
                        </p>
                    </div>
                    <div class="about-card">
                        <h2><i class="fa-solid fa-circle" style="color: black;" ></i> Features</h2>
                        <div class="feature-list">
                            <div class="feature-item">
                                 Real-time Dashboard
                            </div>
                            <div class="feature-item">
                                 Low Stock Warning
                            </div>
                            <div class="feature-item">
                                 Full CRUD Operations
                            </div>
                            <div class="feature-item">
                                 Automated Analytics
                            </div>
                        </div>
                    </div>
                    <div class="about-card">
                        <h2><i class="fa-solid fa-circle" style="color:  black;" ></i>Tech Stack Used</h2>
                        <div class="tech-badges">
                            <span class="tech-badge"> PHP </span>
                            <span class="tech-badge"> MySQL</span>
                            <span class="tech-badge"> HTML</span>
                            <span class="tech-badge"> CSS</span>
                            <span class="tech-badge"> JavaScript</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="about-card">
                        <h2><i class="fa-solid fa-circle" style="color: black;" ></i> Group Members</h2>
                        <ul class="team-list">
                            <li class="team-member">
                                <div class="member-info">
                                    <h4>Kris Lorence L. Chan</h4>
                                    <p>LoloLoko</p>
                                </div>
                            </li>
                            <li class="team-member">
                                <div class="member-info">
                                    <h4>Cj Maquiñana</h4>
                                    <p>LoloLoko</p>
                                </div>
                            </li>
                            <li class="team-member">
                                <div class="member-info">
                                    <h4>Jm Recuenco</h4>
                                    <p>LoloLoko</p>
                                </div>
                            </li>
                            <li class="team-member">
                                <div class="member-info">
                                    <h4>Efren Añonuevo</h4>
                                    <p>LoloLoko</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="about-card">
                        <h2><i class="fa-solid fa-circle" style="color: black;" ></i> Academic Info</h2>
                        <p style="font-size: 13px; margin-bottom: 6px;"><strong>Course:</strong> BSIT 3E</p>
                        <p style="font-size: 13px; margin-bottom: 6px;"><strong>Subject:</strong> Integration Programming and Technologies 2</p>
                        <p style="font-size: 13px; margin-bottom: 0;"><strong>School:</strong> CCDI LEGAZPI</p>
                    </div>
                </div>

            </div>
            <footer class="app-footer">
                <p>&copy; 2026 CCDI LEGAZPI BSIT-3E Midterm | Designed by Kris Lorence L. Chan, Cj Maquiñana, Efren Añunuevo, John Matthew Recuenco </p>
                </footer>

        </main>

    </div>

</body>
</html>