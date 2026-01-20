console.log("hi == world");

// ⚠️ Use http unless you have SSL configured
const apiUrl = "http://localhost/blog-php/controll/store.php";

// Container
const appGrid = document.querySelector(".app-grid");

// Get type from URL (?t=web)
const params = new URLSearchParams(window.location.search);
const filterType = params.get("t"); // example: web, mobile

fetch(apiUrl)
  .then(response => {
    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }
    return response.json();
  })
  .then(result => {
    console.log("API result:", result);

    // Validate API response
    if (!result.success || !Array.isArray(result.data)) {
      throw new Error("Invalid API format");
    }

    const apps = result.data;

    appGrid.innerHTML = "";

    apps.reverse().forEach(app => {
      // Filter by type if provided
      if (filterType && app.type !== filterType) return;

      const card = document.createElement("div");
      card.className = "app-card";

      card.innerHTML = `
        <img src="${app.picture_app}" alt="${app.name} Icon">
        <h4>${app.name}</h4>
        <p>${app.category}</p>
        <a href="${app.download_link}" class="btn primary" target="_blank">
          Download
        </a>
      `;

      appGrid.appendChild(card);
    });

    if (appGrid.innerHTML === "") {
      appGrid.innerHTML = "<p>No apps found.</p>";
    }
  })
  .catch(error => {
    console.error("Fetch error:", error);
    appGrid.innerHTML = "<p>Failed to load apps.</p>";
  });
