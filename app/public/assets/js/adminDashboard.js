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
  loadArtists(); // call Load Artist
  loadAssignments(); //Load Dance and Artist assignemt
  populateArtists(); // call populate artist
});

////////////////////////////////////////////////////////////////////User
function loadUsers() {
  let search = document.getElementById("searchUser").value;
  fetch(`/api/admin/users?search=${search}`)
    .then((response) => response.json())
    .then((result) => {
      if (!result.success) {
        alert(result.message || "Failed to load users");
        return;
      }

      let users = result.data; // ✅ Extract the array correctly

      let tableBody = document.querySelector("#userTable tbody");
      tableBody.innerHTML = "";
      users.forEach((user) => {
        tableBody.innerHTML += `
              <tr>
                  <td>${user.userName}</td>
                  <td>${user.Email}</td>
                  <td>${user.role}</td>
                  <td>${user.registered_day}</td>
                  <td>
                      <button class="btn btn-warning btn-sm" onclick="editUser('${user.userID}', '${user.userName}', '${user.Email}', '${user.role}')">Edit</button>
                      <button class="btn btn-danger btn-sm" onclick="deleteUser('${user.userID}')">Delete</button>
                  </td>
              </tr>`;
      });
    });
}

/** 🎭 Open Add User Modal */
function openAddUserModal() {
  console.log("🆕 Opening Add User Modal..."); // ✅ Debugging Log

  // Reset all fields
  document.getElementById("userID").value = "";
  document.getElementById("userName").value = "";
  document.getElementById("userEmail").value = "";
  document.getElementById("userPassword").value = "";
  document.getElementById("userRole").value = "Employee";

  // Set the button action properly
  let saveButton = document.getElementById("saveUserButton");
  saveButton.textContent = "Add User";
  saveButton.setAttribute("onclick", "saveUser()");

  // Debug: Check if modal exists before opening
  if ($("#addUserModal").length) {
    $("#addUserModal").modal("show");
  } else {
    console.error("❌ Modal with ID 'addUserModal' not found in DOM.");
  }
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
  // Open the same modal as addUser, but now for editing
  document.getElementById("userID").value = userID;
  document.getElementById("userName").value = userName;
  document.getElementById("userEmail").value = email;
  document.getElementById("userPassword").value = ""; // leave password empty
  document.getElementById("userRole").value = role;

  // Change button text & action
  let saveButton = document.getElementById("saveUserButton");
  saveButton.textContent = "Update User";
  saveButton.setAttribute("onclick", "saveUser()");

  $("#addUserModal").modal("show");
}

function saveUser() {
  let userID = document.getElementById("userID").value;
  let userName = document.getElementById("userName").value;
  let email = document.getElementById("userEmail").value;
  let password = document.getElementById("userPassword").value;
  let role = document.getElementById("userRole").value;

  // Basic validation
  if (!userName || !email || !role) {
    alert("Please fill in all required fields.");
    return;
  }

  // If userID is empty -> ADD, else -> UPDATE
  if (userID === "") {
    if (!password || password.length < 6) {
      alert("Password must be at least 6 characters for new users.");
      return;
    }

    fetch("/api/admin/users/add", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ userName, email, password, role }),
    })
      .then((response) => response.json())
      .then((res) => {
        if (res.success) {
          $("#addUserModal").modal("hide");
          loadUsers();
        } else {
          alert(res.message);
        }
      });
  } else {
    // Update does not require password
    fetch("/api/admin/users/update", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ userID, userName, email, role }),
    })
      .then((response) => response.json())
      .then((res) => {
        if (res.success) {
          $("#addUserModal").modal("hide");
          loadUsers();
        } else {
          alert(res.message);
        }
      });
  }
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

  // ✅ Load the location into Trix editor
  document
    .querySelector("trix-editor[input='editDanceLocation']")
    .editor.loadHTML(location);

  document.getElementById("editDanceStartTime").value = startTime;
  document.getElementById("editDanceEndTime").value = endTime;
  document.getElementById("editDanceDay").value = day;
  document.getElementById("editDanceDate").value = danceDate;
  document.getElementById("editDanceCapacity").value = danceCapacity;

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
  document.getElementById("editDanceID").value = "";
  document.getElementById("editDanceLocation").value = ""; // hidden input
  document
    .querySelector("trix-editor[input='editDanceLocation']")
    .editor.loadHTML(); // trix editor

  document.getElementById("editDanceStartTime").value = "";
  document.getElementById("editDanceEndTime").value = "";
  document.getElementById("editDanceDay").value = "";
  document.getElementById("editDanceDate").value = "";
  document.getElementById("editDanceCapacity").value = "";
  document.getElementById("editDanceDuration").value = "";

  document
    .getElementById("saveDanceEventButton")
    .setAttribute("onclick", "saveNewDanceEvent()");
  console.log("Opening Modal...");
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

