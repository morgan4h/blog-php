

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

if (typeof (document.cookie) == 'string' && document.cookie.length > 4) {
  console.log('hello world')
  // location.href = '../model/profile.html'
  document.querySelector('.login').textContent = 'Profile'
  document.querySelector('.login').href = '../controll/routing.php?route=profile'
} else {
  console.log('this is not working well!')
}