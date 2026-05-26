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
                location.href = '../controll/apiController.php?action=sc'
            }
        })
}

function theme() {
    console.log('change the styling function...')
    console.log(`you choose ${document.querySelector('.select-theme').value}`)
}

function changeMainVideo() {
    console.log('change video...')
      fetch('../js/links.json')
        .then(response => response.json())
        .then(data => {
            console.log(data.mainVideo)
           
        })

}

// event for call the function from the buttons


buttons[0].onclick = function () {
    if(document.querySelector('.select-links').value == 'socailMedai') {

        changeLinks()
    }else if(document.querySelector('.select-links').value == 'mainVideo') {
            changeMainVideo()
    }else {
        console.log('no structer insert...')
    }
}

buttons[1].onclick = function () {
    theme()
}