//////////////////////Delete Dance Event
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

//////////////////////////////////////////////////////////////////////////////Artist
// ✅ Load Artists
function loadArtists() {
  console.log("🔍 Fetching artist data...");

  fetch("/api/admin/artists")
    .then((response) => response.json())
    .then((data) => {
      console.log("🎭 Artists API Response:", data);

      let tableBody = document.querySelector("#artistTable tbody");
      tableBody.innerHTML = "";

      if (!data || !data.success || !Array.isArray(data.data)) {
        console.warn("⚠️ Invalid API response format:", data);
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Error loading artists.</td></tr>`;
        return;
      }

      if (data.data.length === 0) {
        console.log("📭 No artists found.");
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-warning">No artists available.</td></tr>`;
        return;
      }

      data.data.forEach((artist) => {
        tableBody.innerHTML += `
                  <tr>
                      <td>${artist.artistID}</td>
                      <td>${artist.name}</td>
                      <td>${artist.style}</td>
                      <td>${artist.description}</td>
                      <td>${artist.origin}</td>
                      <td>
                          ${
                            artist.picture
                              ? `<img src="${artist.picture}" alt="Artist Picture" style="max-width:70px;">`
                              : "No Image"
                          }
                      </td>
                      <td> 
                          <button 
                              class="btn btn-warning btn-sm"
                              data-id="${artist.artistID}"
                              data-name="${htmlEntities(artist.name)}"
                              data-style="${htmlEntities(artist.style)}"
                              data-description="${htmlEntities(
                                artist.description
                              )}"
                              data-origin="${htmlEntities(artist.origin)}"
                              data-picture="${
                                artist.picture ? artist.picture : ""
                              }"
                              onclick="openEditArtistModal(this)">Edit</button>
                          <button class="btn btn-danger btn-sm" onclick="deleteArtist(${
                            artist.artistID
                          })">Delete</button> 
                      </td>
                  </tr>`;
      });

      console.log("✅ Artist data loaded successfully.");
    })
    .catch((error) => {
      console.error("❌ Error loading artists:", error);
    });
}

function htmlEntities(str) {
  if (!str) return "";
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
}

// Open Add Artist Modal
function openAddArtistModal() {
  document.getElementById("artistModalTitle").textContent = "Add Artist";
  document.getElementById("artistID").value = "";

  //Only plain inputs now
  document.getElementById("artistName").value = "";
  document.getElementById("artistStyle").value = "";
  document.getElementById("artistOrigin").value = "";

  //Only keep trix for description
  document.getElementById("artistDescription").value = "";
  document
    .querySelector("trix-editor[input='artistDescription']")
    .editor.loadHTML("");

  document
    .getElementById("saveArtistButton")
    .setAttribute("onclick", "saveArtist()");
  $("#artistModal").modal("show");
}

//Open Edit Artist Modal
function openEditArtistModal(button) {
  document.getElementById("artistModalTitle").textContent = "Edit Artist";
  document.getElementById("artistID").value = button.dataset.id;

  //Plain inputs
  document.getElementById("artistName").value = button.dataset.name;
  document.getElementById("artistStyle").value = button.dataset.style;
  document.getElementById("artistOrigin").value = button.dataset.origin;

  // Trix editor only for description
  document.getElementById("artistDescription").value =
    button.dataset.description;
  document
    .querySelector("trix-editor[input='artistDescription']")
    .editor.loadHTML(button.dataset.description);

  document.getElementById("artistPreview").src = button.dataset.picture || "";

  document.getElementById("artistPicture").value = "";

  document
    .getElementById("saveArtistButton")
    .setAttribute("onclick", "saveArtist()");
  $("#artistModal").modal("show");
}

//Save Artist (Add or Update)
function saveArtist() {
  let artistID = document.getElementById("artistID").value;
  let name = document.getElementById("artistName").value;
  let style = document.getElementById("artistStyle").value;
  let description = document.getElementById("artistDescription").value;
  let origin = document.getElementById("artistOrigin").value;
  let picture = document.getElementById("artistPicture").files[0];

  let formData = new FormData();
  formData.append("artistID", artistID);
  formData.append("name", name);
  formData.append("style", style);
  formData.append("description", description);
  formData.append("origin", origin);
  if (picture) formData.append("picture", picture);

  let url = artistID ? "/api/admin/updateArtist" : "/api/admin/addArtist";

  fetch(url, {
    method: "POST", // Always use POST when uploading files
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        $("#artistModal").modal("hide");
        loadArtists();
      } else {
        alert("Error saving artist: " + data.message);
      }
    })
    .catch((error) => console.error("❌ Error saving artist:", error));
}

