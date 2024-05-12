<?php

require 'connection.php';

if(isset($_POST['task'])) {
    // Retrieve the task description
    $task = $_POST['task'];

try {
    

    // Prepare SQL statement to insert task
    $sql = "INSERT INTO tasks (task_description) VALUES (:task)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':task', $task);

    // Execute the statement
    $stmt->execute();

    $insertedId = $pdo->lastInsertId();

    $sql = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $insertedId);
    $stmt->execute();
    $taskData = $stmt->fetch(PDO::FETCH_ASSOC);

?>
	<li class="list-group-item d-flex align-items-center border-0 mb-2 rounded"
                    style="background-color: #f4f6f7;">
                    <input class="form-check-input me-2" type="checkbox"/>
                    <?php echo $taskData['task_description'];?>

                     <i class="fas fa-times text-danger ms-auto remove-task"  data-task-id="<?php echo $insertedId; ?>" ></i>

                     <input type="hidden" name="taskId" class="task-id" value="<?php echo $insertedId; ?>">
                  </li>
<?php
    
} catch(PDOException $e) {
    // Display error message if something goes wrong
    echo "Error: " . $e->getMessage();
}
}

?>
