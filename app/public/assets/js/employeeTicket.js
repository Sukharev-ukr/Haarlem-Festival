function loadTickets(username = '') {
    fetch(`/api/employee/tickets?username=${username}`)
      .then(res => res.json())
      .then(data => {
        const tbody = document.getElementById("ticketTableBody");
        tbody.innerHTML = '';
  
        data.data.forEach(ticket => {
          const row = `<tr>
            <td>${ticket.userName}</td>
            <td>${ticket.location}</td>
            <td>${ticket.ticketType}</td>
            <td>€${parseFloat(ticket.price).toFixed(2)}</td>
            <td><span class="status-badge badge ${ticket.status === 'USED' ? 'badge-danger' : 'badge-success'}">${ticket.status}</span></td>
            <td>
              ${ticket.status === 'UNUSED' 
                ? `<button class="btn btn-sm btn-warning" onclick="markUsed(${ticket.danceTicketID})">Mark as USED</button>`
                : `<i class="fa fa-check-circle text-success fs-5"></i>`}
            </td>
          </tr>`;
          tbody.innerHTML += row;
        });
      });
  }
  
  function markUsed(id) {
    fetch('/api/employee/ticket/update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ danceTicketID: id, status: 'USED' })
    })
    .then(res => res.json())
    .then(() => loadTickets(document.getElementById("searchInput").value));
  }
  
  document.addEventListener("DOMContentLoaded", () => loadTickets());