//Preview the image immediately when selected
function previewArtistImage(event) {
  const input = event.target;
  const preview = document.getElementById("artistPreview");

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// ✅ Delete Artist
function deleteArtist(artistID) {
  if (!confirm("Are you sure you want to delete this artist?")) return;

  fetch("/api/admin/deleteArtist", {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ artistID }),
  })
    .then(() => loadArtists())
    .catch((error) => console.error("❌ Error deleting artist:", error));
}

/////////////////////////////////////////////////////////////////////////Artist and Dance Assignment

let isEditMode = false; // Track if we are in edit mode
let editingDanceID = null;
let editingArtistID = null;

/** 🎭 Load Dance-Artist Assignments */
function loadAssignments() {
  console.log("🔍 Fetching assignments...");

  fetch("/api/admin/assignments")
    .then((response) => response.json())
    .then((data) => {
      console.log("📡 Assignments API Response:", data);

      let tableBody = document.querySelector("#assignmentTable tbody");
      tableBody.innerHTML = "";

      if (!data || !data.success || !Array.isArray(data.data)) {
        console.warn("⚠️ Invalid API response format:", data);
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Error loading assignments.</td></tr>`;
        return;
      }

      if (data.data.length === 0) {
        console.log("📭 No assignments found.");
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-warning">No assignments available.</td></tr>`;
        return;
      }

      data.data.forEach((assignment) => {
        tableBody.innerHTML += `
          <tr>
            <td>${assignment.danceID}</td>
            <td>${assignment.location}</td>
            <td>${assignment.artistID}</td>
            <td>${assignment.name.replace(/"/g, "&quot;")}</td>
            <td>${assignment.startTime} - ${assignment.endTime}</td>
            <td>${assignment.danceDate} (${assignment.day})</td>
            <td>
              <button class="btn btn-warning btn-sm" onclick="editAssignment('${
                assignment.danceID
              }', '${assignment.artistID}', '${
          assignment.danceDate
        }')">Edit</button>
              <button class="btn btn-danger btn-sm" onclick="deleteAssignment('${
                assignment.danceID
              }', '${assignment.artistID}')">Delete</button>
            </td>
          </tr>`;
      });

      console.log("✅ Assignments loaded successfully.");
    })
    .catch((error) => {
      console.error("❌ Error loading assignments:", error);
      let tableBody = document.querySelector("#assignmentTable tbody");
      tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Failed to load assignments.</td></tr>`;
    });
}

/** 🎭 Open Assign Modal */
function openAssignModal() {
  console.log("🎭 Opening Assign Artist Modal...");

  isEditMode = false;
  editingDanceID = null;
  editingArtistID = null;

  // Reset form
  document.getElementById("assignDanceDate").value = "2025-07-25";
  document.getElementById("assignDanceLocation").innerHTML =
    '<option value="">Select Location</option>';
  document.getElementById("assignArtist").innerHTML =
    '<option value="">Select Artist</option>';

  // Populate dropdowns
  document.getElementById("assignDanceDate").dispatchEvent(new Event("change"));
  populateArtists();

  // Show the modal
  $("#assignArtistModal").modal("show");

  // Update button to "Assign"
  let saveButton = document.getElementById("saveAssignmentButton");
  saveButton.textContent = "Assign";
  saveButton.setAttribute("onclick", "assignArtist()");
}

/** 🎭 Fetch Dance Locations Based on Selected Date */
document
  .getElementById("assignDanceDate")
  .addEventListener("change", function () {
    let selectedDate = this.value;
    if (!selectedDate) return;

    console.log("📅 Fetching locations for date:", selectedDate);

    fetch(`/api/admin/danceLocations?date=${selectedDate}`)
      .then((response) => response.json())
      .then((data) => {
        console.log("📡 Received Dance Locations:", data);

        let locationDropdown = document.getElementById("assignDanceLocation");
        locationDropdown.innerHTML =
          '<option value="">Select Location</option>';

        if (data.success && Array.isArray(data.data)) {
          data.data.forEach((dance) => {
            let option = document.createElement("option");
            option.value = dance.danceID;
            option.textContent = dance.location;
            locationDropdown.appendChild(option);
          });
        } else {
          console.warn("⚠️ No dance locations found.");
          locationDropdown.innerHTML =
            '<option value="">No locations available</option>';
        }
      })
      .catch((error) => {
        console.error("❌ Error fetching dance locations:", error);
      });
  });

/** 🎭 Populate Artists */
function populateArtists() {
  console.log("🔍 Fetching artists...");

  fetch("/api/admin/artists")
    .then((response) => response.json())
    .then((data) => {
      let artistDropdown = document.getElementById("assignArtist");
      artistDropdown.innerHTML = '<option value="">Select Artist</option>';

      if (!data.success || !Array.isArray(data.data)) {
        console.warn("⚠️ No artists available.");
        return;
      }

      data.data.forEach((artist) => {
        let option = document.createElement("option");
        option.value = artist.artistID;
        option.textContent = artist.name;
        artistDropdown.appendChild(option);
      });

      console.log("✅ Artists populated successfully.");
    })
    .catch((error) => console.error("❌ Error loading artists:", error));
}

/** 🎭 Assign Artist to Dance */
function assignArtist() {
  console.log("📤 Assigning Artist...");

  let danceID = document.getElementById("assignDanceLocation").value;
  let artistID = document.getElementById("assignArtist").value;

  if (!danceID || !artistID) {
    alert("Please select a dance and an artist.");
    return;
  }

  let requestData = { danceID, artistID };

  fetch("/api/admin/assignArtist", {
    // ✅ Correct route
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(requestData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        $("#assignArtistModal").modal("hide");
        loadAssignments();
      } else {
        alert("Error assigning artist: " + data.message);
      }
    })
    .catch((error) => console.error("❌ Error assigning artist:", error));
}

/** 🎭 Edit Existing Dance-Artist Assignment */
function editAssignment(danceID, artistID, danceDate) {
  console.log("✏️ Editing Assignment:", { danceID, artistID, danceDate });

  isEditMode = true;
  editingDanceID = danceID;
  editingArtistID = artistID;

  document.getElementById("assignDanceDate").value = danceDate;
  $("#assignArtistModal").modal("show");

  // Load locations & artists
  document.getElementById("assignDanceDate").dispatchEvent(new Event("change"));
  populateArtists();

  document.getElementById("assignDanceLocation").value = danceID;
  document.getElementById("assignArtist").value = artistID;

  // Update button text & event listener
  let saveButton = document.getElementById("saveAssignmentButton");
  saveButton.textContent = "Save Changes";
  saveButton.setAttribute("onclick", "updateAssignment()");
}

/** 🎭 Update Dance-Artist Assignment */
function updateAssignment() {
  let newDanceID = document.getElementById("assignDanceLocation").value;
  let newArtistID = document.getElementById("assignArtist").value;

  if (!newDanceID || !newArtistID) {
    alert("Please select a dance and an artist.");
    return;
  }

  let requestData = {
    danceID: editingDanceID,
    artistID: editingArtistID,
    newDanceID,
    newArtistID,
  };

  console.log("📤 Updating Assignment:", requestData);

  fetch("/api/admin/updateAssignment", {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(requestData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        $("#assignArtistModal").modal("hide");
        loadAssignments();
      } else {
        alert("Error updating assignment: " + data.message);
      }
    })
    .catch((error) => console.error("❌ Error updating assignment:", error));
}

/** 🎭 Delete Assignment */
function deleteAssignment(danceID, artistID) {
  if (!confirm("Are you sure you want to delete this assignment?")) return;

  let requestData = { danceID, artistID };

  console.log("🗑 Deleting Assignment:", requestData);

  fetch("/api/admin/deleteAssignment", {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(requestData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("✅ Assignment deleted successfully.");
        loadAssignments(); // Reload assignments after deletion
      } else {
        alert("❌ Error deleting assignment: " + data.message);
      }
    })
    .catch((error) => console.error("❌ Error deleting assignment:", error));
}

//////////////////////////////////////////////////////////Order Management

document.addEventListener("DOMContentLoaded", function () {
  loadPaidOrders(); // to Display order to front end
});

function loadPaidOrders() {
  fetch("/api/admin/paidOrders")
    .then((res) => res.json())
    .then((data) => {
      const tbody = document.querySelector("#paidOrderTable tbody");
      tbody.innerHTML = "";

      if (!data.success || !data.data || data.data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">No paid orders found.</td></tr>`;
        return;
      }

      data.data.forEach((order) => {
        tbody.innerHTML += `
                  <tr>
                      <td>${order.orderID}</td>
                      <td>${order.userName}</td>
                      <td>${order.orderDate}</td>
                      <td>€${Number(order.total).toFixed(2)}</td>
                      <td>
                          <button class="btn btn-primary btn-sm" onclick="viewOrderDetail(${
                            order.orderID
                          })">
                              View Order Detail
                          </button>
                      </td>
                  </tr>`;
      });
    })
    .catch((err) => console.error("❌ Error loading paid orders:", err));
}

