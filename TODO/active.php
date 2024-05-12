<?php

// Database connection settings
require 'connection.php';


// Connect to the database
try {
    

    $sql = "SELECT *
            FROM tasks 
            WHERE is_checked = 0";

    $stmt = $pdo->query($sql);

    // Fetch all tasks
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tasks as $task) {
?>
  <li class="list-group-item d-flex align-items-center border-0 mb-2 rounded"
                    style="background-color: #f4f6f7;">
                    <input class="form-check-input me-2" type="checkbox"/>
                    <?php echo $task['task_description'];?>"
                      <i class="fas fa-times text-danger ms-auto remove-task"></i>
                    <input type="hidden" name="taskId" class="task-id" value="<?php echo $task['id']; ?>">
                  </li>
<?php
    }
} catch(PDOException $e) {
    // Display error message if something goes wrong
    echo "Error: " . $e->getMessage();
}
?>
