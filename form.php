<?php

function senitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$allowsgenders = ["male","female","others"];
$allowedskills = ["php","java","python"];
hbkhb
$countries = [
    "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria",
    "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan",
    "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia",
    "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo (Congo-Brazzaville)", "Costa Rica",
    "Croatia", "Cuba", "Cyprus", "Czechia", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador",
    "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France",
    "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau",
    "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland",
    "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan",
    "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar",
    "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia",
    "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal",
    "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan",
    "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar",
    "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia",
    "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
    "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan",
    "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu",
    "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela",
    "Vietnam", "Yemen", "Zambia", "Zimbabwe"];


if(isset($_POST['signup'])){
    $username= $_POST['username'];
    $userEmail=$_POST['userEmail'];
    $gender=$_POST['gender'] ?? null;
    $skills=$_POST['skills'] ?? [];
    $country=$_POST['country'] ?? null;
    $password=$_POST['password'] ?? null;


    //For User Name
if(empty($username)){
    $errorname= "<span style='color:red'>Name is required </span>";
}

elseif(!preg_match("/^[A-Za-z,\- ]*$/", $username)){
    $errorname= "<span style='color:red'>Only letters and white space allowed </span>";
}
elseif(strlen($username)<3){ //preg_match na use korea o strlen use kora jai
    $errorname= "<span style='color:red'>Name must be greater than 3 characters </span>";
}

else{
    $correctname=senitize($username);
}


//For User Email
if(empty($userEmail)){
    $erroremail= "<span style='color:red'>Email is required </span>";

}
elseif(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
    $erroremail= "<span style='color:red'>Invalid email format </span>";
}
else{
    $correctemail=senitize($userEmail);

}


//For gender

if(empty($gender)){
    $errorgender= "<span style='color:red'>Please select your gender </span>";

}
elseif(!in_array($gender, $allowsgenders)){
    $errorgender= "<span style='color:red'>Invalid gender </span>";

}
else{
    $correctgender=senitize($gender);
}


//For Skills

if(count($skills) == 0){
    $errorskills= "<span style='color:red'>Please select at least 1 skills </span>";

}
else{
    foreach($skills as $skill){
        if(!in_array($skill, $allowedskills)){
            $errorskills="<span style='color:red'>Invalid skills</span>";
            $correctskills=[];
            break;
        }
        else{
            $correctskills[]=senitize($skill);
    }
}

}


//For Country

if(empty($country)){
    $errorCountry ="<span style='color:red'>Please Select your country</span>";
}
elseif(!in_array($country, $countries)){
    $errorCountry ="<span style='color:red'>Invalid Country</span>";
}
else{
    $correctCountry=senitize($country);
    
}

//For Password

if(empty($password)){
    $errorpassword= "<span style='color:red'>Password is required </span>";

}
elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*?])[A-Za-z\d!@#$%^&*?]{8,}$/", $password)) {
    $errorpassword = "<span style='color:red'>Please provide a strong password </span>";
} 
else{
    $correctpassword=senitize($password);


} 

if(isset($correctname)&& isset($correctemail)&& isset($correctgender)&& count($correctskills)>0 && isset($correctCountry)&& isset($correctpassword)){
    $showData="Name: $correctname<br> Email:$correctemail <br> Gender:$correctgender <br> skills:".implode(",",$correctskills)."<br> Country:$correctCountry <br> Password: ".password_hash($correctpassword, PASSWORD_DEFAULT);
    $username=$userEmail=$gender=$skills=$country=$password=null;

    $correctname=$correctemail=$correctgender=$correctskills=$correctCountry=$correctpassword=null;
}

}

?>
<h2> Registration Form </h2>

<form action="" method="POST">
    User Name: 
    <input type="text" placeholder="Enter Your Name" name="username" value="<?=$username ?? null ?>">
    <?php echo $errorname ?? null ?> 
    <br><br>

    User Email:
    <input type="text" placeholder="Enter Your Email" name="userEmail" value="<?=$userEmail ?? null?>">
    <?= $erroremail ?? null ?>
    <br><br>

    Gender:
    <input type="radio" value="male" name="gender" <?=isset($gender) && $gender=="male" ? "checked": null ?> /> Male 
    <input type="radio" value="female" name="gender" <?=isset($gender) && $gender=="female" ? "checked": null ?> /> Female 
    <input type="radio" value="others" name="gender" <?=isset($gender) && $gender=="others" ? "checked": null ?> /> Others
    <?= $errorgender ?? null ?>
    <br><br>

    Skills:
    <input type="checkbox" value="php" name="skills[]" <?= isset($skills) && in_array("php",$skills) ? "checked" : null ?> /> PHP 
    <input type="checkbox" value="java" name="skills[]"  <?= isset($skills) && in_array("java",$skills) ? "checked" : null ?> /> Java
    <input type="checkbox" value="python" name="skills[]"  <?= isset($skills) && in_array("python",$skills) ? "checked" : null ?>/> Python
    <?= $errorskills ?? null ?>
    <br><br>

    Country:
    <select name="country">
        <option value="">Select Country </option>
        <?php foreach($countries as $city){ ?>
            <option value="<?= $city ?>" <?= isset($country) && $country == $city ? "selected" : null ?> ><?= $city ?></option>
        <?php } ?>
    
        
</select>
<?= $errorCountry ?? null ?>
<br><br>

Password:
<input type="password" placeholder="Enter Your Password" name="password">
<?= $errorpassword ?? null ?>
<br><br>

<button type="submit" name="signup">Sign Up</button>

</form>

<div style="color:red">
<?= $showData ?? NULL ?>
  </div>