function viewOrderDetail(orderID) {
  fetch(`/api/admin/orderDetail?orderID=${orderID}`)
    .then((res) => res.json())
    .then((data) => {
      if (!data.success) return alert(data.message);

      if (!data.data || data.data.length === 0) {
        document.getElementById(
          "orderDetailContent"
        ).innerHTML = `<p class="text-danger">No items found for this order.</p>`;
        $("#orderDetailModal").modal("show");
        return;
      }

      let html = `
          <table class="table table-bordered" id="orderDetailTable">
              <thead class="thead-light">
                  <tr>
                      <th>Type</th>
                      <th>Details</th>
                      <th>Price</th>
                  </tr>
              </thead>
              <tbody>`;

      let total = 0;

      data.data.forEach((item) => {
        let detail = "";
        if (item.bookingType === "Dance") {
          detail = `${item.artistName} @ ${item.danceLocation} (${item.danceDate})`;
        } else if (item.bookingType === "History") {
          detail = `${item.tourStartTime} | ${item.numParticipants} participants`;
        } else if (item.bookingType === "Restaurant") {
          detail = `${item.restaurantName} - ${item.amountAdults} Adults, ${item.amountChildren} Children`;
        }
        total += Number(item.itemPrice);
        html += `<tr><td>${
          item.bookingType
        }</td><td>${detail}</td><td>€${Number(item.itemPrice).toFixed(
          2
        )}</td></tr>`;
      });

      html += `<tr class="font-weight-bold bg-light"><td colspan="2">Total</td><td>€${total.toFixed(
        2
      )}</td></tr>`;
      html += `</tbody></table>`;

      document.getElementById("orderDetailContent").innerHTML = html;
      $("#orderDetailModal").modal("show");
    })
    .catch((err) => console.error("❌ Error loading order detail:", err));
}

