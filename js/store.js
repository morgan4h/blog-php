// this function it's generate the template we need for the data
function myAppTemplateFunction(myImage, myName, myType, myDown) {

  // 1️⃣ create main card
  const appCard = document.createElement('div');
  appCard.classList.add('app-card');

  // 2️⃣ create image
  const img = document.createElement('img');
  img.src = myImage;
  img.alt = myName;

  // 3️⃣ create title
  const h4 = document.createElement('h4');
  h4.textContent = myName;

  // 4️⃣ create type paragraph
  const p = document.createElement('p');
  p.textContent = myType;

  // 5️⃣ append elements into card
  appCard.appendChild(img);
  appCard.appendChild(h4);
  appCard.appendChild(p);

  // 6️⃣ append card into container
  try {
    // console.log(myName)
    const container = document.querySelector('.app-section .container');
    container.appendChild(appCard);
    appCard.onclick = function() {
      location.href = myDown
    }
  } catch (err) {
    console.log('Container not found or DOM error');
    console.error(err);
  }
}




let url = "http://localhost/s1/blog-php/controll/store.php"

fetch(url)
  .then(response => response.json())
  .then(data => {
    // console.log(data.data)
    let countingForTheObject = Object.keys(data.data).length;
    // console.log(Object.keys(data.data).length)
    let querySerach = location.search.slice(3);


    let found = false;

    for (let i = 0; i < countingForTheObject; i++) {
      if (querySerach === data.data[i].type) {
        myAppTemplateFunction(
          data.data[i].picture_app,
          data.data[i].name,
          data.data[i].type,
          data.data[i].download_link
        );
        found = true;
      }
    }

    if (!found) {
      myAppTemplateFunction(
        "https://www.nicepng.com/png/detail/135-1358116_error-png.png",
        "error",
        "tag not found",
        ""
      );
    }



  })
  .catch(error => console.error('Error:', error));



