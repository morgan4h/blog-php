
fetch('https://sofiai4h-youtube.rf.gd/blog/dash/content.json')
    .then(function (response) {
        // Check if the request was successful
        if (response.ok) {
            return response.json();
        }
        throw new Error('Something went wrong');
    })
    .then(function (data) {
        // Use the data here
        console.log("User page:", data.pagename);
        document.title = data.pagename
        console.log("User change:", data.change);
        document.querySelector('iframe').src = data.change
    })
    .catch(function (error) {
        // Handle any errors (network or logic)
        console.error("Error:", error);
    });
    