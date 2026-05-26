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