<nav id="nav" class="navbar navbar-dark bg-dark d-flex flex-column align-items-start p-2" style="position:fixed; top:0; left:0; height:100vh; width:100px;">
    <a class="navbar-brand mb-4 fs-5" href="#">Admin</a>

    <ul class="navbar-nav w-100 flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#userSection"><i class="fas fa-user"></i>Users</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#danceSection"><i class="fas fa-music"></i>Events</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#artistSection"><i class="fas fa-paint-brush"></i>Artists</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#ticketTypeSection"><i class="fas fa-ticket"></i>Ticket</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#danceArtistSection"><i class="fas fa-users"></i>Assign</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#paidOrderSection"><i class="fas fa-receipt"></i>Orders</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#restaurantSection">
                <i class="fas fa-utensils"></i> Dining
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link small" href="#restaurantSlotSection">
                <i class="fas fa-clock"></i> Slots
            </a>
        </li>
    </ul>
</nav>



<section id="board" class="container mt-5">
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
                        <th>Registered Day</th>
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
                            <th>Picture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

                <!-- Ticket Type Section -->
        <div id="ticketTypeSection" class="card mt-4">
            <div class="card-header bg-warning text-dark d-flex justify-content-between">
                <h3>Ticket Type Management</h3>
                <button class="btn btn-success" onclick="openTicketTypeModal()">Add Ticket Type</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="ticketTypeTable">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Price (€)</th>
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

        <div id="paidOrderSection" class="card mt-4">
        <div class="card-header bg-success text-white d-flex justify-content-between">
            <h3>Paid Orders</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="paidOrderTable">
                <thead class="thead-light">
                    <tr>
                        <th>Order ID</th>
                        <th>User Name</th>
                        <th>Order Date</th>
                        <th>Total</th>
                        <th>Actions</th> <!-- Only View Button -->
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div id="restaurantSection" class="card mt-4">
    <div class="card-header bg-info text-white d-flex justify-content-between">
        <h3>Restaurant Management</h3>
        <button class="btn btn-success" onclick="openAddRestaurantModal()">Add Restaurant</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="restaurantTable">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Cuisine</th>
                    <th>Description</th>
                    <th>Price Adult</th>
                    <th>Price Child</th>
                    <th>Picture</th>
                    <th>Dining Detail Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Restaurant Slot Section -->
<div id="restaurantSlotSection" class="card mt-4">
  <div class="card-header bg-warning text-dark d-flex justify-content-between">
    <h3>Restaurant Slot Management</h3>
    <button class="btn btn-success" onclick="openAddRestaurantSlotModal()">Add Slot</button>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped" id="restaurantSlotTable">
      <thead class="thead-light">
        <tr>
          <th>Slot ID</th>
          <th>Restaurant</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Capacity</th>
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
                <!-- Role Dropdown -->
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
                    <label for="artistName">Name</label>
                    <input type="text" class="form-control" id="artistName">
                </div>

                <!-- Style -->
                <div class="form-group">
                    <label for="artistStyle">Style</label>
                    <input type="text" class="form-control" id="artistStyle">
                </div>

                <!-- Description (KEEP Trix only here) -->
                <div class="form-group">
                    <label for="artistDescription">Description</label>
                    <input id="artistDescription" name="artistDescription" type="hidden">
                    <trix-editor input="artistDescription"></trix-editor>
                </div>

                <!-- Origin -->
                <div class="form-group">
                    <label for="artistOrigin">Origin</label>
                    <input type="text" class="form-control" id="artistOrigin">
                </div>

                <!-- Picture Upload -->
                <div class="form-group">
                    <label for="artistPicture">Picture</label>
                    <!-- ✅ Show preview of the old or new selected image -->
                    <div>
                        <img id="artistPreview" src="" alt="No Image" style="max-width:200px; display: block; margin-bottom: 10px;">
                    </div>
                    <input type="file" class="form-control" id="artistPicture" accept="image/*" onchange="previewArtistImage(event)">
                </div>

                <button class="btn btn-primary" id="saveArtistButton" onclick="saveArtist()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Type Modal -->
