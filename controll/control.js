addEventListener("click", function (e) {
  // Safe check to ensure e.target exists before reading 'alt'
  if (!e.target) return;

  //console.log(e.target);
  if (e.target.alt == "project image") {
    // this.location.href = "../controll/routing.php?route=lp";
  } else if (e.target.alt == "blog") {
    this.location.href = "http://localhost/s1/blog-php/controll/routing.php?blog";
  } else if (e.target.alt == "courses") {
    this.location.href = "http://localhost/s1/blog-php/controll/routing.php?courses";
  } else if (e.target.alt == "Community") {
    this.location.href = "http://localhost/s1/blog-php/controll/routing.php?community";
  } else {
    //console.log("back to home page, can't find direction (:");
  }
});




// read the cookie and show the user profile

fetch("http://localhost/s1/blog-php/controll/checkLogin.php")
.then(response => {
  if (!response.ok) {
    throw new Error("Network response was not ok");
  }
  return response.json(); // parse JSON
})
.then(data => {
  //console.log(data.code); // use the data
  if(data.code == '200') {
    //console.log('update the login information')
    // Safe check: Only update if the login element exists in the DOM
    const loginElem = document.querySelector('nav .login');
    if (loginElem) {
      loginElem.textContent = data.username;
      loginElem.href = '../model/profile.html';
    }
  }else {
    //console.log('not going to update anything at all')
  }
})
.catch(error => {
  console.error("Error:", error);
});
//console.log('i see you (')


// Safe check: Prevent crash if no iframe is found on the page
try {
  const iframeElem = document.querySelector('iframe');
  if (iframeElem) {
    console.log(iframeElem.src);
  } else {
    console.log("No iframe found on this page.");
  }
} catch (err) {
  console.error("Error reading iframe:", err);
}


fetch("../js/links.json")
.then(response => {
  if (!response.ok) {
    throw new Error("Network response was not ok");
  }
  return response.json(); // parse JSON
})
.then(data => {
  console.log(data.mainVideo);
  // Safe check: Only assign source if iframe exists and data has mainVideo
  const iframeElem = document.querySelector('iframe');
  if (iframeElem && data && data.mainVideo) {
    iframeElem.src = data.mainVideo;
  }
})
.catch(error => {
  console.error("Error:", error);
});