function exportOrderDetailCSV() {
  const table = document.querySelector("#orderDetailContent table");
  if (!table) return;

  let csv = [];
  const rows = table.querySelectorAll("tr");
  rows.forEach((row) => {
    const cols = row.querySelectorAll("td, th");
    const rowData = [...cols].map((cell) => `"${cell.innerText}"`).join(",");
    csv.push(rowData);
  });

  const blob = new Blob([csv.join("\n")], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "order-details.csv";
  a.click();
}

function exportOrderDetailExcel() {
  const table = document.querySelector("#orderDetailContent table");
  if (!table) {
    alert("No order details to export.");
    return;
  }

  // ✅ Convert HTML table to SheetJS worksheet properly
  const worksheet = XLSX.utils.table_to_sheet(table, { raw: true });

  // ✅ Create workbook
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Order Details");

  // ✅ Write to xlsx (force Excel compatibility)
  XLSX.writeFile(
    workbook,
    `order-detail-${new Date().toISOString().slice(0, 10)}.xlsx`,
    { bookType: "xlsx", type: "binary" }
  );
}

function closeOrderDetailModal() {
  $("#orderDetailModal").modal("hide");
}

////////////////////////////////////////////////////////////Restaurent

document.addEventListener("DOMContentLoaded", function () {
  loadRestaurants(); // to Display order to front end
});

// ✅ Load Restaurants
function loadRestaurants() {
  console.log("🍽️ Fetching restaurant data...");

  fetch("/api/admin/restaurants")
    .then((response) => response.json())
    .then((data) => {
      console.log("✅ Restaurants API Response:", data);

      const tbody = document.querySelector("#restaurantTable tbody");
      tbody.innerHTML = "";

      if (!data || !data.success || !Array.isArray(data.data)) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center text-danger">Error loading restaurants.</td></tr>`;
        return;
      }

      if (data.data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center text-warning">No restaurants available.</td></tr>`;
        return;
      }

      data.data.forEach((restaurant) => {
        tbody.innerHTML += `
              <tr>
                  <td>${restaurant.restaurantID}</td>
                  <td>${restaurant.restaurantName}</td>
                  <td>${restaurant.address}</td>
                  <td>${restaurant.cuisine}</td>
                  <td>${restaurant.description}</td>
                  <td>€${restaurant.pricePerAdult}</td>
                  <td>€${restaurant.pricePerChild}</td>
                  <td>${
                    restaurant.restaurantPicture
                      ? `<img src="${restaurant.restaurantPicture}" style="max-width:70px;">`
                      : "No Image"
                  }</td>
                  <td>${
                    restaurant.restaurantDiningDetailPicture
                      ? `<img src="${restaurant.restaurantDiningDetailPicture}" style="max-width:70px;">`
                      : "No Image"
                  }</td>
                  <td>
                      <button class="btn btn-warning btn-sm" onclick="openEditRestaurantModal(this)"
                          data-id="${restaurant.restaurantID}"
                          data-name="${restaurant.restaurantName}"
                          data-address="${restaurant.address}"
                          data-cuisine="${restaurant.cuisine}"
                          data-description="${restaurant.description}"
                          data-priceperadult="${restaurant.pricePerAdult}"
                          data-priceperchild="${restaurant.pricePerChild}"
                          data-picture="${restaurant.restaurantPicture}"
                          data-dining="${
                            restaurant.restaurantDiningDetailPicture
                          }">
                          Edit
                      </button>
                      <button class="btn btn-danger btn-sm" onclick="deleteRestaurant(${
                        restaurant.restaurantID
                      })">Delete</button>
                  </td>
              </tr>`;
      });
    })
    .catch((error) => console.error("❌ Error loading restaurants:", error));
}

