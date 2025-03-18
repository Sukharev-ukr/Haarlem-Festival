// ✅ Function to format time from "HH:MM:SS" to "HH:MM AM/PM"
function formatTime(timeString) {
  if (!timeString) return "N/A"; // Handle null values

  const [hours, minutes] = timeString.split(":");
  let hour = parseInt(hours);
  let suffix = hour >= 12 ? "PM" : "AM";

  // Convert 24-hour format to 12-hour format
  hour = hour % 12 || 12;

  return `${hour}:${minutes} ${suffix}`;
}

// ✅ Capitalize first letter of day name
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

document.addEventListener("DOMContentLoaded", function () {
  loadUsers();
  loadDanceEvents(); // call Load Event
});

function loadUsers() {
  let search = document.getElementById("searchUser").value;
  fetch(`/api/admin/users?search=${search}`)
    .then((response) => response.json())
    .then((data) => {
      let tableBody = document.querySelector("#userTable tbody");
      tableBody.innerHTML = "";
      data.forEach((user) => {
        tableBody.innerHTML += `
            <tr>
              <td>${user.userName}</td>
              <td>${user.Email}</td>
              <td>${user.role}</td>
            </tr>`;
      });
    });
}

function deleteUser(userID) {
  if (confirm("Are you sure you want to delete this user?")) {
    fetch("/api/admin/users/delete", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ userID }),
    })
      .then((response) => response.json())
      .then(() => loadUsers());
  }
}

function editUser(userID, userName, email, role) {
  document.getElementById("editUserID").value = userID;
  document.getElementById("editUserName").value = userName;
  document.getElementById("editUserEmail").value = email;
  document.getElementById("editUserRole").value = role;
  $("#editUserModal").modal("show");
}

function saveUser() {
  let userID = document.getElementById("editUserID").value;
  let userName = document.getElementById("editUserName").value;
  let email = document.getElementById("editUserEmail").value;
  let role = document.getElementById("editUserRole").value;

  fetch("/api/admin/users/update", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ userID, userName, email, role }),
  })
    .then((response) => response.json())
    .then(() => {
      $("#editUserModal").modal("hide");
      loadUsers();
    });
}

