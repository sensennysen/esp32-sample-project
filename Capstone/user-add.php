<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="userAdd.css">
    <!-- Boxiocns CDN Link -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

  <?php include ('sidebar.php');?>
  
  <section class="home-section">
    <div class="home-content">
      <span class="text">Add Employee User</span>
    </div>
    <form action="./NewUser/newUser.php" method="post" enctype="multipart/form-data">
    <div class="formbold-main-wrapper">
            <div class="formbold-form-wrapper">
                <div class="formbold-input-flex">

                <div>
                  <input id="upload_Image" name="uploadImage" type="file"  accept="image/png, image/jpeg, image/jpg" required />
                    <label for="upload_Image"></label>
                </div>

                <div>
                <label class="form-label">Department:</label>
                  <select name="department" id="userRoleSelect" onchange="updateUserRole(this)" required>
                    <option>Select</option>
                    <option value="Collection Department">Collection Department</option>
                    <option value="Admin">HR Department</option>
                    <option value="Marketing Department">Marketing Department</option>
                    <option value="Verification Department">Verification Department</option>
                  </select>
                    <input type="hidden" id="userRoleInput" name="userRole">
                </div>

                <div>
                    <label for="facebook"  class="formbold-form-label">
                      Facebook
                    </label>
                    <input
                      type="email"
                      name="fUrl"
                      id="facebook"
                      class="formbold-form-input"
                    />
                  </div>
                  
                  <div>
                    <label for="email"  class="formbold-form-label">
                      Email
                    </label>
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="formbold-form-input"
                    />
                  </div>

                  <div>
                    <label for="firstname"  class="formbold-form-label">
                      First name
                    </label>
                    <input
                      type="text"
                      name="fname"
                      id="firstname"
                      class="formbold-form-input"
                    />
                  </div>

                   <div>
                    <label for="middleName"  class="formbold-form-label">
                      Middle Name
                    </label>
                    <input
                      type="text"
                      name="MiddleInitial"
                      id="middleInitial"
                      class="formbold-form-input"
                    />
                  </div>

                  <div>
                    <label for="lastname" class="formbold-form-label"> Last name</label>
                    <input
                      type="text"
                      name="lname"
                      id="lastname"
                      class="formbold-form-input"
                    />
                  </div>
                </div>
          
                <div>
                  <div>
                    <label for="suffix" class="formbold-form-label"> Suffix </label>
                    <input
                      type="text"
                      name="Suffix"
                      id="suffix"
                      class="formbold-form-input"
                    />
                  </div>
                  <div>
                    <label for="gender" class="formbold-form-label"> Gender </label>
                    <select name="gender" class="selectpicker form-control" data-style="py-0">
                      <option>Select</option>
                      <option value="Female">Female</option>
                      <option value="Male">Male</option>
                    </select>
                  </div>
                </div>
                <div>
                    <label for="mobNo" class="formbold-form-label">Mobile Number</label>
                    <input
                      type="tel"
                      name="MobNo"
                      id="mobNo"
                      class="formbold-form-input"
                    />
                  </div>
                  <div>
                    <label for="altCon" class="formbold-form-label">Alternative Contact</label>
                    <input
                      type="tel"
                      name="AltCon"
                      id="altCon"
                      class="formbold-form-input"
                    />
                  </div>

                <div class="formbold-mb-3">
                  <label for="bday" class="formbold-form-label">
                    Date of Birth
                  </label>
                  <input
                    type="date"
                    name="birthDate"
                    id="bday"
                    class="formbold-form-input"
                  />
                </div>
          
                <div class="formbold-mb-3">
                  <label for="streetAdd" class="formbold-form-label">
                    Street Name, Building House, Lot No.
                  </label>
                  <input
                    type="text"
                    name="StreetAdd"
                    id="streetAdd"
                    class="formbold-form-input"
                  />
                </div>
          
                <div class="formbold-input-flex">
                  <div>
                    <label for="city" class="formbold-form-label"> City </label>
                    <input
                      type="text"
                      name="city"
                      id="city"
                      class="formbold-form-input"
                    />
                  </div>
                  <div>
                    <label for="province" class="formbold-form-label"> Province </label>
                    <input
                      type="text"
                      name="province"
                      id="province"
                      class="formbold-form-input"
                    />
                  </div>

                  <div>
                    <label for="Country" class="formbold-form-label"> Country </label>
                    <input
                      type="text"
                      name="country"
                      id="country"
                      class="formbold-form-input"
                    />
                  </div>
                </div>
          
                <div class="formbold-input-flex">
                  <div>
                    <label for="postCode" class="formbold-form-label"> Postal Code</label>
                    <input
                      type="text"
                      name="pno"
                      id="postCode"
                      class="formbold-form-input"
                    />
                  </div>
                 
                  <div class="formbold-input-flex">
                  <div>
                    <label for="username" class="formbold-form-label">Username</label>
                    <input
                      type="text"
                      name="uname"
                      id="username"
                      class="formbold-form-input"
                    />
                  </div>

                  <div>
                    <label for="password" class="formbold-form-label">Password</label>
                    <input
                      type="password"
                      name="password"
                      id="password"
                      class="formbold-form-input"
                    />
                  </div>

                  <div>
                    <label for="rePass" class="formbold-form-label">Repeat Password</label>
                    <input
                      type="password"
                      name="rpass"
                      id="rePass"
                      class="formbold-form-input"
                    />
                  </div>
                </div>
                <button class="formbold-btn" >Add</button>
               
              </form>
            </div>
          </div>
    </div>
  </div>
</body>
<script>
  function updateUserRole(selectElement) {
  var selectedDepartment = selectElement.value;
  var userRoleInput = document.getElementById('userRoleInput');

  if (selectedDepartment === 'HR Department') {
    userRoleInput.value = 'admin';
  } else {
    userRoleInput.value = 'employee';
  }
}
</script>
</html>