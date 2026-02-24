<?php



function checkIfItLogin($coki) {
    if(empty($coki)) {
        // echo "it's empty";
    }else {
        if(gettype($coki) == NULL) {
            echo "sorry this is unvalid cockie";
        }else if (gettype($coki) == "string") {
            // echo "this is valid cockie";
            // echo "<br>";
            // echo $coki;
              include_once "../model/profile.html";
        }
    }
}

checkIfItLogin(@$_COOKIE['catchingLogin']);

?>

<script>
    let name = document.querySelector('.profile-name')
    let email = document.querySelector('.about')
    name.textContent = '<?php echo $_COOKIE["catchingLogin"]?>'.slice(0,4) 
    email.textContent = '<?php echo $_COOKIE["catchingLogin"]?>'
   
</script>