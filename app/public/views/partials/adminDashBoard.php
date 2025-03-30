<!-- Sidebar Navigation -->
<nav id="nav" class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand px-3" href="#">Admin Panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="adminNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="#userSection">Users</a></li>
      <li class="nav-item"><a class="nav-link" href="#danceSection">Dance Events</a></li>
      <li class="nav-item"><a class="nav-link" href="#artistSection">Artists</a></li>
      <li class="nav-item"><a class="nav-link" href="#danceArtistSection">Dance & Artist</a></li>
    </ul>
  </div>
</nav>

<section class="container mt-5">
    <h2 class="text-center">Admin Dashboard</h2>

    <!-- User Management Section -->
    <div id="userSection" class="card mt-4">
    <div id="userSection" class="card mt-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h3>User Management</h3>
        <button class="btn btn-success" onclick="openAddUserModal()">Add User</button>
    </div>
    <div class="card-body">
        <input type="text" class="form-control mb-3" id="searchUser" placeholder="Search user..." onkeyup="loadUsers()">
        <table class="table table-bordered table-striped" id="userTable">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>


<div id="danceSection" class="card mt-4">
    <div class="card-header bg-warning text-dark d-flex justify-content-between">
        <h3>Dance Event Management</h3>
        <button class="btn btn-success" onclick="addDanceEvent()">Add Event</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="danceEventTable">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="artistSection" class="card mt-4">
    <div class="card-header bg-warning text-dark d-flex justify-content-between">
        <h3>Artist Management</h3>
        <button class="btn btn-success" onclick="openAddArtistModal()">Add Artist</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="artistTable">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Style</th>
                    <th>Description</th>
                    <th>Origin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="danceArtistSection" class="card mt-4">
    <div class="card-header bg-info text-white d-flex justify-content-between">
        <h3>Dance-Artist Assignment Management</h3>
        <button class="btn btn-success" onclick="openAssignModal()">Assign Artist</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="assignmentTable">
            <thead class="thead-light">
                <tr>
                    <th>Dance ID</th>
                    <th>Location</th>
                    <th>Artist ID</th>
                    <th>Artist Name</th>
                    <th>Time</th>
                    <th>Date (Day)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

</section>

<!-- User Modal (For Adding & Editing Users) -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Information</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userID"> <!-- Hidden field for editing -->

                <div class="form-group">
                    <label for="userName">Name: </label>
                    <input type="text" class="form-control" id="userName">
                </div>
                <div class="form-group">
                    <label for="userEmail">Email: </label>
                    <input type="email" class="form-control" id="userEmail">
                </div>
                <div class="form-group">
                    <label for="userPassword">Password: </label>
                    <input type="password" class="form-control" id="userPassword">
                </div>
                <div class="form-group">
                    <label for="userRole">Role: </label>
                    <select class="form-control" id="userRole">
                        <option value="Admin">Admin</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>
                <button class="btn btn-primary" id="saveUserButton" onclick="saveUser()">Add User</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Editing Dance Event -->
<div class="modal fade" id="editDanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dance Event</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editDanceID">
                <div class="form-group">
                    <label for="editDanceLocation">Location: </label>
                    <input id="editDanceLocation" name="editDanceLocation" type="hidden">
                    <trix-editor input="editDanceLocation"></trix-editor>
                </div>
                <div class="form-group">
                    <label for="editDanceStartTime">Start Time: </label>
                    <input type="time" class="form-control" id="editDanceStartTime">
                </div>
                <div class="form-group">
                    <label for="editDanceEndTime">End Time: </label>
                    <input type="time" class="form-control" id="editDanceEndTime">
                </div>
                <div class="form-group">
                    <label for="editDanceDay">Day: </label>
                    <select class="form-control" id="editDanceDay">
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editDanceDate">Date: </label>
                    <input type="date" class="form-control" id="editDanceDate">
                </div>
                <div class="form-group">
                    <label for="editDanceCapacity">Capacity: </label>
                    <input type="number" class="form-control" id="editDanceCapacity" min="1">
                </div>

                <div class="form-group">
                    <label for="editDanceDuration">Duration (HH:MM): </label>
                    <input type="time" class="form-control" id="editDanceDuration">
                </div>
                <button class="btn btn-primary" id="saveDanceEventButton" onclick="saveDanceEvent()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding / Editing Artist -->
<div class="modal fade" id="artistModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="artistModalTitle">Add Artist</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="artistID">

                <!-- Name -->
                <div class="form-group">
                    <label for="artistName">Name: </label>
                    <input id="artistName" name="artistName" type="hidden">
                    <trix-editor input="artistName"></trix-editor>
                </div>

                <!-- Style -->
                <div class="form-group">
                    <label for="artistStyle">Style: </label>
                    <input id="artistStyle" name="artistStyle" type="hidden">
                    <trix-editor input="artistStyle"></trix-editor>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="artistDescription">Description: </label>
                    <input id="artistDescription" name="artistDescription" type="hidden">
                    <trix-editor input="artistDescription"></trix-editor>
                </div>

                <!-- Origin -->
                <div class="form-group">
                    <label for="artistOrigin">Origin: </label>
                    <input id="artistOrigin" name="artistOrigin" type="hidden">
                    <trix-editor input="artistOrigin"></trix-editor>
                </div>

                <button class="btn btn-primary" id="saveArtistButton" onclick="saveArtist()">Save</button>
            </div>
        </div>
    </div>
</div>



<!-- Assign Artist Modal -->
<div class="modal fade" id="assignArtistModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Artist to Dance</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="assignDanceDate">Dance Date</label>
                    <select class="form-control" id="assignDanceDate">
                        <option value="">Select Date</option>
                        <option value="2025-07-25">25/07/2025</option>
                        <option value="2025-07-26">26/07/2025</option>
                        <option value="2025-07-27">27/07/2025</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="assignDanceLocation">Dance Location</label>
                    <select class="form-control" id="assignDanceLocation">
                        <option value="">Select Location</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="assignArtist">Artist</label>
                    <select class="form-control" id="assignArtist">
                        <option value="">Select Artist</option>
                    </select>
                </div>
                <button class="btn btn-primary" id="saveAssignmentButton" onclick="assignArtist()">Assign</button>
            </div>
        </div>
    </div>
</div>


<script src="../../assets/js/adminDashboard.js"></script>
<link rel="stylesheet" href="../../assets/css/adminDashboard.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- Bootstrap JS & jQuery to display a modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once(__DIR__ . "/../partials/footer.php"); ?>