<div class="modal fade" id="ticketTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Ticket Type</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="ticketTypeID">

                <div class="form-group">
                    <label for="danceID">Location</label>
                    <select class="form-control" id="danceID">
                        <option value="">Select Location</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" class="form-control" id="type" placeholder="Type">
                </div>

                <div class="form-group">
                    <label for="price">Price (€)</label>
                    <input type="number" step="0.01" class="form-control" id="price" placeholder="Price">
                </div>

                <button class="btn btn-primary" onclick="saveTicketType()">Save</button>
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

<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">🧾 Order Details</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <!-- Export Buttons -->
        <div class="mb-3 text-end">
          <button class="btn btn-success btn-sm me-2" onclick="exportOrderDetailCSV()">⬇️ Export CSV</button>
          <button class="btn btn-info btn-sm" onclick="exportOrderDetailExcel()">📊 Export Excel</button>
        </div>

        <!-- Order Table -->
        <div id="orderDetailContent" class="table-responsive border rounded p-3 bg-light shadow-sm">
          <!-- Dynamically injected table from JS -->
        </div>  
      </div>

      <div class="modal-footer bg-light">
        <button class="btn btn-secondary"  data-dismiss="modal"  onclick="closeOrderDetailModal()">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Restaurant Modal -->
<div class="modal fade" id="restaurantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="restaurantModalTitle">Add Restaurant</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="restaurantID">

                <div class="form-group">
                    <label for="restaurantName">Name</label>
                    <input type="text" class="form-control" id="restaurantName">
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address">
                </div>

                <div class="form-group">
                    <label for="cuisine">Cuisine</label>
                    <input type="text" class="form-control" id="cuisine">
                </div>

                <!-- ✅ WYSIWYG Description -->
                <div class="form-group">
                    <label for="restaurantDescription">Description</label>
                    <input id="restaurantDescription" type="hidden">
                    <trix-editor input="restaurantDescription"></trix-editor>
                </div>

                <div class="form-group">
                    <label for="pricePerAdult">Price Per Adult (€)</label>
                    <input type="number" class="form-control" id="pricePerAdult">
                </div>

                <div class="form-group">
                    <label for="pricePerChild">Price Per Child (€)</label>
                    <input type="number" class="form-control" id="pricePerChild">
                </div>

                <!-- Main Picture -->
                <div class="form-group">
                    <label for="restaurantPicture">Main Picture</label>
                    <img id="previewRestaurant" src="" style="max-width: 200px; display: block; margin-bottom: 10px;">
                    <input type="file" class="form-control" id="restaurantPicture" name="picture" accept="image/*">
                </div>

                <!-- Dining Detail Picture -->
                <div class="form-group">
                    <label for="diningDetailPicture">Dining Detail Picture</label>
                    <img id="previewDiningDetail" src="" style="max-width: 200px; display: block; margin-bottom: 10px;">
                    <input type="file" class="form-control" id="diningDetailPicture" name="diningPicture" accept="image/*">
                </div>

                <button class="btn btn-primary" id="saveRestaurantButton" onclick="saveRestaurant()">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="restaurantSlotModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Add/Edit Restaurant Slot</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="slotID">

        <div class="form-group">
          <label for="restaurantID">Restaurant</label>
          <select class="form-control" id="restaurantSlotRestaurantID">
                <option value="">Select Restaurant</option>
            </select>
        </div>

        <div class="form-group">
          <label for="startTime">Start Time</label>
          <input type="time" class="form-control" id="startTime">
        </div>

        <div class="form-group">
          <label for="endTime">End Time</label>
          <input type="time" class="form-control" id="endTime">
        </div>

        <div class="form-group">
          <label for="capacity">Capacity</label>
          <input type="number" class="form-control" id="capacity" placeholder="Capacity">
        </div>

        <button class="btn btn-primary" onclick="saveRestaurantSlot()">Save</button>
      </div>
    </div>
  </div>
</div>







<script src="../../assets/js/adminDashboard.js"></script>
<link rel="stylesheet" href="../../assets/css/adminDashboard.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Export Excel -->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> 

<!-- Bootstrap JS & jQuery to display a modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once(__DIR__ . "/../partials/footer.php"); ?>
