<section class="container mt-5">
    <h2 class="text-center">Admin Dashboard</h2>

    <!-- User Management Section -->
    <!-- User Management Section -->
<div class="card mt-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h3>User Management</h3>
        <button class="btn btn-success" onclick="addUser()">Add User</button>
    </div>
    <div class="card-body">
        <input type="text" class="form-control mb-3" id="searchUser" placeholder="Search user..." onkeyup="loadUsers()">
        <table class="table table-bordered table-striped" id="userTable">
            <thead class="thead-dark">
                <tr>
                    <th onclick="sortUsers('userName')">Name</th>
                    <th onclick="sortUsers('Email')">Email</th>
                    <th onclick="sortUsers('role')">Role</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>


<div class="card mt-4">
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

</section>

<!-- Modal for Editing Dance Event -->
<!-- Modal for Editing Dance Event -->
<div class="modal fade" id="editDanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dance Event</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editDanceID">
                <div class="form-group">
                    <label for="editDanceLocation">Location</label>
                    <input type="text" class="form-control" id="editDanceLocation">
                </div>
                <div class="form-group">
                    <label for="editDanceStartTime">Start Time</label>
                    <input type="time" class="form-control" id="editDanceStartTime">
                </div>
                <div class="form-group">
                    <label for="editDanceEndTime">End Time</label>
                    <input type="time" class="form-control" id="editDanceEndTime">
                </div>
                <div class="form-group">
                    <label for="editDanceDay">Day</label>
                    <select class="form-control" id="editDanceDay">
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editDanceDate">Date</label>
                    <input type="date" class="form-control" id="editDanceDate">
                </div>
                <div class="form-group">
                    <label for="editDanceCapacity">Capacity</label>
                    <input type="number" class="form-control" id="editDanceCapacity" min="1">
                </div>

                <div class="form-group">
                    <label for="editDanceDuration">Duration (HH:MM)</label>
                    <input type="time" class="form-control" id="editDanceDuration">
                </div>
                <button class="btn btn-primary" id="saveDanceEventButton" onclick="saveDanceEvent()">Save Changes</button>
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
