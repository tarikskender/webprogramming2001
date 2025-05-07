const taskModalContainer = document.getElementById("taskModalContainer");
document.addEventListener("DOMContentLoaded", function () {
  document.body.addEventListener("click", function (event) {
    if (event.target && event.target.id === "btn-createTask") {
      loadTaskModal();
    }
  });

  function loadTaskModal() {
    const taskModalContainer = document.getElementById("taskModalContainer");

    taskModalContainer.innerHTML = "";

    taskModalContainer.innerHTML = `
    <div class="modal fade show" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true" style="display: block; background-color: rgba(0, 0, 0, 0.7);">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="taskModalLabel">Create New Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <p>Fill in the details below to create a new task.</p>
            <form id="taskForm">
                <div class="form-group">
                <label for="taskTitle">Title:</label>
                <input type="text" id="taskTitle" name="taskTitle" class="form-control" required><br>
                </div>
                <div class="form-group">
                <label for="taskDescription">Description:</label>
                <textarea id="taskDescription" name="taskDescription" class="form-control"></textarea><br>
                </div>
                <button type="submit" class="btn btn-success submit-task">Save Task</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    `;

    taskModalContainer.style.display = "block";

    const taskForm = document.getElementById("taskForm");

    taskForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const taskTitle = document.getElementById("taskTitle").value;
      const taskDescription = document.getElementById("taskDescription").value;

      const newTask = {
        title: taskTitle,
        description: taskDescription,
        createdAt: new Date().toISOString(),
      };

      fetch("http://localhost:8000/backend/dao/tasks/createTask.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(newTask),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Task saved:", data);
          // Handle successful response (e.g., update UI)
        })
        .catch((error) => console.error("Error:", error));

      taskModalContainer.style.display = "none";

      taskForm.reset();
    });
  }

  document.body.addEventListener("click", function (event) {
    if (
      (event.target && event.target.id === "close-modal") ||
      event.target.id === "taskModal"
    ) {
      const taskModalContainer = document.getElementById("taskModalContainer");
      taskModalContainer.style.display = "none";
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      taskModalContainer.style.display = "none";
    }
  });
});
