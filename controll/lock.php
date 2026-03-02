<?php 

$passwrod = '1234';



?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Overlay</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Hidden checkbox (OPEN by default) */
#menu-toggle {
    display: none;
}

/* Page Content */
.content {
    padding: 60px;
    text-align: center;
}

/* Overlay Background */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.4s ease;
}



/* Menu Box */
.menu-box {
    background: white;
    padding: 40px;
    border-radius: 10px;
    width: 320px;
    text-align: center;
}

.menu-box h2 {
    margin-bottom: 20px;
}

.menu-box input {
    width: 100%;
    padding: 10px;
    margin-bottom: 25px;
    font-size: 16px;
}

/* Buttons */
.buttons {
    display: flex;
    justify-content: space-between;
}

.ok-btn {
    background: #28a745;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.close-btn {
    background: #dc3545;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
</style>
</head>

<body>

<!-- Checkbox is CHECKED by default -->
<input type="checkbox" id="menu-toggle" checked>

<div class="content">
    <h1>Welcome Admin</h1>
    <p>Uplaod new Apps From Here.</p>
</div>

<div class="overlay">
    <div class="menu-box">
        <h2>Enter Password</h2>
        <input class="ps" type="password" placeholder="Password">

        <div class="buttons">
            <!-- OK button (just visual here) -->
            <label class="ok-btn">OK</label>

            <!-- Close button -->
            <label for="menu-toggle" class="close-btn">Close</label>
        </div>
    </div>
</div>
<script>
   
    let codeP = document.querySelector('.ps')
    document.querySelector('.ok-btn').onclick = function() {
        console.log(codeP.value)
        if(codeP.value == '<?php echo $passwrod ?>') {
            console.log('right value!')
            document.querySelector('.overlay').style.display = 'none'
            localStorage.setItem('ps','good')
        }else {
            console.log('wrong value!')
        }
    }
    document.querySelector('.close-btn').onclick = function() {
        location.href = '../index.html'
    }
 
</script>
</body>
</html>
