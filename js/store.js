console.log('store.js');

// Replace with your actual API URL
const apiUrl = "http://localhost/server/blog/controll/store.php";

// Select the container where the app cards should go
const appGrid = document.querySelector(".app-grid");

// Fetch data from API
fetch(apiUrl)
  .then(response => {
    if (!response.ok) {
      throw new Error("Network response was not ok: " + response.statusText);
    }
    return response.json(); // Parse JSON data
  })
  .then(data => {
    // console.log("API data:", data);
    

    // Clear existing dummy content
    appGrid.innerHTML = "";

    // Loop through keys in the JSON (ignore the 'name' property)
    Object.keys(data).reverse().forEach(key => {
      if (!isNaN(key)) { // Only process numeric keys
          if(data[key].type == location.search.slice(3)) {
        const app = data[key];

        const card = document.createElement("div");
        card.classList.add("app-card");

        card.innerHTML = `
          <img src="${app.picture_app}" alt="${app.name} Icon">
          <h4>${app.name}</h4>
          <p>${app.category}</p>
          <a href="${app.download_link}" class="btn primary" target="_blank">Download</a>
        `;

        appGrid.appendChild(card);
          }
      }
    });
  })
  .catch(error => {
    console.error("Fetch error:", error);
    appGrid.innerHTML = "<p>Failed to load apps. Please try again later.</p>";
  });