// ✅ Open Add Modal
function openAddRestaurantModal() {
  document.getElementById("restaurantModalTitle").textContent =
    "Add Restaurant";
  document.getElementById("restaurantID").value = "";
  document.getElementById("restaurantName").value = "";
  document.getElementById("address").value = "";
  document.getElementById("cuisine").value = "";
  document.getElementById("restaurantDescription").value = "";
  document
    .querySelector("trix-editor[input='restaurantDescription']")
    .editor.loadHTML("");
  document.getElementById("pricePerAdult").value = "";
  document.getElementById("pricePerChild").value = "";
  document.getElementById("previewRestaurant").src = "";
  document.getElementById("previewDiningDetail").src = "";
  document.getElementById("restaurantPicture").value = "";
  document.getElementById("diningDetailPicture").value = "";
  $("#restaurantModal").modal("show");
}

// ✅ Open Edit Model
function openEditRestaurantModal(button) {
  document.getElementById("restaurantModalTitle").textContent =
    "Edit Restaurant";
  document.getElementById("restaurantID").value = button.dataset.id;

  document.getElementById("restaurantName").value = button.dataset.name;
  document.getElementById("address").value = button.dataset.address;
  document.getElementById("cuisine").value = button.dataset.cuisine;

  document.getElementById("restaurantDescription").value =
    button.dataset.description;
  document
    .querySelector("trix-editor[input='restaurantDescription']")
    .editor.loadHTML(button.dataset.description);

  document.getElementById("pricePerAdult").value =
    button.dataset.priceperadult || 0;
  document.getElementById("pricePerChild").value =
    button.dataset.priceperchild || 0;

  document.getElementById("previewRestaurant").src =
    button.dataset.picture || "";
  document.getElementById("previewDiningDetail").src =
    button.dataset.dining || "";

  document.getElementById("restaurantPicture").value = "";
  document.getElementById("diningDetailPicture").value = "";

  $("#restaurantModal").modal("show");
}

// ✅ Save Restaurant
function saveRestaurant() {
  const id = document.getElementById("restaurantID").value;
  const name = document.getElementById("restaurantName").value;
  const address = document.getElementById("address").value;
  const cuisine = document.getElementById("cuisine").value;

  // ✅ Get Trix content correctly
  const description = document.getElementById("restaurantDescription").value;

  const pricePerAdult = document.getElementById("pricePerAdult").value || 0;
  const pricePerChild = document.getElementById("pricePerChild").value || 0;

  const restaurantPicture =
    document.getElementById("restaurantPicture").files[0];
  const diningDetailPicture = document.getElementById("diningDetailPicture")
    .files[0];

  const formData = new FormData();
  if (id) formData.append("id", id);
  formData.append("name", name);
  formData.append("address", address);
  formData.append("cuisine", cuisine);
  formData.append("description", description);
  formData.append("pricePerAdult", pricePerAdult);
  formData.append("pricePerChild", pricePerChild);
  if (restaurantPicture) formData.append("picture", restaurantPicture);
  if (diningDetailPicture)
    formData.append("diningPicture", diningDetailPicture); // ✅ correct name

  const url = id ? "/api/admin/updateRestaurant" : "/api/admin/addRestaurant";

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        $("#restaurantModal").modal("hide");
        loadRestaurants();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch((err) => console.error("❌ Error:", err));
}

