<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Ticket Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/employeeTicket.css">
  <script src="../../assets/js/employeeTicket.js"></script>
</head>
<body>

<div class="container mt-4">
  <div class="header-box text-center">
    <h2><i class="fa-solid fa-ticket fa-lg me-2 text-warning"></i>Employee Ticket Dashboard</h2>
    <p class="mb-0">View, filter, and manage tickets for all users</p>
  </div>

  <div class="text-center mb-4">
    <input type="text" id="searchInput" class="form-control d-inline-block" placeholder="🔍 Search by username..." oninput="loadTickets(this.value)">
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center shadow-sm bg-white rounded">
      <thead>
        <tr>
          <th>User Name</th>
          <th>Location</th>
          <th>Ticket Type</th>
          <th>Price</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="ticketTableBody">
        <!-- Tickets will be inserted here -->
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
