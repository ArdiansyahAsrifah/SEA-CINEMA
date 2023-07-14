<?php
	session_start();
		include 'cek_login.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title>SEA CINEMA</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  <link href="https://fonts.googleapis.com/css?family=Dosis:400,700" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #1b211d;
      color: #fff;
      
    }
    .header {
      padding: 20px;
      background-color: #1db954;
      text-align: center;
    }
    .film-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 20px;
    }
    .film-card {
      width: 200px;
      margin: 10px;
      padding: 10px;
      background-color: #222;
      border-radius: 5px;
    }
    .film-card img {
      width: 100%;
      height: auto;
      border-radius: 3px;
    }
    .film-card h3 {
      margin-top: 10px;
      margin-bottom: 5px;
      font-size: 16px;
      font-weight: bold;
    }
    .film-card p {
      margin: 0;
      font-size: 14px;
      opacity: 0.8;
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

    .popular-films {
      width: calc(100% - 100px);
      max-width: 1200px;
      margin: 0 auto;
      float: center;
    }
    .watch-button {
      background-color: #1db954;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .watch-button:hover {
      background-color: #1ed760;
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

  <div class="popular-films">
    <div class="slider" id="slider" ></div>
  </div>

  <script>
    function getMovie() {
      let dataMovie = "";
      fetch('https://seleksi-sea-2023.vercel.app/api/movies')
        .then(response => response.json())
        .then(data => {
          data.forEach(function(item) {
            const movieCard = `
              <div class="card">
                <img src="${item.poster_url}" alt="${item.title}" style="max-width: 200px; max-height: 300px;">
                <div class="card-content">
                  <h1>${item.title}</h1>
                  <p>Age Rating: ${item.age_rating}</p>
                  <p>${item.description}</p>
                  <p>Release Date: ${item.release_date}</p>
                  <h2>Ticket Price: ${item.ticket_price}</h2>
                  <button class="watch-button" onclick="goToTicket('${item.title}')">Watch</button>
                </div>
              </div>
            `;
            dataMovie += movieCard;
          });

          document.getElementById("slider").innerHTML = dataMovie;
        })
        .catch(err => {
          console.log(err);
        });
    }

    function goToTicket(movieTitle) {
      window.location.href = "ticket.php?movie=" + encodeURIComponent(movieTitle);
    }

    document.addEventListener("DOMContentLoaded", function() {
      getMovie();
    });
  </script>

  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
  <!-- Slick JS -->    
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.slider').slick({
        autoplay: true,
        autoplaySpeed: 2500,
        dots: true
      });
    });
  </script>
</body>
</html>
