// Fonction pour charger le flux RSS et afficher les articles
function appelRss() {
  const rssUrl = "./horoscope.php";
  fetch(rssUrl)
    .then((response) => response.json())
    .then((data) => {
      displayRssFeed(data);
    })
    .catch((error) => {
      console.error("Erreur:", error);
    });
}

// Fonction pour afficher les articles du flux RSS
function displayRssFeed(data) {
  const feedContainer = document.getElementById("rss-feed");
  if (!feedContainer) {
    console.error('Element with id "rss-feed" not found.');
    return;
  }

  feedContainer.innerHTML = ""; // Efface le contenu existant au cas où

  const items = data.channel.item;
  if (!items) {
    feedContainer.innerHTML = "<p> Aucun article trouvé. </p>";
    return;
  }

  items.forEach((item) => {
    const itemLi = document.createElement("li");
    itemLi.classList.add("rss-item");

    const descriptionDiv = document.createElement("div");
    descriptionDiv.innerHTML = item.description;

    const img = descriptionDiv.querySelector("img");
    if (img) {
      const imgElement = document.createElement("img");
      imgElement.src = img.getAttribute("data-src") || img.getAttribute("src");
      itemLi.appendChild(imgElement);
    }

    const contentDiv = document.createElement("div");
    contentDiv.classList.add("rss-item-content");

    const title = document.createElement("h3");
    title.innerHTML = `<a href="${item.link}" target="_blank">${item.title}</a>`;
    contentDiv.appendChild(title);

    const description = document.createElement("p");
    description.textContent = descriptionDiv.textContent;
    contentDiv.appendChild(description);

    if (descriptionDiv.textContent.length > 100) {
      const readMore = document.createElement("div");
      readMore.classList.add("read-more");
      readMore.innerHTML = `<a href="${item.link}" target="_blank">En savoir plus</a>`;
      contentDiv.appendChild(readMore);
    }

    itemLi.appendChild(contentDiv);
    feedContainer.appendChild(itemLi);
  });
}
