<?php
	session_start();
	error_reporting(0);	
	include 'config.php';
	
	IF (isset($_SESSION['username'])=='') {
		header("location: Login.html");
	}
	$movie = $_GET["movie"];
	
?>

<!DOCTYPE html>
<html>
<head>
  <title>SEA CINEMA</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #222;
      color: #fff;
    }

     .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      padding: 20px;
      background: linear-gradient(to right, #222, #000);
      text-align: center;
    }
	
	  .nav-menu {
      list-style: none;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      margin-top: 10px;
    }

    .nav-menu li {
      margin: 0 10px;
    }

    .nav-menu a {
      text-decoration: none;
      color: #fff;
      opacity: 0.8;
      font-size: 14px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 10px 15px;
      border-radius: 20px;
      transition: opacity 0.3s ease;
    }

    .nav-menu a:hover {
      opacity: 1;
    }
    .navbar {
  padding: 10px 700px;
  margin-left: auto;
  
	}


    .navbar-brand {
      font-size: 24px;
      font-weight: bold;
      color: #fff;
    }

    .navbar-nav .nav-item {
      margin-right: 10px;
    }

    .navbar-nav .nav-link {
      font-size: 18px;
      color: #fff;
    }

    .navbar-nav.ml-auto {
    margin-left: auto;
  }

    .form-group {
      margin-bottom: 10px;
    }

    .seat-container {
      margin-bottom: 20px;
    }

    .seat-row {
      display: flex;
      justify-content: center;
      margin-bottom: 10px;
    }

    .seat {
      width: 40px;
      height: 40px;
      background-color: #ccc;
      margin-right: 10px;
      margin-bottom: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      color: #fff;
      font-weight: bold;
    }

    .seat.booked {
      background-color: #ff0000;
      cursor: not-allowed;
    }

    .payment-container {
      text-align: center;
    }

    .transaction-history {
      margin-top: 20px;
    }

    .transaction-history h2 {
      margin-bottom: 10px;
    }

    .transaction-item {
      margin-bottom: 5px;
      border: 1px solid #ddd;
      padding: 10px;
      background-color: #f7f7f7;
      color: #333;
    }

    .btn-primary {
      background-color: #007bff;
      color: #fff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-secondary {
      background-color: #6c757d;
      color: #fff;
      border-color: #6c757d;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
    }

    .btn-outline-primary {
      color: #007bff;
      border-color: #007bff;
    }

    .btn-outline-primary:hover {
      color: #fff;
      background-color: #007bff;
      border-color: #007bff;
    }
    .navbar-nav.ml-auto {
  margin-left: auto;
}
  </style>
</head>
<body>

    <header class="header">
      <nav>
        <ul class="nav-menu">
           <li><a href="movies.php">Movies</a></li>
        <li><a href="ticket.php">Tickets</a></li>
		  <li><a href="balance.php">Balances</a></li>
		  <li><a href="Theather.html">Theater</a></li>
		  <?php if (isset($_SESSION['username'])=='') {?>
        <li><a href="Login.html">Login</a></li>
		<?php } else { ?>
		 <li><a href="logout.php">Logout</a></li>
		<?php } ?>
        </ul>
      </nav>
     
    </header>
