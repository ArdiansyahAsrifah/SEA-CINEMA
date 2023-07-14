const app = document.getElementById('root');

const container = document.createElement('div');
container.setAttribute('class', 'container');

app.appendChild(container);

var request = new XMLHttpRequest();
request.open('GET', 'https://seleksi-sea-2023.vercel.app/api/movies', true);
request.onload = function () {
  // Begin accessing JSON data here
  var data = JSON.parse(this.response);
  if (request.status >= 200 && request.status < 400) {
    data.forEach(movie => {
      const card = document.createElement('div');
      card.setAttribute('class', 'card');

      const logo = document.createElement('img');
      logo.src = movie.poster_url;

      const title = document.createElement('h2');
      title.textContent = movie.title;

      const description = document.createElement('p');
      description.textContent = movie.description;

      const releaseDate = document.createElement('p');
      releaseDate.textContent = 'Release Date: ' + movie.release_date;

      const ageRating = document.createElement('p');
      ageRating.textContent = 'Age Rating: ' + movie.age_rating;

      container.appendChild(card);
      card.appendChild(logo);
      card.appendChild(title);
      card.appendChild(description);
      card.appendChild(releaseDate);
      card.appendChild(ageRating);
    });
  } else {
    const errorMessage = document.createElement('marquee');
    errorMessage.textContent = `Gah, it's not working!`;
    app.appendChild(errorMessage);
  }
}

request.send();
