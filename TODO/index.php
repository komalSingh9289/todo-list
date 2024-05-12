<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TO-DO LIST</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body{
  background-color: #c29fff;
}

  </style>
</head>
<body>

    <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">

        <div class="card">
          <div class="card-body p-5">
            <!-- today's date---->

            <div class="container mb-4">
              <i class="fa-solid fa-calendar-days"><span class="p-2"><?php echo date('d F, Y'); ?></span></i>
            </div>
          
            <form class=" justify-content-center align-items-center mb-4" id="taskform" method="post">
              <div class="row">
                    <div class="col-md-10">
                      <input type="text" class="form-control" id="todayTask" placeholder="Today's  Task..." >
                    </div>
                    <div class="col-md-2">
                      <input type="submit" value="Add" class="form-control btn btn-secondary">
                    </div>
                  </div>
             </form>

            <!-- Tabs navs -->
            <ul class="nav nav-tabs mb-4 pb-2" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab-1" data-mdb-tab-init href="all.php" role="tab"
                  aria-controls="ex1-tabs-1" aria-selected="true">All</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="ex1-tab-2" data-mdb-tab-init href="active.php" role="tab"
                  aria-controls="ex1-tabs-2" aria-selected="false">Active</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="ex1-tab-3" data-mdb-tab-init href="completed.php" role="tab"
                  aria-controls="ex1-tabs-3">Completed</a>
              </li>
            </ul>

            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content overflow-auto" style="max-height: 300px;"> 
              <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel"
                aria-labelledby="ex1-tab-1">
                <ul class="list-group mb-0" id="todo_list">

                      <?php include 'all.php'; ?>
                </ul>
                </div>        
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quoteModalLabel">Quote of the Day</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="quoteContent">
        Loading a meaningful quote for you...
      </div>
    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {



  //update tab

    $('a[data-mdb-tab-init]').click(function(e) {
        e.preventDefault(); // Prevent default link behavior

        // Get the href attribute of the clicked tab link
        var tabContentUrl = $(this).attr('href');

        // Load content of the selected tab using AJAX
        $.ajax({
            type: 'GET',
            url: tabContentUrl, // URL of the tab content
            success: function(response) {
                // Replace the content of #todo_list with the loaded content
                $('#todo_list').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error loading tab content:', error);
            }
        });
    });

    // Form submission event handler
    $('#taskform').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Get the task input value
        var task = $('#todayTask').val();

        // AJAX POST request to send form data to server
        $.ajax({
            type: 'POST',
            url: 'insert_task.php', // Replace with the URL to your server-side script
            data: { task: task }, // Send task data to server
            success: function(response) {
                // Insert the returned data into the content div
                $('#todo_list').append(response);
                // Clear the task input field
                $('#todayTask').val('');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $(document).on('click', '.remove-task', function() {
        var taskId = $(this).data('task-id'); // Get the task ID from data attribute

        console.log(taskId);

        // AJAX POST request to send task ID to server for deletion
        $.ajax({
            type: 'POST',
            url: 'delete_task.php',
            data: { taskId: taskId },
            dataType: 'json',
            success: function(response) {
                // Check if deletion was successful
                if (response.success) {
                    // Remove the task from the list on success
                    $('[data-task-id="' + taskId + '"]').closest('li').remove();
                } else {
                    // Handle deletion failure
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });


      $(document).on('change', 'input[type="checkbox"]', function() {
        // Get the task ID and checkbox state
        var taskId = $(this).siblings('.task-id').val();
        var isChecked = this.checked;

        // Send an AJAX request to update the task status
        $.ajax({
            type: 'POST',
            url: 'update_task.php',
            data: { 
                taskId: taskId,
                isChecked: isChecked
            },
            dataType: 'json', // Expect JSON response
            success: function(response) {
                // Handle success response if needed
                alert('Task completed successfully.');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error updating task status:', error);
            }
        });
    });

  function fetchQuote() {
    $.ajax({
      url: 'https://api.quotable.io/random',
      success: function(data) {
        var quote = '"' + data.content + '" - ' + data.author;
        showQuote(quote);
      },
      error: function(xhr, status, error) {
        console.error('Error fetching quote:', error);
      }
    });
  }

  // Function to show the quote in the modal
  function showQuote(quote) {
    // Update the modal content with the fetched quote
    $('#quoteContent').html(quote);
    // Show the modal
    $('#quoteModal').modal('show');
  }

  // Fetch a new quote and show it in the modal
  fetchQuote();



});

</script>


</body>
</html>

