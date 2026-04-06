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




let url = "../../controll/store.php"

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
          data.data[i].description,
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




// read the cookie and show the user profile

fetch("https://sofiai4h-youtube.rf.gd/blog/controll/checkLogin.php")
.then(response => {
  if (!response.ok) {
    throw new Error("Network response was not ok");
  }
  return response.json(); // parse JSON
})
.then(data => {
  console.log(data.code); // use the data
  if(data.code == '200') {
    console.log('update the login information')
    document.querySelector('nav .login').textContent = data.username
    document.querySelector('nav .login').href = '../../model/profile.html' 
  }else {
    console.log('not going to update anything at all')
  }
})
.catch(error => {
  console.error("Error:", error);
});
console.log('i see you (')