// ✅ Delete Restaurant
function deleteRestaurant(id) {
  if (!confirm("Are you sure you want to delete this restaurant?")) return;

  fetch("/api/admin/deleteRestaurant", {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ restaurantID: id }), // make sure your controller expects restaurantID
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        loadRestaurants();
      } else {
        alert("Delete failed: " + data.message);
      }
    })
    .catch((error) => console.error("❌ Error deleting restaurant:", error));
}

// ✅ Image Previewers
function previewRestaurantImage(event) {
  const input = event.target;
  const preview = document.getElementById("previewRestaurant");
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = (e) => (preview.src = e.target.result);
    reader.readAsDataURL(input.files[0]);
  }
}

function previewDiningImage(event) {
  const input = event.target;
  const preview = document.getElementById("previewDiningDetail");
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = (e) => (preview.src = e.target.result);
    reader.readAsDataURL(input.files[0]);
  }
}

///////////////////////////////////////////////////////////////////Restaurant
function loadRestaurantSlots() {
  fetch("/api/admin/restaurant-slots")
    .then((res) => res.json())
    .then((data) => {
      const tbody = document.querySelector("#restaurantSlotTable tbody");
      tbody.innerHTML = "";
      if (data.success) {
        data.data.forEach((slot) => {
          tbody.innerHTML += `
            <tr>
              <td>${slot.slotID}</td>
              <td>${slot.restaurantName}</td>
              <td>${slot.startTime}</td>
              <td>${slot.endTime}</td>
              <td>${slot.capacity}</td>
              <td>
                <button class="btn btn-warning btn-sm" onclick="openAddRestaurantSlotModal(${slot.slotID}, '${slot.restaurantName}', '${slot.startTime}', '${slot.endTime}', ${slot.capacity})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteRestaurantSlot(${slot.slotID})">Delete</button>
              </td>
            </tr>`;
        });
      } else {
        tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center">No slots found.</td></tr>`;
      }
    })
    .catch((err) => console.error("❌ Slot load error:", err));
}

function populateSlotRestaurants() {
  const dropdown = document.getElementById("restaurantSlotRestaurantID");
  dropdown.innerHTML = '<option value="">Select Restaurant</option>';

  fetch("/api/admin/restaurant-slots/restaurants")
    .then((res) => res.json())
    .then((data) => {
      if (!data.success || !Array.isArray(data.data)) {
        dropdown.innerHTML += "<option disabled>No restaurants found</option>";
        return;
      }

      data.data.forEach((restaurant) => {
        const option = document.createElement("option");
        option.value = restaurant.restaurantID;
        option.textContent = restaurant.restaurantName;
        dropdown.appendChild(option);
      });

      dropdown.disabled = false;
    })
    .catch((error) => {
      console.error("❌ Error loading slot restaurants:", error);
      dropdown.innerHTML +=
        "<option disabled>Error fetching restaurants</option>";
    });
}

function openAddRestaurantSlotModal(
  slotID = "",
  restaurantName = "",
  startTime = "",
  endTime = "",
  capacity = ""
) {
  document.getElementById("slotID").value = slotID;
  document.getElementById("startTime").value = startTime;
  document.getElementById("endTime").value = endTime;
  document.getElementById("capacity").value = capacity;

  const dropdown = document.getElementById("restaurantSlotRestaurantID");

  if (slotID) {
    dropdown.innerHTML = `<option selected disabled>${restaurantName}</option>`;
    dropdown.disabled = true;
  } else {
    dropdown.disabled = false;
    populateSlotRestaurants(); // Call the renamed dropdown loader
  }

  $("#restaurantSlotModal").modal("show");
}

function saveRestaurantSlot() {
  const slotID = document.getElementById("slotID").value;
  const restaurantID = document.getElementById(
    "restaurantSlotRestaurantID"
  ).value;
  const startTime = document.getElementById("startTime").value;
  const endTime = document.getElementById("endTime").value;
  const capacity = document.getElementById("capacity").value;

  if (!restaurantID || !startTime || !endTime || !capacity) {
    return alert("Please fill in all fields!");
  }

  fetch("/api/admin/restaurant-slots/save", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      slotID,
      restaurantID,
      startTime,
      endTime,
      capacity,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        $("#restaurantSlotModal").modal("hide");
        loadRestaurantSlots();
      } else {
        alert(data.message || "Error saving slot.");
      }
    })
    .catch((err) => console.error("❌ Save error:", err));
}