<div class="container">  
	<div class="form-group">
      <label for="title">Title:</label>
      <input type="text" id="title" value="<?php echo $movie; ?>" class="form-control" readonly="readonly">
    </div>
	
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" value="<?php echo $_SESSION['nama']; ?>" class="form-control" readonly="readonly">
	  <input type="hidden" id="iduser" value="<?php echo $_SESSION['id']; ?>" class="form-control" readonly="readonly">
    </div>

    <div class="form-group">
      <label for="age">Age:</label>
      <input type="number" id="age" value="<?php echo $_SESSION['umur']; ?>" class="form-control" readonly="readonly">
    </div>

    <div class="seat-container">
      <h2>Choose Your Seat(s):</h2>
      <div id="seats"></div>
    </div>

    <div class="payment-container">
      <h2>Payment</h2>
      <p>Total Amount: <span id="total-amount">0</span></p>
      <button id="payment-button" class="btn btn-primary">Pay</button>
      <button id="cancel-button" class="btn btn-secondary">Cancel</button>
    </div>

    <div class="transaction-history">
      <h2>Transaction History</h2>
      <div id="transaction-list"></div>
    </div>
  </div>
 
  <script type="text/javascript">
    // Seat Booking App
    const seatsContainer = document.getElementById('seats');
    const paymentButton = document.getElementById('payment-button');
    const cancelButton = document.getElementById('cancel-button');
    const transactionList = document.getElementById('transaction-list');
    const totalAmountElement = document.getElementById('total-amount');
    let seats = [];
    let selectedSeats = [];
    let balance = 100000; // Initial balance

    // Generate seats
    function generateSeats() {
      const rowSize = 8; // Number of seats in each row
      const numRows = 8; // Number of rows

      for (let i = 1; i <= numRows; i++) {
        const rowNumber = String.fromCharCode(64 + i); // Convert number to corresponding letter (A-H)
        let currentRow = document.createElement('div');
        currentRow.classList.add('seat-row');
        for (let j = 1; j <= rowSize; j++) {
          const seatNumber = `${rowNumber}${j}`; // Seat number in the format A1, A2, B1, B2, etc.
          const seat = document.createElement('div');
          seat.classList.add('seat', 'btn', 'btn-outline-primary');
          seat.textContent = seatNumber;
          currentRow.appendChild(seat);
          seats.push({
            id: seatNumber,
            element: seat,
            booked: false
          });
          seat.addEventListener('click', () => selectSeat(seatNumber));
        }
        seatsContainer.appendChild(currentRow);
        currentRow = document.createElement('div');
        currentRow.classList.add('seat-row');
      }
    }

    // Select a seat
    function selectSeat(seatId) {
      const seat = seats.find(seat => seat.id === seatId);
  if (!seat.booked) {
    const index = selectedSeats.indexOf(seatId);
    if (index === -1) {
      if (selectedSeats.length < 6) {
        selectedSeats.push(seatId);
        seat.element.classList.add('btn-primary');
      } else {
        alert('You can only book a maximum of 6 seats in one transaction.');
      }
    } else {
      selectedSeats.splice(index, 1);
      seat.element.classList.remove('btn-primary');
    }
    updateTotalAmount();
  }
}


    // Calculate and update total amount
    function updateTotalAmount() {
      const totalAmount = selectedSeats.length * 50000;
      totalAmountElement.textContent = totalAmount;
    }

    // Perform payment
    function performPayment() {
      if (selectedSeats.length === 0) {
        alert('Please select at least one seat.');
        return;
      }

      const title = document.getElementById('title').value;
	  const name = document.getElementById('name').value;
	  const iduser = document.getElementById('iduser').value;
      const age = parseInt(document.getElementById('age').value);
      if (age < 18) {
        alert('You are not eligible to watch this movie.');
        return;
      }

      if (totalAmountElement.textContent > balance) {
        const confirmTopUp = confirm('Insufficient balance. Do you want to top up your balance?');
        if (confirmTopUp) {
          const topUpAmount = parseInt(prompt('Enter the top-up amount (in Rupiah):'));
          if (!isNaN(topUpAmount) && topUpAmount > 0) {
            balance += topUpAmount;
            alert('Top-up successful!');
          } else {
            alert('Invalid top-up amount. Please try again.');
            return;
          }
        } else {
          alert('Payment cancelled.');
          return;
        }
      }

      balance -= totalAmountElement.textContent;
      const transaction = {
		iduser: iduser,  
		title: title,
        name: name,
        seats: selectedSeats,
        amount: totalAmountElement.textContent
      };
      selectedSeats.forEach(seatId => {
        const seat = seats.find(seat => seat.id === seatId);
        seat.booked = true;
        seat.element.classList.remove('btn-primary');
        seat.element.classList.add('booked', 'disabled');
      });
      selectedSeats = [];
      updateTotalAmount();
      updateTransactionHistory(transaction);
      alert('Payment successful!');
	  
	}

    // Cancel payment
    function cancelPayment() {
      selectedSeats.forEach(seatId => {
        const seat = seats.find(seat => seat.id === seatId);
        seat.booked = false;
        seat.element.classList.remove('btn-primary');
      });
      selectedSeats = [];
      updateTotalAmount();
      alert('Payment cancelled.');
    }
	
	
	
    // Update transaction history
    function updateTransactionHistory(transaction) {
		
      const transactionItem = document.createElement('div');
      transactionItem.classList.add('transaction-item');
      transactionItem.innerHTML = `
	    <p><strong>Title:</strong> ${transaction.title}</p>
        <p><strong>Name:</strong> ${transaction.name}</p>
        <p><strong>Seats:</strong> ${transaction.seats.join(', ')}</p>
        <p><strong>Amount:</strong> ${transaction.amount}</p>
      `;
      transactionList.appendChild(transactionItem);
		
    }
	
	

    // Initialize
    generateSeats();
    paymentButton.addEventListener('click', performPayment);
    cancelButton.addEventListener('click', cancelPayment);
  </script>
</body>
</html>
