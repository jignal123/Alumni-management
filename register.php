<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (
  isset($_SESSION['admin'])
) {
  header("Location: admin/index.php");
}
if (
isset($_SESSION["alumni"])
) {
  header("Location: student/index.php");
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./admin/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <script src="jquery.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <title>Register</title>
</head>

<body>
  <div class="loader">
  </div>
  <div class="navi">
    <nav class="d-flex pt-2 pb-1">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-1">
          <img src="./admin/logo.jpg" alt="" class="pb-1" style="height: 50px;"></div>
          <div class="col-4">
            <h1 class="pt-1">Alumni Portal</h1>
          </div>
          <div class="nav col-7 justify-content-end">
            <ul class="d-flex flex-row pt-2">
              <li><a href="login.php" class="me-2">Login</a></li>
              <li><a href="" class="active me-2" style="color:aliceblue">signup</a></li>
              <li><a href="events.php">Events</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="regtr mt-5">
    <div class="container">
      <div class="row mt-1">
        <div class="col-md-12 d-flex justify-content-center al">
          <div class="title mt-3 mb-2">
            <h2 class="text-uppercase"> Alumni Registration form</h2>
          </div>
        </div>
      </div>
      <form action="" method="post" id="myform" class="row mt-1 p-2">
        <div class="col-md-4">
          <label for="fnm" class="form-label">First Name</label>
          <div class="input-field">
            <input type="text" name="fnm" id="fnm" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="lnm" class="form-label">Last Name</label>
          <div class="input-field">
            <input type="text" name="lnm" id="lnm" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="gender" class="form-label">Gender</label>
          <div class="input-field">
            <select class="form-select" name="gender" id="gender">
              <option value="" selected disabled>select-gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="birth" class="form-label">Birth Date</label>
          <div class="input-field">
            <input type="date" name="birth" id="birth" class="form-control" max="2006-12-31">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex"></span>
          </div>
        </div>
        <div class="col-md-4">
          <lable for="country" class="form-label">State</lable>
          <div class="input-field">
            <select name="state" id="state" class="form-select mt-2">
              <option value="">Select-state</option>
              <option value="Andra Pradesh">Andra Pradesh</option>
              <option value="Arunachal Pradesh">Arunachal Pradesh</option>
              <option value="Assam">Assam</option>
              <option value="Bihar">Bihar</option>
              <option value="Chhattisgarh">Chhattisgarh</option>
              <option value="Goa">Goa</option>
              <option value="Gujarat">Gujarat</option>
              <option value="Haryana">Haryana</option>
              <option value="Himachal Pradesh">Himachal Pradesh</option>
              <option value="Jammu and Kashmir">Jammu and Kashmir</option>
              <option value="Jharkhand">Jharkhand</option>
              <option value="Karnataka">Karnataka</option>
              <option value="Kerala">Kerala</option>
              <option value="Madya Pradesh">Madya Pradesh</option>
              <option value="Maharashtra">Maharashtra</option>
              <option value="Manipur">Manipur</option>
              <option value="Meghalaya">Meghalaya</option>
              <option value="Mizoram">Mizoram</option>
              <option value="Nagaland">Nagaland</option>
              <option value="Orissa">Orissa</option>
              <option value="Punjab">Punjab</option>
              <option value="Rajasthan">Rajasthan</option>
              <option value="Sikkim">Sikkim</option>
              <option value="Tamil Nadu">Tamil Nadu</option>
              <option value="Telangana">Telangana</option>
              <option value="Tripura">Tripura</option>
              <option value="Uttaranchal">Uttaranchal</option>
              <option value="Uttar Pradesh">Uttar Pradesh</option>
              <option value="West Bengal">West Bengal</option>
              <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
              <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
              <option value="Chandigarh">Chandigarh</option>
              <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
              <option value="Daman and Diu">Daman and Diu</option>
              <option value="Delhi">Delhi</option>
              <option value="Lakshadeep">Lakshadeep</option>
              <option value="Pondicherry">Pondicherry</option>
            </select>
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <lable for="country" class="form-label">City</lable>
          <div class="input-field">
            <select name="city" id="city" class="form-select mt-2">
              <option value="">Select-City</option>
            </select>
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-12">
          <div class="input-field">
            <lable for="address" class="form-label">Address</lable>
            <textarea name="address" id="address" class="form-control">
            </textarea>
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="course" class="form-label">Course</label>
          <div class="input-field">
            <select name="course" id="course" class="form-select">
              <option value="" selected disabled>select-course</option>
              <?php
              include("dbconfig.php");
              $q = "SELECT * FROM course_master";
              $r = query($q);
              $ar = $r->fetchAll();
              if ($r->rowCount()) {
                foreach ($ar as $a) {
                  echo "<option value=$a[course_id]>$a[course_nm]</option>";
                }
              }

              ?>
            </select>
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <lable for="year" class="form-label">Starting Year</lable>
          <div class="input-field">
            <select name="year" id="year" class="form-select mt-2">
              <option value="" selected disabled>select-starting-year</option>
             <?php 
             $year =1974;
             while ($year != date("Y")) {
             echo " <option value='$year'>$year</option>";
             $year++;
             }
             ?>
            </select>
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="sprofession" class="form-label">Profession</label>
          <div class="input-field">
            <input type="text" name="sprofession" id="sprofession" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="semail" class="form-label">Email</label>
          <div class="input-field">
            <input type="email" name="semail" id="semail" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="phone" class="form-label">Phone</label>
          <div class="input-field">
            <input type="text" name="phone" id="phone" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="pwd" class="form-label">Password</label>
          <div class="input-field">
            <input type="password" name="pwd" id="pwd" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="cpwd" class="form-label">Confirm Password</label>
          <div class="input-field">
            <input type="password" name="cpwd" id="cpwd" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex">
            </span>
          </div>
        </div>
        <div class="col-md-8">
          <label for="photo" class="form-label">Your Profile Photo</label>
          <div class="input-field">
            <input type="file" name="photo" id="photo" accept="image/*" class="form-control">
            <i class="fa" aria-hidden="true"></i>
            <span class="d-flex"></span>
          </div>
        </div>
        <div class="col-md-12" align="center">
          <input type="submit" value="Register" class="active" id="sub">
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    var AndraPradesh = ["Anantapur", "Chittoor", "East Godavari", "Guntur", "Kadapa", "Krishna", "Kurnool", "Prakasam", "Nellore", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari"];
    var ArunachalPradesh = ["Anjaw", "Changlang", "Dibang Valley", "East Kameng", "East Siang", "Kra Daadi", "Kurung Kumey", "Lohit", "Longding", "Lower Dibang Valley", "Lower Subansiri", "Namsai", "Papum Pare", "Siang", "Tawang", "Tirap", "Upper Siang", "Upper Subansiri", "West Kameng", "West Siang", "Itanagar"];
    var Assam = ["Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup Metropolitan", "Kamrup (Rural)", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli", "Morigaon", "Nagaon", "Nalbari", "Dima Hasao", "Sivasagar", "Sonitpur", "South Salmara Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong"];
    var Bihar = ["Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", "Buxar", "Darbhanga", "East Champaran", "Gaya", "Gopalganj", "Jamui", "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", "Madhepura", "Madhubani", "Munger", "Muzaffarpur", "Nalanda", "Nawada", "Patna", "Purnia", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"];
    var Chhattisgarh = ["Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband", "Janjgir Champa", "Jashpur", "Kabirdham", "Kanker", "Kondagaon", "Korba", "Koriya", "Mahasamund", "Mungeli", "Narayanpur", "Raigarh", "Raipur", "Rajnandgaon", "Sukma", "Surajpur", "Surguja"];
    var Goa = ["North Goa", "South Goa"];
    var Gujarat = ["Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", "Bhavnagar", "Botad", "Chhota Udaipur", "Dahod", "Dang", "Devbhoomi Dwarka", "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda", "Kutch", "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar", "Tapi", "Vadodara", "Valsad"];
    var Haryana = ["Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurugram", "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", "Mewat", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", "Sonipat", "Yamunanagar"];
    var HimachalPradesh = ["Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul Spiti", "Mandi", "Shimla", "Sirmaur", "Solan", "Una"];
    var JammuKashmir = ["Anantnag", "Bandipora", "Baramulla", "Budgam", "Doda", "Ganderbal", "Jammu", "Kargil", "Kathua", "Kishtwar", "Kulgam", "Kupwara", "Leh", "Poonch", "Pulwama", "Rajouri", "Ramban", "Reasi", "Samba", "Shopian", "Srinagar", "Udhampur"];
    var Jharkhand = ["Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", "Sahebganj", "Seraikela Kharsawan", "Simdega", "West Singhbhum"];
    var Karnataka = ["Bagalkot", "Bangalore Rural", "Bangalore Urban", "Belgaum", "Bellary", "Bidar", "Vijayapura", "Chamarajanagar", "Chikkaballapur", "Chikkamagaluru", "Chitradurga", "Dakshina Kannada", "Davanagere", "Dharwad", "Gadag", "Gulbarga", "Hassan", "Haveri", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysore", "Raichur", "Ramanagara", "Shimoga", "Tumkur", "Udupi", "Uttara Kannada", "Yadgir"];
    var Kerala = ["Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", "Thiruvananthapuram", "Thrissur", "Wayanad"];
    var MadhyaPradesh = ["Agar Malwa", "Alirajpur", "Anuppur", "Ashoknagar", "Balaghat", "Barwani", "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", "Hoshangabad", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Panna", "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna",
      "Sehore", "Seoni", "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", "Ujjain", "Umaria", "Vidisha"
    ];
    var Maharashtra = ["Ahmednagar", "Akola", "Amravati", "Aurangabad", "Beed", "Bhandara", "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar", "Parbhani", "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", "Thane", "Wardha", "Washim", "Yavatmal"];
    var Manipur = ["Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"];
    var Meghalaya = ["East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "North Garo Hills", "Ri Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"];
    var Mizoram = ["Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip", "Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip"];
    var Nagaland = ["Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", "Mon", "Peren", "Phek", "Tuensang", "Wokha", "Zunheboto"];
    var Odisha = ["Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", "Debagarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghpur", "Jajpur", "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar", "Khordha", "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nayagarh", "Nuapada", "Puri", "Rayagada", "Sambalpur", "Subarnapur", "Sundergarh"];
    var Punjab = ["Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", "Firozpur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", "Mansa", "Moga", "Mohali", "Muktsar", "Pathankot", "Patiala", "Rupnagar", "Sangrur", "Shaheed Bhagat Singh Nagar", "Tarn Taran"];
    var Rajasthan = ["Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", "Ganganagar", "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", "Sawai Madhopur", "Sikar", "Sirohi", "Tonk", "Udaipur"];
    var Sikkim = ["East Sikkim", "North Sikkim", "South Sikkim", "West Sikkim"];
    var TamilNadu = ["Ariyalur", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", "Dindigul", "Erode", "Kanchipuram", "Kanyakumari", "Karur", "Krishnagiri", "Madurai", "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Salem", "Sivaganga", "Thanjavur", "Theni", "Thoothukudi", "Tiruchirappalli", "Tirunelveli", "Tiruppur", "Tiruvallur", "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"];
    var Telangana = ["Adilabad", "Bhadradri Kothagudem", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar", "Jogulamba", "Kamareddy", "Karimnagar", "Khammam", "Komaram Bheem", "Mahabubabad", "Mahbubnagar", "Mancherial", "Medak", "Medchal", "Nagarkurnool", "Nalgonda", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", "Ranga Reddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", "Warangal Rural", "Warangal Urban", "Yadadri Bhuvanagiri"];
    var Tripura = ["Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", "Unakoti", "West Tripura"];
    var UttarPradesh = ["Agra", "Aligarh", "Allahabad", "Ambedkar Nagar", "Amethi", "Amroha", "Auraiya", "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", "Chitrakoot", "Deoria", "Etah", "Etawah", "Faizabad", "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", "Hapur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kheri", "Kushinagar", "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", "Raebareli", "Rampur", "Saharanpur", "Sambhal", "Sant Kabir Nagar", "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi"];
    var Uttarakhand = ["Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", "Nainital", "Pauri", "Pithoragarh", "Rudraprayag", "Tehri", "Udham Singh Nagar", "Uttarkashi"];
    var WestBengal = ["Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur", "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", "Paschim Bardhaman", "Paschim Medinipur", "Purba Bardhaman", "Purba Medinipur", "Purulia", "South 24 Parganas", "Uttar Dinajpur"];
    var AndamanNicobar = ["Nicobar", "North Middle Andaman", "South Andaman"];
    var Chandigarh = ["Chandigarh"];
    var DadraHaveli = ["Dadra Nagar Haveli"];
    var DamanDiu = ["Daman", "Diu"];
    var Delhi = ["Central Delhi", "East Delhi", "New Delhi", "North Delhi", "North East Delhi", "North West Delhi", "Shahdara", "South Delhi", "South East Delhi", "South West Delhi", "West Delhi"];
    var Lakshadweep = ["Lakshadweep"];
    var Puducherry = ["Karaikal", "Mahe", "Puducherry", "Yanam"];


    $("#state").change(function() {
      var StateSelected = $(this).val();
      var optionsList;
      var htmlString = "";

      switch (StateSelected) {
        case "Andra Pradesh":
          optionsList = AndraPradesh;
          break;
        case "Arunachal Pradesh":
          optionsList = ArunachalPradesh;
          break;
        case "Assam":
          optionsList = Assam;
          break;
        case "Bihar":
          optionsList = Bihar;
          break;
        case "Chhattisgarh":
          optionsList = Chhattisgarh;
          break;
        case "Goa":
          optionsList = Goa;
          break;
        case "Gujarat":
          optionsList = Gujarat;
          break;
        case "Haryana":
          optionsList = Haryana;
          break;
        case "Himachal Pradesh":
          optionsList = HimachalPradesh;
          break;
        case "Jammu and Kashmir":
          optionsList = JammuKashmir;
          break;
        case "Jharkhand":
          optionsList = Jharkhand;
          break;
        case "Karnataka":
          optionsList = Karnataka;
          break;
        case "Kerala":
          optionsList = Kerala;
          break;
        case "Madya Pradesh":
          optionsList = MadhyaPradesh;
          break;
        case "Maharashtra":
          optionsList = Maharashtra;
          break;
        case "Manipur":
          optionsList = Manipur;
          break;
        case "Meghalaya":
          optionsList = Meghalaya;
          break;
        case "Mizoram":
          optionsList = Mizoram;
          break;
        case "Nagaland":
          optionsList = Nagaland;
          break;
        case "Orissa":
          optionsList = Orissa;
          break;
        case "Punjab":
          optionsList = Punjab;
          break;
        case "Rajasthan":
          optionsList = Rajasthan;
          break;
        case "Sikkim":
          optionsList = Sikkim;
          break;
        case "Tamil Nadu":
          optionsList = TamilNadu;
          break;
        case "Telangana":
          optionsList = Telangana;
          break;
        case "Tripura":
          optionsList = Tripura;
          break;
        case "Uttaranchal":
          optionsList = Uttaranchal;
          break;
        case "Uttar Pradesh":
          optionsList = UttarPradesh;
          break;
        case "West Bengal":
          optionsList = WestBengal;
          break;
        case "Andaman and Nicobar Islands":
          optionsList = AndamanNicobar;
          break;
        case "Chandigarh":
          optionsList = Chandigarh;
          break;
        case "Dadar and Nagar Haveli":
          optionsList = DadraHaveli;
          break;
        case "Daman and Diu":
          optionsList = DamanDiu;
          break;
        case "Delhi":
          optionsList = Delhi;
          break;
        case "Lakshadeep":
          optionsList = Lakshadeep;
          break;
        case "Pondicherry":
          optionsList = Pondicherry;
          break;
      }


      for (var i = 0; i < optionsList.length; i++) {
        htmlString = htmlString + "<option value='" + optionsList[i] + "'>" + optionsList[i] + "</option>";
      }
      $("#city").html(htmlString);

    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11/dist/sweetalert2.all.min.js"></script>
  <script src="validate.js"></script>
</body>

</html>