function deleteRestaurantSlot(slotID) {
  if (!confirm("Are you sure you want to delete this slot?")) return;
  fetch("/api/admin/restaurant-slots/delete", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ slotID }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        loadRestaurantSlots();
      } else {
        alert(data.message || "Delete failed");
      }
    })
    .catch((err) => console.error("❌ Delete error:", err));
}

document.addEventListener("DOMContentLoaded", loadRestaurantSlots);

/////////////////////////////////////////////////////////////////////////Ticket Type
// ====== Load all Ticket Types ======

document.addEventListener("DOMContentLoaded", function () {
  loadTicketTypes();
});
function loadTicketTypes() {
  fetch("/api/admin/tickettypes")
    .then((res) => res.json())
    .then((data) => {
      console.log("🎯 TicketTypes loaded:", data);
      const tbody = document.querySelector("#ticketTypeTable tbody");
      tbody.innerHTML = "";
      if (data.success) {
        data.data.forEach((ticket) => {
          tbody.innerHTML += `
                      <tr>
                          <td>${ticket.ticketTypeID}</td>
                          <td>${ticket.location}</td>
                          <td>${ticket.type}</td>
                          <td>${ticket.price}</td>
                          <td>
                              <button class="btn btn-warning btn-sm" onclick="openTicketTypeModal(${ticket.ticketTypeID}, '${ticket.type}', ${ticket.price}, '${ticket.location}')">Edit</button>
                              <button class="btn btn-danger btn-sm" onclick="deleteTicketType(${ticket.ticketTypeID})">Delete</button>
                          </td>
                      </tr>`;
        });
      } else {
        tbody.innerHTML = `<tr><td colspan="5">Error loading ticket types.</td></tr>`;
      }
    })
    .catch((err) => console.error("❌ Error:", err));
}

// ====== Populate Dance Dropdown ======
function loadDanceOptions(selectedLocation = "") {
  fetch("/api/admin/dances")
    .then((res) => res.json())
    .then((data) => {
      const select = document.getElementById("danceID");
      select.innerHTML = '<option value="">Select Location</option>';
      if (data.success) {
        data.data.forEach((dance) => {
          const option = document.createElement("option");
          option.value = dance.danceID;
          option.textContent = dance.location;
          if (dance.location === selectedLocation) option.selected = true;
          select.appendChild(option);
        });
      } else {
        select.innerHTML = "<option disabled>Error loading dances</option>";
      }
    })
    .catch((err) => console.error("❌ Error:", err));
}

// ====== Open Modal (for both Add & Edit) ======
function openTicketTypeModal(
  ticketTypeID = "",
  type = "",
  price = "",
  location = ""
) {
  document.getElementById("ticketTypeID").value = ticketTypeID;
  document.getElementById("type").value = type;
  document.getElementById("price").value = price;

  loadDanceOptions(location); // Load dropdown and optionally select location

  $("#ticketTypeModal").modal("show");
}

// ====== Save (Add or Update Automatically) ======
function saveTicketType() {
  const ticketTypeID = document.getElementById("ticketTypeID").value;
  const danceID = document.getElementById("danceID").value;
  const type = document.getElementById("type").value;
  const price = document.getElementById("price").value;

  if (!danceID || !type || !price) return alert("All fields are required!");

  fetch("/api/admin/tickettypes/addOrUpdate", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ticketTypeID, danceID, type, price }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log("✅ Save Response:", data);
      if (data.success) {
        $("#ticketTypeModal").modal("hide");
        loadTicketTypes();
      } else {
        alert(data.message || "Error occurred");
      }
    })
    .catch((err) => console.error("❌ Error:", err));
}

// ====== Delete ======
function deleteTicketType(ticketTypeID) {
  if (!confirm("Are you sure you want to delete this ticket type?")) return;
  fetch("/api/admin/tickettypes/delete", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ticketTypeID }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log("🗑 Delete Response:", data);
      if (data.success) {
        loadTicketTypes();
      } else {
        alert(data.message || "Error occurred");
      }
    })
    .catch((err) => console.error("❌ Error:", err));
}

// Auto load on page ready
document.addEventListener("DOMContentLoaded", loadTicketTypes);
