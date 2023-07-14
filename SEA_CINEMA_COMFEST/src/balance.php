<?php
	session_start();
		include 'cek_login.php';

?>
<!DOCTYPE html>
<html>
<head>
  <title>Mobile Banking</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #161616;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .balance {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .balance-label {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .balance-amount {
      font-size: 24px;
      font-weight: bold;
      color: #4caf50;
    }

    .transaction-history {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
    }

    .transaction-history-header {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .transaction-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .transaction-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .transaction-item .transaction-type {
      font-weight: bold;
    }

    .transaction-item .transaction-amount {
      color: #4caf50;
      font-weight: bold;
    }

    .transaction-item .transaction-date {
      color: #999;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    .btn:hover {
      background-color: #45a049;
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

    .header-title {
        color:white;
    }
	.header {
      padding: 20px;
      background: linear-gradient(to right, #222, #000);
      text-align: center;
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
	 <h1 class="header-title">Your Balance</h1>
    <div class="balance">
      <div class="balance-label">Current Balance:</div>
      <div class="balance-amount" id="balance-amount">0</div>
    </div>

    <div class="transaction-history">
      <div class="transaction-history-header">Transaction History</div>
      <ul class="transaction-list" id="transaction-list">
        <!-- Transaction items will be dynamically added here -->
      </ul>
    </div>

    <a href="#" class="btn" onclick="topUp()">Top Up</a>
    <a href="#" class="btn" onclick="withdraw()">Withdraw</a>
  </div>

  <script>
    var balance = 0;
    var transactionHistory = [];

    function updateBalance() {
      var balanceElement = document.getElementById('balance-amount');
      balanceElement.textContent = balance.toLocaleString('id-ID');
    }

    function updateTransactionHistory() {
      var transactionList = document.getElementById('transaction-list');
      transactionList.innerHTML = '';

      transactionHistory.forEach(function(transaction) {
        var transactionItem = document.createElement('li');
        transactionItem.classList.add('transaction-item');

        var transactionType = document.createElement('span');
        transactionType.classList.add('transaction-type');
        transactionType.textContent = transaction.type;

        var transactionAmount = document.createElement('span');
        transactionAmount.classList.add('transaction-amount');
        transactionAmount.textContent = transaction.amount.toLocaleString('id-ID');

        var transactionDate = document.createElement('span');
        transactionDate.classList.add('transaction-date');
        transactionDate.textContent = transaction.date;

        transactionItem.appendChild(transactionType);
        transactionItem.appendChild(transactionAmount);
        transactionItem.appendChild(transactionDate);

        transactionList.appendChild(transactionItem);
      });
    }

    function addTransaction(type, amount) {
      var date = new Date().toLocaleString();
      var transaction = {
        type: type,
        amount: amount,
        date: date
      };
      transactionHistory.push(transaction);
      updateTransactionHistory();
    }

    function topUp() {
      var amount = parseFloat(prompt('Enter the top-up amount (in Rupiah):'));
      if (isNaN(amount) || amount < 0) {
        alert('Invalid amount. Please enter a valid number.');
      } else {
        balance += amount;
        updateBalance();
        addTransaction('Top Up', amount);
        alert('Top-up successful!');
      }
    }

    function withdraw() {
        var withdrawAmount = parseFloat(prompt('Enter the withdrawal amount (in Rupiah):'));
        if (isNaN(withdrawAmount) || withdrawAmount < 0) {
            alert('Invalid amount. Please enter a valid number.');
        } else if (withdrawAmount > 500000) {
            alert('Withdrawal amount exceeds the maximum limit. Maximum limit: 500,000 Rupiah');
        } else if (withdrawAmount < 50000) {
            alert('Minimum Withdrawal amount is 50,000 Rupiah')
        } else if (withdrawAmount > balance) {
            alert('Insufficient balance. Unable to withdraw.');
        } else {
            balance -= withdrawAmount;
            updateBalance();
            addTransaction('Withdrawal', withdrawAmount);
            alert('Withdrawal successful! Amount: ' + withdrawAmount.toLocaleString('id-ID') + ' Rupiah');
        }
    }


    updateBalance();
  </script>
</body>
</html>