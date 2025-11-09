// console.log('listening...')

// fetch the latest video you publish on youtube and present it in the right place

function fetchLatestVideo() {
  const API_KEY = "AIzaSyAQdouvy26ZE6TlBv4rV6Nq56TtwhFJ-28"; // Replace with your YouTube API Key
  const CHANNEL_ID = "UCYGFlVh_W9nu7OC0yP_XlBQ"; // MrBeast's Channel ID

  const BASE_URL = "https://www.googleapis.com/youtube/v3/";

  // Function to get the latest video from a channel
  function getLatestVideoFromChannel(channelId) {
    const url = `${BASE_URL}search?part=snippet&channelId=${channelId}&order=date&maxResults=1&key=${API_KEY}`;

    return fetch(url)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        const video = data.items[0].snippet;
        const videoId = data.items[0].id.videoId;
        const title = video.title;
        const thumbnailUrl = video.thumbnails.high.url;
        const videoUrl = `https://www.youtube.com/watch?v=${videoId}`;

        return { title, thumbnailUrl, videoUrl };
      })
      .catch((error) => console.error("Error fetching video data:", error));
  }

  // Get the latest video and log its details
  getLatestVideoFromChannel(CHANNEL_ID).then((video) => {
    // Log the latest video details
    // console.log("Title:", video.title);
    // console.log("Thumbnail URL:", video.thumbnailUrl);
    console.log("Video URL:", video.videoUrl);
    document.querySelector("header h2").textContent = video.title;
    document.querySelector("header img").src = video.thumbnailUrl;
    document.querySelector("header img").onclick = function () {
      location.href = video.videoUrl;
    };
  });
}

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

fetchLatestVideo();
