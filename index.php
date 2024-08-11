<?php
$title = "PhoneBook";
include "include.php";
?>

<body class="container">
  <h1>Phonebook</h1>

  <div class="col-md-6 p-2 mt-4">
    <h4>Add Contact</h4>
    <input type="text" id="phone" placeholder="Enter phone number" class="form-control p-2">
    <input type="text" id="name" placeholder="Enter name" class="form-control p-2">
    <input type="email" id="email" placeholder="Enter Email" class="form-control p-2">
    <input type="text" id="address" placeholder="Enter address" class="form-control p-2">
    <button onclick="submitContact()" class="btn btn-secondary">Submit</button>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="p-2 mt-4">
        <h4>Search (Using Name)</h4>
        <div>
          <input type="text" id="search_name" class="form-control" placeholder="Enter phone number">
          <button onclick="searchName()" class="btn btn-secondary">Search</button>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="p-2 mt-4">
        <h4>Search (Using Contact)</h4>
        <div>
          <input type="text" id="search_phone" placeholder="Enter phone number" class="form-control">
          <button onclick="searchContact()" class="btn btn-secondary">Search</button>
        </div>
      </div>
    </div>
  </div>


  <div class="mt-4">
    <h4>Search Results</h4>
    <table class="table table-striped table-bordered" id="search_results_table" style="display: none;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Phone</th>
          <th>Name</th>
          <th>Email</th>
          <th>Address</th>
        </tr>
      </thead>
      <tbody id="search_results_body">
      </tbody>
    </table>
  </div>


  <script>
    function searchContact() {
      const phone = document.getElementById('search_phone').value;

      if (!phone) {
        alert('Please enter a phone number.');
        return;
      }

      sendRequest("search.php", "phone=" + encodeURIComponent(phone), function (response) {
        const results = JSON.parse(response);
        if (results.status === "no_results") {
          alert(results.message);
        } else {
          populateSearchResultsTable(results);
        }
      });
    }

    function searchName() {
      const name = document.getElementById('search_name').value;

      if (!name) {
        alert('Please enter a Name.');
        return;
      }

      sendRequest("name.php", "name=" + encodeURIComponent(name), function (response) {
        const results = JSON.parse(response);
        if (results.status === "no_results") {
          alert(results.message);
        } else {
          populateSearchResultsTable(results);
        }
      });
    }

    function populateSearchResultsTable(results) {
      const table = document.getElementById('search_results_table');
      const tbody = document.getElementById('search_results_body');
      tbody.innerHTML = ''; // Clear existing rows

      results.forEach(result => {
        const row = document.createElement('tr');
        row.innerHTML = `
                <td>${result.id}</td>
                <td>${result.phone}</td>
                <td>${result.name}</td>
                <td>${result.email}</td>
                <td>${result.address}</td>
            `;
        tbody.appendChild(row);
      });

      table.style.display = 'table'; // Show the table
    }

    function submitContact() {
      const phone = document.getElementById('phone').value;
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const address = document.getElementById('address').value;

      if (!phone || !name || !email || !address) {
        alert('Please fill in all fields.');
        return;
      }

      const data = "phone=" + encodeURIComponent(phone) +
        "&name=" + encodeURIComponent(name) +
        "&email=" + encodeURIComponent(email) +
        "&address=" + encodeURIComponent(address);

      sendRequest("submit.php", data, function (response) {
        alert('Contact submitted successfully. ID: ' + response);
      });
    }

    function sendRequest(url, data, callback) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            callback(xhr.responseText);
          } else {
            alert('An error occurred: ' + xhr.statusText);
          }
        }
      };
      xhr.send(data);
    }
  </script>
</body>

</html>