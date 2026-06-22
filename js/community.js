console.log('community script running...');

let links = document.querySelectorAll('a');
console.log(links);

fetch('../../js/links.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        links[2].href = data.sm[0].inst
        links[3].href = data.sm[0].x
        links[4].href = data.sm[0].yt
        links[5].href = data.sm[0].telegram
        links[6].href = data.sm[0].email
        // Your logic for the links data goes here
    }) // Fixed the closing sequence here
    .catch(error => {
        console.error('There was a problem:', error);
    });