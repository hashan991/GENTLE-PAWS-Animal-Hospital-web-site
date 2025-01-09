<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
?>

























<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School managment</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="top-bar">
      <div class="container">
        <p>
          <span>&#128205;</span> No 506/7 Elvitigala Mawatha, Colombo 05, Sri
          Lanka
        </p>
        <p><span>&#128222;</span> +94 11 230 3554</p>
        <p><span>&#128231;</span> petsvcare@gmail.com</p>
        <p><span>&#128337;</span> 08:30 AM - 10:00 PM</p>
      </div>
    </div>

    <header class="main-header">
      <div class="container">
       
        <nav class="main-nav">
          <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="users.php">USERS</a></li>
            <li><a href="#">BOOK NOW</a></li>
            <li><a href="#">PRODUCT</a></li>
            <li><a href="#">NOTICE</a></li>
            <li><a href="#">FEEDBACK</a></li>
                <li><a href="logout.php">LOG OUT</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section class="hero">
      <div class="hero-content">
        <h1>Welcome to GENTLE PAWS Animal Hospital</h1>
        <p>
          The Pets V Care Animal Hospital is one of the leading Vet hospital in
          Sri Lanka. Your pet will be cared for by highly experienced
          veterinarians with supportive staff using state-of-the-art modern
          facilities.
        </p>
      </div>
    </section>

    <section class="features">
      <div class="container">
        <div class="feature-card">
          

          <h3>Book an Appointment</h3>
          <p>
            Call us to book an appointment to get veterinary services from
            experienced doctors.
          </p>
          <a href="appointment.php" class="btn">Book Now</a>
        </div>
        <div class="feature-card">
          
          <h3>mobile service</h3>
          <p>
            Call us to schedule an appointment to get our mobile service for
            your pets.
          </p>
          <a href="appointment.php" class="btn">📞 Call Us Now</a>
        </div>
        <div class="feature-card">
         

          <h3>Visit Us</h3>
          <p>
            Visit our main hospital at No 506/7 Elvitigala Mawatha, Colombo 05.
          </p>
          <a href="appointment.php" class="btn">📍 Get Location</a>
        </div>
      </div>
    </section>

    <section class="info-section">
      <div class="container">
        <!-- Image -->
        <div class="info-image">
          <img
            src="https://images.pexels.com/photos/1108099/pexels-photo-1108099.jpeg?cs=srgb&dl=pexels-chevanon-1108099.jpg&fm=jpg&w=640&h=480&_gl=1*17yfrk1*_ga*MTUzMjAxNTMwMi4xNzM2MzEwMjMw*_ga_8JE65Q40S6*MTczNjMxNTk0MS4yLjEuMTczNjMxNTk1OC4wLjAuMA.."
            alt="Golden Retrievers in a Field"
          />
        </div>
        <!-- Text -->
        <div class="info-text">
          <h2>Everything Your Pet Needs in One Place</h2>
          <p>
            PetsVCare animal hospitals provide a wide variety of services
            including Vaccination, Consultation, Surgeries, Dental scaling,
            Microchipping, and much more. Experienced doctors will always care
            about your precious furry friends.
          </p>
        </div>
      </div>
    </section>

    <section class="experience-section">
      <div class="container">
        <!-- Left Column -->
        <div class="experience-left">
          <h1>22 <span>Years</span></h1>
          <p>Experience In the Veterinary field</p>
        </div>

        <!-- Right Column -->
        <div class="experience-right">
          <h3>Most Experienced Veterinarians in the Industry</h3>
          <p>
            We provide veterinary services for more than 20 years in Sri Lanka.
            Dedicated and experienced veterinary doctors will take care of your
            precious companions.
          </p>
        </div>
      </div>
    </section>

    <footer class="footer">
      <div class="container">
        <!-- Logo and Description -->
        <div class="footer-logo">
          <img src='https://images.pexels.com/photos/2173872/pexels-photo-2173872.jpeg?cs=srgb&dl=pexels-alexasfotos-2173872.jpg&fm=jpg&w=640&h=640&_gl=1*ilkx6f*_ga*MTUzMjAxNTMwMi4xNzM2MzEwMjMw*_ga_8JE65Q40S6*MTczNjMxODU3OC4zLjEuMTczNjMxODY5NC4wLjAuMA..' alt="PetsVCare Logo" />
          <p>
            The PetsVCare Animal Hospital is one of the<br />
            leading Vet hospitals in Sri Lanka. Your pet will be<br />
            cared for by highly experienced veterinarians.
          </p>
        </div>

        <!-- Navigation Links -->
        <div class="footer-nav">
          <h4>Navigation</h4>
          <ul>
            <li><a href="#">Privacy</a></li>
            <li><a href="#">Terms</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div>

        <!-- Contact Information -->
        <div class="footer-contact">
          <h4>Contact Us</h4>
          <p>Email Addresses</p>
          <p>petsvcare@gmail.com</p>
          <p>info@petsvcare.lk</p>
          <p>Call Us</p>
          <p>+94 11 230 3554</p>
          <p>+94 77 345 7238</p>
        </div>

        <!-- Location Information -->
        <div class="footer-location">
          <h4>PetsVCare Hospital Location</h4>
          <p>PetsVCare Animal Hospital,</p>
          <p>506/7 Elvitigala Mawatha,</p>
          <p>Colombo 05,</p>
          <p>Sri Lanka</p>
        </div>
      </div>

      <!-- Footer Bottom Section -->
      <div class="footer-bottom">
        <p>
          Copyright © 2002 - 2025 PetsVCare Animal Hospital (PVT) Ltd. All
          rights reserved.
        </p>
        
        <a href="#top" class="scroll-top">▲</a>
      </div>
    </footer>
  </body>
</html>
