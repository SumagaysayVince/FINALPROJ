<?php
session_start();
include 'db.php'; // Include your existing database connection

// Check admin session
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all students
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY full_name DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Student Reports</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        :root{
            --accent:#6fa8ff;
            --accent-dark:#4d8dff;
            --muted:#7b8fae;
            --success:#27ae60;
            --card-bg: rgba(255,255,255,0.94);
        }

        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family:"Inter",system-ui,Arial,sans-serif;
            min-height:100vh;
            background: url('it3.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            color:#223;
        }

        /* overlay for contrast */
        body::before{
            content:'';
            position:fixed;
            inset:0;
            background: rgba(0,0,0,0.45);
            z-index:0;
        }

        /* HEADER */
header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    z-index: 5;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand .logo {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.05);
}

.brand .logo img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* <-- changed from cover to contain */
    display: block;
}


.brand h1 {
    font-size: 20px;
    color: #fff;
    font-weight: 700;
    margin: 0;
    letter-spacing: 0.5px;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-actions .welcome {
    color: #fff;
    font-weight: 600;
}

.admin-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid rgba(255,255,255,0.3);
}

.admin-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.top-logout {
    padding: 8px 16px;
    background: linear-gradient(135deg, #6fa8ff, #4d8dff);
    color: #fff;
    font-weight: 700;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.2s ease;
}

.top-logout:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

        /* page container */
        .page {
            position:relative;
            z-index:2;
            max-width:1200px;
            margin:110px auto 40px; /* allow for header */
            padding:24px;
        }

        .card {
            background: var(--card-bg);
            border-radius:14px;
            padding:20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }

        .card-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:14px;
        }

        .card-header h2{
            font-size:20px;
            color:#083a5e;
            margin:0;
        }

        .controls {
            display:flex;
            gap:10px;
            align-items:center;
        }

        .search {
            display:flex;
            align-items:center;
            gap:8px;
            background: #f6fbff;
            padding:8px 10px;
            border-radius:10px;
            border:1px solid rgba(10,50,100,0.04);
        }
        .search input{
            border:0; outline:0; background:transparent; width:220px; font-size:14px; color:#083a5e;
        }
        .search input::placeholder{ color:#8aa6c7; }

        .table-wrap { overflow:auto; border-radius:10px; }
        table{
            width:100%;
            border-collapse:collapse;
            min-width:760px;
        }

        th, td{
            padding:12px 14px;
            border-bottom:1px solid rgba(0,0,0,0.06);
            text-align:left;
            vertical-align:middle;
            font-size:14px;
        }

        th{
            background: linear-gradient(90deg,var(--accent), #9fd7ff);
            color:#083a5e;
            font-weight:700;
            position:sticky;
            top:0;
        }

        tbody tr{ background: #fff; }
        tbody tr:nth-child(even){ background: #f7fbff; }
        tbody tr:hover{ background: #f0f8ff; }

        .col-center { text-align:center; }
        .actions a{
            text-decoration:none;
            padding:8px 10px;
            border-radius:8px;
            color:#fff;
            font-weight:700;
            display:inline-block;
            margin-right:6px;
            font-size:13px;
        }
        .actions .edit { background:#f39c12; }
        .actions .history { background: #27ae60; }
        .actions .edit:hover { background:#e67e22; }
        .actions .history:hover { background:#2ecc71; }

        .meta { color:var(--muted); font-size:13px; }

        .logout {
            margin-top:18px;
            display:inline-block;
            padding:10px 18px;
            background: linear-gradient(135deg,var(--accent),var(--accent-dark));
            color:#083a5e;
            border-radius:10px;
            font-weight:700;
            text-decoration:none;
            box-shadow:0 8px 22px rgba(111,168,255,0.12);
        }

        /* responsive */
        @media (max-width:900px){
            .page{ margin:100px 16px 30px; }
            .search input{ width:120px; }
            table{ font-size:13px; min-width:600px; }
        }
        @media (max-width:600px){
            .brand h1{ font-size:16px; }
            .search input{ width:90px; }
            .actions a{ padding:6px 8px; font-size:12px; }
        }
    </style>
</head>
<body>

<header>
    <div class="brand">
        <span class="logo"><img src="logo.png" alt="Logo"></span>
        <h1>ISUFST BrainWave</h1>
    </div>

    <div class="header-actions">
        <div class="welcome">
            <span>Welcome, Admin</span>
        </div>
        <div class="admin-avatar">
            <img src="avatar.png" alt="Admin Avatar">
        </div>
        <a class="top-logout" href="logout.php">Logout</a>
    </div>
</header>


<main class="page">
    <div class="card">
        <div class="card-header">
            <h2>Student Reports</h2>

            <div class="controls">
                <div class="search" title="Search by name, username or course">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#083a5e" xmlns="http://www.w3.org/2000/svg"><path d="M21 21l-4.35-4.35"></path><circle cx="11" cy="11" r="6"></circle></svg>
                    <input id="searchBox" type="search" placeholder="Search students...">
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table id="studentsTable" aria-describedby="Student Reports">
                <thead>
                    <tr>
                        <th style="width:60px">ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Course</th>
                        <th>Created At</th>
                        <th class="col-center" style="width:210px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($student = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="col-center"><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['username']); ?></td>
                        <td><?php echo htmlspecialchars($student['course']); ?></td>
                        <td class="meta"><?php echo htmlspecialchars($student['created_at']); ?></td>
                        <td class="col-center actions">
                            <a class="edit" href="edit_student.php?id=<?php echo $student['student_id']; ?>">Edit</a>
                            <a class="history" href="admin_view_history.php?student_id=<?php echo $student['student_id']; ?>">View History</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div style="text-align:center;">
            <a class="logout" href="logout.php">Sign out</a>
        </div>
    </div>
</main>

<script>
    // Simple client-side search/filter (by name, username, course)
    (function(){
        const searchBox = document.getElementById('searchBox');
        const tbody = document.querySelector('#studentsTable tbody');

        searchBox.addEventListener('input', function(){
            const q = this.value.trim().toLowerCase();
            if(!q){
                Array.from(tbody.rows).forEach(r => r.style.display = '');
                return;
            }
            Array.from(tbody.rows).forEach(r => {
                const name = r.cells[1].textContent.toLowerCase();
                const username = r.cells[2].textContent.toLowerCase();
                const course = r.cells[3].textContent.toLowerCase();
                if(name.includes(q) || username.includes(q) || course.includes(q)){
                    r.style.display = '';
                } else {
                    r.style.display = 'none';
                }
            });
        });
    })();
</script>

</body>
</html>
