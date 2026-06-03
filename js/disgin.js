console.log('start controll the ui...')



fetch('http://localhost/s1/blog-php/js/disgin.json')
  .then(response => {
    if (!response.ok) throw new Error('Network response was not ok');
    return response.json();
  })
  .then(data => {
    // 3. Use your data!
    console.log(data);
    document.querySelector('nav').innerHTML = data.nav

  })
  .catch(error => console.error('Error fetching theme:', error));


fetch('http://localhost/s1/blog-php/js/disgin.json')
  .then(response => {
    if (!response.ok) throw new Error('Network response was not ok');
    return response.json();
  })
  .then(st => {
    // 3. Use your data!
    document.body.style.color = st.styling[0].theme
    document.body.style.background = st.styling[0].backgroun
    // console.log(`this is the data ${JSON.stringify()}`)
    // console.log(st.styling[0])

  })
  .catch(error => console.error('Error fetching theme:', error));




function theme() {
  let theOption = document.querySelector('.select-theme').value;

  fetch('../js/disgin.json')
    .then(res => res.json())
    .then(styling => {

      if (theOption == 'color') {

        let pop1 = prompt(
          'what color you want for the site (html code #ffffff or rgb(0,0,0))'
        );

        fetch('../controll/apiController.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Action': 'styling'
          },
          body: JSON.stringify({
            styling: true,
            theme: pop1
          })
        })
          .then(res => res.text())
          .then(res => {
            console.log(res);
            alert(res);
          })
          .catch(err => console.error(err));
      }

      if (theOption == 'themeDarkLight') {

        let pop1 = prompt(
          'what background color do you want?'
        );

        fetch('../controll/apiController.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Action': 'styling'
          },
          body: JSON.stringify({
            styling: true,
            background: pop1
          })
        })
          .then(res => res.text())
          .then(res => {
            console.log(res);
            alert(res);
          })
          .catch(err => console.error(err));
      }

    });
}
buttons[1].onclick = function () {
  theme()
}