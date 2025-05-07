$(document).ready(function () {
  // funkcija to render
  // function to fetch
  function loadTasksToOverview() {
    if (window.location.hash !== "#overview") {
      return;
    }

    $.ajax({
      url: "../../../backend/dao/tasks/getTask.php", // path to getter
      method: "GET",
      dataType: "json",
      success: function (tasks) {
        var $taskHolder = $("#task-holder");
        if (!$taskHolder.length) {
          console.error("No task-holder container found!");
          return;
        }
        $taskHolder.empty();

        if (!tasks || tasks.length === 0) {
          $taskHolder.html("<p>No tasks found.</p>");
          return;
        }

        $.each(tasks, function (index, task) {
          // Build the task HTML, using the task.image_type value for the image source.
          var taskHtml = `
            <div class="col-md-2" id="task-${task.id}" style="width: 100%;">
              <div class="card">
                <img src="../assets/images/tasks/${task.image_type}" class="card-img-top" alt="${task.title}" style="width: 100%; height: 200px; object-fit: cover;" />
                <div class="card-body">
                  <h5 class="card-title">${task.title}</h5>
                  <p class="card-text">${task.description}</p>
                  <button class="btn btn-light edit-task" data-id="${task.id}" data-title="${task.title}" data-description="${task.description}">Edit</button>
                  <button class="btn btn-danger delete-task" data-id="${task.id}">Delete</button>
                </div>
              </div>
            </div>
          `;
          $taskHolder.append(taskHtml);
        });

        // deletion listener
        $taskHolder.on("click", ".delete-task", function () {
          var taskId = $(this).data("id");

          if (!confirm("Are you sure you want to delete this task?")) {
            return;
          }

          $.ajax({
            url: "http://localhost:8000/backend/dao/tasks/deleteTask.php",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({ id: taskId }),
            success: function (response) {
              console.log("Task deleted:", response);
              $("#task-" + taskId).remove();
            },
            error: function (xhr, status, error) {
              console.error("Error deleting task:", error);
            },
          });
        });

        // Edit task event listener
        $taskHolder.on("click", ".edit-task", function () {
          var taskId = $(this).data("id");
          var taskTitle = $(this).data("title");
          var taskDescription = $(this).data("description");

          $("#editTaskId").val(taskId);
          $("#editTaskTitle").val(taskTitle);
          $("#editTaskDescription").val(taskDescription);
          $("#editTaskModal").modal("show");
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching tasks:", error);
        $("#task-holder").html("<p>Error loading tasks.</p>");
      },
    });
  }

  // Event listener for the edit modal form submission
  $(document).on("submit", "#editTaskForm", function (event) {
    event.preventDefault();

    var taskId = $("#editTaskId").val();
    var updatedTitle = $("#editTaskTitle").val();
    var updatedDescription = $("#editTaskDescription").val();

    $.ajax({
      url: "http://localhost:8000/backend/dao/tasks/updateTask.php",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({
        id: taskId,
        title: updatedTitle,
        description: updatedDescription,
      }),
      success: function (response) {
        console.log("Task updated:", response);

        loadTasksToOverview();
        $("#editTaskModal").modal("hide");
      },
      error: function (xhr, status, error) {
        console.error("Error updating task:", error);
      },
    });
  });

  function onPageLoaded() {
    // Determine which page is loaded.
    var page = location.hash.substring(1) || "dashboard";
    console.log("Page loaded: " + page);
    // Page specific since im gonna have more pages
    switch (page) {
      case "overview":
        loadTasksToOverview();
        break;
      case "alerts":
        // You can add alerts-loading code here.
        console.log("Load alerts component here.");
        break;
      // Add other cases for additional pages as needed.
      default:
        console.log("No specific component to load for this page.");
    }
  }
  // Expose the onPageLoaded function so it is available globally.
  window.onPageLoaded = onPageLoaded;

  // Function to load page content via AJAX.
  function loadPage(page) {
    $.ajax({
      url: `../pages/${page}.html`,
      method: "GET",
      dataType: "html",
      success: function (data) {
        // For login/register pages, load into a separate container.
        if (page === "login" || page === "register") {
          $(".loginregisterScreen").html(data);
        } else {
          $(".loginregisterScreen").empty();
          $("#container-fluid").html(data);

          $.getScript(`../assets/js/pageLoaded.js?ts=${new Date().getTime()}`)
            .done(function (script, textStatus) {
              console.log("pageLoaded.js loaded: " + textStatus);

              onPageLoaded();
            })
            .fail(function (jqxhr, settings, exception) {
              console.error("Failed to load pageLoaded.js", exception);
            });
        }
      },
      error: function () {
        if (page === "login" || page === "register") {
          $(".loginregisterScreen").html("<h2>Page Not Found</h2>");
        } else {
          $("#container-fluid").html("<h2>Page Not Found</h2>");
        }
      },
    });
  }

  // Update the content based on the hash in the URL.
  function updateContent() {
    var page = location.hash.substring(1) || "dashboard";
    loadPage(page);
  }
  $(window).on("hashchange", updateContent);

  updateContent();
});
