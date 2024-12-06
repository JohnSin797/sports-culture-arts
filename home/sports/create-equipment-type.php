<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['Student_id'])) {
  header("Location: ../../index.php");
  exit();
}

$lastname = $_SESSION['Lastname'];
$firstname = $_SESSION['Firstname'];

$firstLetterLastname = substr($lastname, 0, 1);
$firstLetterFirstname = substr($firstname, 0, 1);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="sports-style.css"/>
        <link rel="stylesheet" href="create.css" />
        <script type="text/javascript" src="sportsscript.js" defer></script>
        <title>Sport Equipments | SKC Bulan Portal</title>
    </head>
<body>
    <nav id="nav-group" class="navcontainer">
        <img class="skc" src="../../img/SKC LOGO.svg" />
        <h4 class="Logoname-1">Sorsogon State University</h4>
        <h4 class="Logoname-2">Sports Culture & Arts</h4>
        <ul>
            <li>
                <a href="../homepage.php" class="homepage">Home</a>
            </li>
            <li>
                <a href="../sports-equipment.php" class="Sports-menu">Sports Equipments</a>
            </li>
            <li>
                <a href="../athlete/athlete-profile.php" class="athlete-menu">Athelete Profile</a>
            </li>
        </ul>
        <img class="notification-icon"
            src="../../img/notification-icon.svg" />
        <img class="message-icon"
            src="../../img/message-icon.svg" />
        <h6 class="user-login-icon" onclick="toggleMenu()">
        <?= htmlspecialchars($firstLetterFirstname) . htmlspecialchars($firstLetterLastname) ?>
        </h6>
        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <h6 class="username"><?= htmlspecialchars($firstLetterFirstname) . htmlspecialchars($firstLetterLastname) ?></h6>
                    <h6 class="userinfo-fullname"><?= $_SESSION['Fullname'] ?></h6>
                    <h6 class="userinfo-id"><?= $_SESSION['Student_id'] ?></h6>
                    <h6 class="userinfo-type"><?= $_SESSION['Usertype'] ?></h6>
                </div>
                <hr>
                <a href="#" class="sub-menu-link">
                    <img class="icon-container"
                            src="../../img/Edit-profile-icon.svg"
                            alt="">
                    <p>Edit Profile</p>
                    <span>></span>
                </a>
                <?php if ($_SESSION['Usertype'] == 'Admin'): ?>
                <a href="#" class="sub-menu-link">
                    <img class="icon-container"
                        src="../../img/settings-icon.svg"
                        alt="">
                    <p>Settings</p>
                    <span>></span>
                </a>
                <?php endif; ?>
                <a href="../../logout.php?redirect=home/sports/sports-equipment.php" class="sub-menu-link">
                    <img class="icon-container"
                        src="../../img/logout-icon.svg"
                        alt="">
                    <p>Logout</p>
                    <span>></span>
                </a>
            </div>
        </div>
    </nav>
    <aside id="side-nav-group">
        <ul>
            <li class="menu-toggle">
                <span class="sidebar-logo">SKC Portal</span>
                <button onclick=toggleSidebar() id="sidetoggle-btn">
                <img class="menu-icon"
                    src="../../img/Menu-icon.svg" />
                <img class="backside"
                    src="../../img/back-icon.svg">
                </button>
            </li>
            <li class="menu-schedule-container">
                <a href="#">
                <img class="menu-schedule"
                    src="../../img/schedule-icon.svg" />
                <span class="notogglemenu">Schedule</span>
                </a>
            </li>
            <li class="sidenav-li">
                <button onclick=toggleSubMenu(this) class="dropdown-btn">
                <img class="menu-skcform"
                    src="../../img/skc-form-icon.svg"
                    alt="">
                <span class="Skcforms">SKC forms</span>
                <img class="skcform-dropdown"
                    src="../../img/Dropdown-button.svg"
                    alt="dropdown button">
                </button>
                <ul class="sub-menus">
                    <div>
                        <li class="personal-datamenu">
                        <a href="../skc-forms/Personal-Data.php">
                            <img class="menu-personal"
                            src="../../img/PersonalData-icon.svg"
                            alt="">
                            <span class="personal-span">Personal Data</span>
                        </a>
                        </li>
                        <li class="member-datamenu">
                        <a href="../skc-forms/Member's-Profile.php">
                            <img class="menu-members"
                            src="../../img/member's profile-icon.svg"
                            alt="">
                            <span class="member-span">Member's Profile</span>
                        </a>
                        </li>
                        <li class="varsity-datamenu">
                        <a href="../skc-forms/Varsity-Application-Form.php">
                            <img class="menu-varsity"
                            src="../../img/VarsityApplication-icon.svg"
                            alt="">
                            <span class="varsity-span">Varsity Application Form</span>
                        </a>
                        </li>
                        <li class="athlete-datamenu">
                        <a href="../skc-forms/Athlete-Registration-Form.php">
                            <img class="menu-athlete"
                            src="../../img/Athlete RF.svg"
                            alt="">
                            <span class="athlete-span">Athlete Registration Form</span>
                        </a>
                        </li>
                        <li class="application-datamenu">
                        <a href="#">
                            <img class="menu-application"
                            src="../../img/ApplicationForSportsClub-icon.svg"
                            alt="">
                            <span class="application-span">Application for Sports Club</span>
                        </a>
                        </li>
                    </div>
                </ul>
            </li>
            <li class="menu-report-container">
                <a href="#" class="no">
                <img class="menu-report"
                    src="../../img/reports-icon.svg" />
                <span class="notogglemenu1">Reports</span>
                </a>
            </li>
        </ul>
    </aside>
    <main class="container">
        <section class="panel">
            <header class="headersect">
                <h1>Add Equipment Type</h1>
            </header>
            <form method="POST" action="../../api/create-equipment-type.php" enctype="multipart/form-data">
                <div class="panelbody">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <button type="submit" class="submit-btn">save</button>
            </form>
        </section>
    </main>
</body>
</html>