//////////////////////////////////////////////////////////////Dance
function loadDanceEvents() {
  fetch("/api/admin/danceEvents")
    .then((response) => response.json())
    .then((data) => {
      console.log("Dance Events API Response:", data); // ✅ Debugging Log

      let tableBody = document.querySelector("#danceEventTable tbody");
      tableBody.innerHTML = "";

      if (!Array.isArray(data) || data.length === 0) {
        console.warn("No dance events found.");
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center">No dance events available.</td></tr>`;
        return;
      }

      data.forEach((event) => {
        let formattedStartTime = formatTime(event.startTime);
        let formattedEndTime = formatTime(event.endTime);
        let formattedDay = capitalizeFirstLetter(event.day);

        tableBody.innerHTML += `
          <tr>
            <td>${event.danceID}</td>
            <td>${event.location}</td>
            <td>${formattedStartTime}</td>
            <td>${formattedEndTime}</td>
            <td>${formattedDay}</td>
            <td>${event.danceDate}</td>
            <td>${event.danceCapacity}</td>
            <td>
              <button class="btn btn-warning btn-sm" 
        onclick="editDanceEvent(
            ${event.danceID}, 
            '${event.location}', 
            '${event.startTime}', 
            '${event.endTime}', 
            '${event.day}', 
            '${event.danceDate}',
            '${event.danceCapacity}'
        )">
        Edit
        </button>
              <button class="btn btn-danger btn-sm" onclick="deleteDanceEvent(${event.danceID})">Delete</button>
            </td>
          </tr>`;
      });
    })
    .catch((error) => {
      console.error("Error loading dance events:", error);
      let tableBody = document.querySelector("#danceEventTable tbody");
      tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Error loading events.</td></tr>`;
    });
}

////////////////////////////////////////////////////////////////////////////////////// Edit Dance Event
// Open Edit Dance Modal with Passed Data
function editDanceEvent(
  danceID,
  location,
  startTime,
  endTime,
  day,
  danceDate,
  danceCapacity
) {
  document.getElementById("editDanceID").value = danceID;
  document.getElementById("editDanceLocation").value = location;
  document.getElementById("editDanceStartTime").value = startTime;
  document.getElementById("editDanceEndTime").value = endTime;
  document.getElementById("editDanceDay").value = day;
  document.getElementById("editDanceDate").value = danceDate;
  document.getElementById("editDanceCapacity").value = danceCapacity; // ✅ Điền số lượng chỗ ngồi

  // Change button action to UPDATE mode
  document
    .getElementById("saveDanceEventButton")
    .setAttribute("onclick", "saveDanceEvent()");

  // Show the modal
  $("#editDanceModal").modal("show");
}

// Save Updated Dance Event
function saveDanceEvent() {
  let danceID = document.getElementById("editDanceID").value;
  let location = document.getElementById("editDanceLocation").value;
  let startTime = document.getElementById("editDanceStartTime").value;
  let endTime = document.getElementById("editDanceEndTime").value;
  let day = document.getElementById("editDanceDay").value;
  let danceDate = document.getElementById("editDanceDate").value;
  let danceCapacity = document.getElementById("editDanceCapacity").value;

  if (
    !danceID ||
    !location ||
    !startTime ||
    !endTime ||
    !day ||
    !danceDate ||
    !danceCapacity
  ) {
    alert("All fields are required.");
    return;
  }

  let requestData = {
    danceID: parseInt(danceID),
    location,
    startTime,
    endTime,
    day,
    danceDate,
    danceCapacity,
  };

  console.log("Sending update request:", requestData);

  fetch("/api/admin/updateDanceEvent", {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(requestData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Response from server:", data);

      if (data.success) {
        $("#editDanceModal").modal("hide");
        loadDanceEvents();
      } else {
        alert("Error updating dance event: " + data.message);
      }
    })
    .catch((error) => console.error("Error updating dance event:", error));
}

/////////////////////////////////////////////////////////////////////Add Dance Event
// Open Add Dance Modal (Reusing Edit Modal)
function addDanceEvent() {
  // Clear previous values
  document.getElementById("editDanceID").value = "";
  document.getElementById("editDanceLocation").value = "";
  document.getElementById("editDanceStartTime").value = "";
  document.getElementById("editDanceEndTime").value = "";
  document.getElementById("editDanceDay").value = "";
  document.getElementById("editDanceDate").value = "";
  document.getElementById("editDanceCapacity").value = "";
  document.getElementById("editDanceDuration").value = "";

  // Change button action
  document
    .getElementById("saveDanceEventButton")
    .setAttribute("onclick", "saveNewDanceEvent()");
  // Debugging log to ensure the modal function is triggered
  console.log("Opening Modal...");
  // Show the modal
  $("#editDanceModal").modal("show");
}

// Save New Dance Event
function saveNewDanceEvent() {
  let location = document.getElementById("editDanceLocation").value;
  let startTime = document.getElementById("editDanceStartTime").value;
  let endTime = document.getElementById("editDanceEndTime").value;
  let day = document.getElementById("editDanceDay").value;
  let danceDate = document.getElementById("editDanceDate").value;
  let danceCapacity = document.getElementById("editDanceCapacity").value;
  let duration = document.getElementById("editDanceDuration").value + ":00"; //Convert to HH:MM:SS

  if (
    !location ||
    !startTime ||
    !endTime ||
    !day ||
    !danceDate ||
    !danceCapacity ||
    !duration
  ) {
    alert("All fields are required.");
    return;
  }

  let requestData = {
    location,
    startTime,
    endTime,
    day,
    danceDate,
    danceCapacity: parseInt(danceCapacity),
    duration, // ✅ Now in HH:MM:SS format
  };

  console.log("Sending request to add dance event:", requestData);

  fetch("/api/admin/addDanceEvent", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(requestData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Response from server:", data);
      if (data.success) {
        $("#editDanceModal").modal("hide");
        loadDanceEvents();
      } else {
        alert("Error adding dance event: " + data.message);
      }
    })
    .catch((error) => console.error("Error adding dance event:", error));
}

///////////////////////////////////////////////////////////////////////////////Delete Dance Event
function deleteDanceEvent(danceID) {
  if (!confirm("Are you sure you want to delete this event?")) return;

  fetch("/api/admin/deleteDanceEvent", {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ danceID }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Dance event deleted successfully!");
        loadDanceEvents(); // Cập nhật danh sách
      } else {
        alert("Error deleting event: " + data.message);
      }
    })
    .catch((error) => console.error("Error deleting dance event:", error));
}
