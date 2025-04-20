
<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
  }

// Konfigurasi Database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todolist";

// Buat Koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Buat Tabel Database Otomatis dengan Script PHP
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    status_task ENUM('Biasa', 'Cukup', 'Penting') DEFAULT 'Cukup',
    status_completed ENUM('Selesai', 'Belum Selesai') DEFAULT 'Belum Selesai',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    task_date DATE
)";
$conn->query($sql);

// Penambahan Data Baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $task_name = $conn->real_escape_string($_POST['task_name']);
    $status_task = $conn->real_escape_string($_POST['status_task']);
    $status_completed = $conn->real_escape_string($_POST['status_completed']);
    $task_date = $conn->real_escape_string($_POST['task_date']);

    if (!empty($task_name) && !empty($status_task) && !empty($task_date)) {
        $stmt = $conn->prepare("INSERT INTO tasks (task_name, status_task, status_completed, task_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $task_name, $status_task, $status_completed, $task_date);
        $stmt->execute();
        $stmt->close();
    }
}

// Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_task'])) {
    $id = (int)$_POST['task_id'];
    $task_name = $conn->real_escape_string($_POST['task_name']);
    $status_task = $conn->real_escape_string($_POST['status_task']);
    $status_completed = $conn->real_escape_string($_POST['status_completed']);
    $task_date = $conn->real_escape_string($_POST['task_date']);

    if (!empty($task_name) && !empty($status_task) && !empty($task_date)) {
        $stmt = $conn->prepare("UPDATE tasks SET task_name = ?, status_task = ?, status_completed = ?, task_date = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $task_name, $status_task, $status_completed, $task_date, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle deleting a task
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}







// Fetch all tasks
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spike To Do List</title>
    <style>
        /* Same styling as before with minor updates for the new 'task_date' */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family:  "snell";
            background: linear-gradient(135deg, #806154, #ECD8C1);
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .form-container {
            display: flex;
            gap: 10px;
            border-top: 20px;
            justify-content: center;
        }

        input[type="text"], select, input[type="date"] {
            padding: 12px;
            font-size: 1rem;
            border-radius: 8px;
            border: none;
            width: 220px;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        input[type="text"]:focus, select:focus, input[type="date"]:focus {
            border: 2px solid #FF6F61;
            box-shadow: 0 0 10px rgba(255, 111, 97, 0.5);
        }

        button {
            background-color: #806154;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 8px;
    
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #D46A6A;
        }

        .task-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 90%;
            max-width: 900px;
            margin-top: 30px;
        }

        .task-item {
            background-color: #fff;
            color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .task-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .task-item input[type="text"], .task-item select, .task-item input[type="date"] {
            width: calc(100% - 20px);
            margin-bottom: 10px;
        }

        .task-item button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border-radius: 8px;
            font-size: 1rem;
            margin-top: 10px;
        }

        .task-item .delete {
            background-color: #FF4C4C;
            margin-top: 5px;
            width: 100%;
        }

        .task-item button:hover {
            background-color: #45a049;
        }

        .task-item .delete:hover {
            background-color: #e33b3b;
        }

        .task-item .task-date {
            font-size: 0.9rem;
            color: #806154;
            margin-top: 10px;
        }
        

    </style>
</head>
<body>
   <nav class="navbar navbar-dark bg-dark"></nav> 



    <h1>Spike To Do List</h1>

    <!-- Form untuk menambah tugas -->
    <div class="form-container">
        <form method="POST" action="">
            <input type="text" name="task_name" placeholder="Tambahkan teks..." required>
            <select name="status_task" required>
                <option value="Biasa">Biasa</option>
                <option value="Cukup">Cukup Penting</option>
                <option value="Penting">Penting Sekali</option>
            </select>
            <select name="status_completed" required>
                <option value="Belum Selesai">Belum Selesai</option>
                <option value="Selesai">Selesai</option>
            </select>
            <input type="date" name="task_date" required>
            <button type="submit" name="add_task">Tambah List</button>
        </form>
         <button type="submit" name="logout" ><i class="fad fa-sign-out-alt"></i><a href="logout.php">logout</a></button>
       
    </div>

    <!-- Menampilkan daftar tugas -->
    <div class="task-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="task-item" data-status="<?= $row['status_completed'] ?>">
                <form method="POST" action="">
                    <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
                    <input type="text" name="task_name" value="<?= htmlspecialchars($row['task_name']) ?>" required>
                    <select name="status_task" required>
                        <option value="Biasa" <?= $row['status_task'] == 'Biasa' ? 'selected' : '' ?>>Biasa</option>
                        <option value="Cukup" <?= $row['status_task'] == 'Cukup' ? 'selected' : '' ?>>Cukup</option>
                        <option value="Penting" <?= $row['status_task'] == 'Penting' ? 'selected' : '' ?>>Penting</option>
                    </select>
                    <select name="status_completed" required>
                        <option value="Belum Selesai" <?= $row['status_completed'] == 'Belum Selesai' ? 'selected' : '' ?>>Belum Selesai</option>
                        <option value="Selesai" <?= $row['status_completed'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                    <input type="date" name="task_date" value="<?= $row['task_date'] ?>" required>
                    <button type="submit" name="edit_task">Edit</button>
                </form>
                <form method="GET" action="" onsubmit="return confirm('Apakah yakin menghapus list?');">
                    <input type="hidden" name="delete" value="<?= $row['id'] ?>">
                    <button type="submit" class="delete">Hapus</button>
                    <a class="btn btn-dark btn-lg btn-block"href="logout.php"> keluar</a>
                </form>
                <div class="task-date">Due Date: <?= date("F j, Y", strtotime($row['task_date'])) ?></div>
            </div>
        <?php endwhile; ?>
    </div>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>