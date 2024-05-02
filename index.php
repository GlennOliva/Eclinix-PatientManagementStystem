<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocampo’s Children & Maternity Clinic</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- normalize css -->
    <link rel = "stylesheet" href = "css/normalize.css">
    <!-- custom css -->
    <link rel = "stylesheet" href = "css/main.css">
</head>
<body>
    

    <!-- header -->
    <header class = "header bg-blue">
        <nav class = "navbar bg-blue">
            <div class = "container flex">
                <a href = "index.html" class = "navbar-brand">
                    <img src = "images/eclinix.png" alt = "site logo">
                </a>
                <button type = "button" class = "navbar-show-btn">
                    <img src = "images/ham-menu-icon.png">
                </button>

                <div class = "navbar-collapse bg-white">
                    <button type = "button" class = "navbar-hide-btn">
                        <img src = "images/close-icon.png">
                    </button>
                    <ul class = "navbar-nav">
                        <li class = "nav-item">
                            <a href = "#" class = "nav-link">Home</a>
                        </li>
                        <li class = "nav-item">
                            <a href = "#" class = "nav-link">About</a>
                        </li>
                        <li class = "nav-item">
                            <a href = "#" class = "nav-link">Location</a>
                        </li>
                    </ul>
                    <div class = "search-bar">
                        <div class = "btn-group">
                            <a href = "../capstone-patient/patient/patient_login.php" class = "btn btn-light-blue">BOOK AN APPOINTMENT</a>
                        </div>
                    </div>
                </div> 
            </div>
        </nav>

        <div class = "header-inner text-white text-center">
            <div class = "container grid">
                <div class = "header-inner-left">
                    <h1><span>Pediatric Clinic</span></h1>
                    <p class = "lead">Ocampo’s Children & Maternity Clinic</p>
                    <p class="text text-md" style="text-align: justify;">
                        Ocampos Children & Maternity Clinic is a trusted healthcare provider dedicated to the well-being of mothers and children. With a team of experienced pediatricians and maternity specialists, we offer comprehensive care tailored to the unique needs of each patient. From routine check-ups to specialized treatments, our clinic is committed to delivering compassionate and high-quality healthcare services. Located in the heart of Quezon City, we are a community-focused clinic with a warm and welcoming environment, ensuring every visit is a positive experience for you and your family.
                        </p>
                        
                    <div class = "btn-group">
                    <a href = "../capstone-patient/patient/patient_login.php" class = "btn btn-light-blue">BOOK AN APPOINTMENT</a>
                    </div>
                </div>
                <div class = "header-inner-right">
                    <img src = "images/doc-1.png" style="width: 40%;">
                </div>
            </div>
        </div>
    </header>
    <!-- end of header -->

    <main>
        <!-- about section -->
        <section id = "about" class = "about py">
            <div class = "about-inner">
                <div class = "container grid">
                    <div class = "about-left text-center">
                        <div class = "section-head">
                            <h2>About Us</h2>
                            <div class = "border-line"></div>
                        </div>
                        <p class="text text-lg" style="text-align: justify;">
                            Ocampos Children & Maternity Clinic is a leading healthcare facility in Quezon City, offering comprehensive medical services for children and expectant mothers. Our team of skilled pediatricians and maternity specialists is committed to providing the highest level of care, with a focus on compassion and personalized attention. We offer a wide range of services, including routine pediatric check-ups, vaccinations, prenatal care, and postnatal support.
                            </p>
                            
                  
                    </div>
                    <div >
                        <div class = "img" style="width: 100%; margin-top: 25%;">
                            <img src = "images/pedia-1.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of about section -->



        
        

       

        <!-- package services section -->
        <section id = "package-service" class = "package-service py text-center">
            <div class = "container">
                <div class = "package-service-head text-white" style="padding: 15px">
                    <h2>Location</h2>
              
                </div>
                <div class="container-fluid"> <!-- Use container-fluid for full width -->
                    <div style="width: 100%; height: 600px;"> <!-- Full-width container for the iframe -->
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.198866771383!2d121.03293697463145!3d14.701343074603189!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b183a8032d4f%3A0x180ea017e4ab55f3!2sDr.%20Ocampo%20Pedia%20Clinic!5e0!3m2!1sen!2sph!4v1714676309349!5m2!1sen!2sph" 
                            style="width: 100%; height: 100%; border: 0;" 
                            allowfullscreen 
                            loading="lazy"
                        ></iframe>
                    </div>
                </div>

                </div>
            </div>
        </section>
        <!-- end of package services section -->

       

        
    </main>

    <style>
        .text-justify {
            text-align: justify; /* Justify text */
        }
        </style>

<!-- Footer -->
<footer id="footer" class="footer text-center" style="background-color: #fff;">
    <div class="container" >
        <div class="footer-inner  py grid" style="color: black;">
            <!-- Clinic Address and Information -->
            <div class="footer-item">
                <h3 class="footer-head">Clinic Address</h3>
                <p class="text-justify">
                    Ocampos Children & Maternity Clinic
                    No.1 Rockville Subdivision Quirino Highway 
                    San Bartolome, Novaliches, Quezon City Philippines.
                </p>
            </div>

            <!-- Clinic Hours -->
            <div class="footer-item">
                <h3 class="footer-head">Clinic Hours</h3>
                <p >Monday to Saturday: 9 am to 2 pm</p>
            </div>
        </div>
    </div>
</footer>
<!-- End of Footer -->



    <!-- custom js -->
    <script src = "js/script.js"></script>
</body>
</html>