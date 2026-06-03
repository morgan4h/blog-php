// let have here the buttons responsable on the functions

let buttons = document.querySelectorAll('button')

console.log(buttons)


// the functions

function changeLinks() {
    console.log('change the links function...')
    console.log(`you choose ${document.querySelector('.select-links').value}`)
    // console.log(document.querySelector('.select-links'))

    fetch('../js/links.json')
        .then(response => response.json())
        .then(data => {
            const linksObj = data.sm[0];
            const container = document.querySelector('.res');

            // Clear previous inputs so they don't stack up every click
            container.innerHTML = '';

            // Iterate through each key-value pair in the object
            Object.entries(linksObj).forEach(([key, value]) => {
                let inputname = document.createElement('input');
                // Set the value from the API
                inputname.value = value;

                // Optional: Set a placeholder or name based on the key
                inputname.placeholder = key;
                inputname.name = key;

                container.appendChild(inputname);
                console.log(`Created input for ${key} with value: ${value}`);
            });
            let btnRes = document.createElement('button')
            btnRes.setAttribute('class', 'resButton');
            btnRes.textContent = 'change values'
            document.querySelector('.res').appendChild(btnRes)
            btnRes.onclick = function () {
                document.querySelectorAll('.res input').forEach(input => {
                    data[input.name] = input.value;
                });

                fetch('../controll/apiController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'action': 'sc'
                    },
                    body: JSON.stringify(data)
                })
                    .then(res => res.text())
                    .then(res => {
                        console.log(res);
                        alert(res);
                    })
                    .catch(err => console.error(err));

            }
        })
}


function changeMainVideo() {
    console.log('change video...');

    fetch('../js/links.json')
        .then(response => response.json())
        .then(data => {

            const container = document.querySelector('.res');
            container.innerHTML = '';

            // current main video value
            const currentVideo = data.mainVideo;

            // create input
            let input = document.createElement('input');
            input.value = currentVideo;
            input.placeholder = "Main Video Link";
            input.name = "mainVideo";

            container.appendChild(input);

            // button to save
            let btn = document.createElement('button');
            btn.className = 'resButton';
            btn.textContent = 'Update Main Video';

            container.appendChild(btn);

            btn.onclick = function () {

                const newVideoLink = input.value;

                const payload = {
                    mainVideo: newVideoLink
                };

                fetch('../controll/apiController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Action': 'mainVideo'   // ✅ THIS is your tag header
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.text())
                .then(res => {
                    console.log(res);
                    alert(res);
                })
                .catch(err => console.error(err));
            };
        });
}
// event for call the function from the buttons


buttons[0].onclick = function () {
    if (document.querySelector('.select-links').value == 'socailMedai') {

        changeLinks()
    } else if (document.querySelector('.select-links').value == 'mainVideo') {
        changeMainVideo()
    } else {
        console.log('no structer insert...')
    }
}

