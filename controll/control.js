

addEventListener("click", function (e) {
  console.log(e.target);
  if (e.target.alt == "project image") {
    // this.location.href = "../controll/routing.php?route=lp";
  } else if (e.target.alt == "blog") {
    this.location.href = "../controll/routing.php?route=blog";
  } else if (e.target.alt == "courses") {
    this.location.href = "../controll/routing.php?route=courses";
  } else if (e.target.alt == "Community") {
    this.location.href = "../controll/routing.php?route=community";
  } else {
    console.log("back to home page, can't find direction (:");
  }
});




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
    document.querySelector('nav .login').href = '../model/profile.html' 
  }else {
    console.log('not going to update anything at all')
  }
})
.catch(error => {
  console.error("Error:", error);
});
console.log('i see you (')