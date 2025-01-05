<?php
require_once 'includes/Database.php';

$db = new Database();
$conn = $db->getConnection();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>selam, Portfolio project</title>
    <link rel="stylesheet" href="selam/assets/css/style.css">
    <link rel="stylesheet" href="selam/assets/css/fontawesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
<!-- ////////////////////////////////////////////////////////////////////////////////////////
                               START SECTION 1 - THE NAVBAR SECTION  
/////////////////////////////////////////////////////////////////////////////////////////////-->
<nav class="navbar navbar-expand-lg navbar-dark menu shadow fixed-top">
    <div class="container">
      <a class="navbar-brand" href="../selam/index.html">SELAM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <?php
        try 
          {
              $query = "SHOW TABLES";
              $stmt = $conn->query($query);
              $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

              // Start the navigation menu
              echo '<ul class="navbar-nav">';?>
              <li><a class="nav-link" href="#home">Home</a></li>
              <?php foreach ($tables as $tableName)
              {
                  // Skip the 'admin' table
                  if ($tableName === 'admin' or $tableName === 'footer') 
                  {
                      continue; // Skip this iteration
                  }

                  // Format the table name for display (e.g., capitalize first letter)
                  $label = ucfirst(str_replace('_', ' ', $tableName));
                  
                  // Use the table name to create links
                  echo '<li class="nav-item">
                          <a class="nav-link" href="#' . htmlspecialchars($tableName) . '">' . htmlspecialchars($label) . '</a>
                        </li>';
                  }
          
            echo '</ul>';
          } 
        catch (PDOException $e) {
            echo "Error fetching tables: " . $e->getMessage();
        }
    ?>
      </div>
    </div>
  </nav>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
                            START SECTION 2 - THE INTRO SECTION  
/////////////////////////////////////////////////////////////////////////////////////////////////////-->

<section id="home" class="intro-section">
  <div class="container">
    <div class="row align-items-center text-white">
      <!-- START THE CONTENT FOR THE INTRO  -->
      <div class="col-md-6 intros text-start">
        <h1 class="display-2">
          <span class="display-2--intro">Hey!, I'm Selamawit</span>
          <span class="display-2--description lh-base">
            Web Developer
          </span>
        </h1>
      </div>
    </div>
  </div>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,208C384,192,480,128,576,133.3C672,139,768,213,864,202.7C960,192,1056,96,1152,74.7C1248,53,1344,107,1392,133.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
</section>

<!-- //////////////////////////////////////////////////////////////////////////////////////////////
                         START SECTION 3 - THE SERVICES  
///////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="services" class="services">
  <div class="container">
    <div class="row text-center">
      <h1 class="display-3 fw-bold">Our Services</h1>
      <div class="heading-line mb-1"></div>
    </div>
     <?php
        $query = "SELECT service_name, description FROM services";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- START THE CONTENT FOR THE SERVICES  -->
        <div class="container">
          <?php foreach ($services as $service): ?>
            <!-- START THE SERVICE CONTENT  -->
            <div class="row">
              <!-- Image and description section -->
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
                <div class="services__content">
                  <!-- <div class="icon d-block <?= $service['icon'] ?>"></div> -->
                  <h3 class="display-3--title mt-1"><?= htmlspecialchars($service['service_name']) ?></h3>
                  <p class="lh-lg"><?= htmlspecialchars($service['description']) ?></p>
                  <button type="button" class="rounded-pill btn-rounded border-primary">Learn more
                    <span><i class="fas fa-arrow-right"></i></span>
                  </button>
                </div>
              </div>
             
              <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-end">
                <div class="services__pic">
                  <img src="images/services/<?= htmlspecialchars($service['icon']) ?>.png" alt="<?= htmlspecialchars($service['service_name']) ?> illustration" class="img-fluid">
                </div> 
              </div> -->
            </div>
         
          <?php endforeach; ?>
    </div>
<!-- END THE CONTENT FOR THE SERVICES  -->

</section>

  
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
                       START SECTION 4 - About 
//////////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="about" class="about bg-light py-5">
  <div class="container">
    <?php
    // Fetch data from the `about` table
    $query = "SELECT title, content FROM about LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $aboutData = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="row text-center">
      <h1 class="display-4 fw-bold">
        <?= htmlspecialchars($aboutData['title']) ?>
      </h1>
      <hr style="width: 100px; height: 3px; background-color: #000;" class="mx-auto">
      <p class="lead pt-3">
        <?= nl2br(htmlspecialchars($aboutData['content'])) ?>
      </p>
    </div>
  </div>
</section>


<!-- ////////////////////////////////////////////////////////////////////////////////////////////////
                               START SECTION 5- Blog  
/////////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="blog" class="blog">
  <div class="container">
    <div class="row text-center">
      <h1 class="display-3 fw-bold text-uppercase">Blog</h1>
      <div class="heading-line"></div>
      <p class="lead">Explore our latest articles and insights</p>
    </div>

    <?php
    try {
        $query = "SELECT title, author, content FROM blog";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo '<p class="text-danger">Error fetching blog posts: ' . $e->getMessage() . '</p>';
        $blogs = [];
    }
    ?>

    <div class="row mt-5">
      <?php if (!empty($blogs)): ?>
        <?php foreach ($blogs as $blog): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="blog-box shadow p-3 rounded">
              <h4 class="blog-title"><?= htmlspecialchars($blog['title']) ?></h4>
              <p class="blog-author text-muted">By <?= htmlspecialchars($blog['author']) ?></p>
              <div class="blog-content">
                <p><?= htmlspecialchars(substr($blog['content'], 0, 150)) ?>...</p>
              </div>
              <a href="#" class="btn btn-primary btn-sm mt-2">Read More</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center">No blog posts available at the moment. Please check back later.</p>
      <?php endif; ?>
    </div>
  </div>
</section>


<!-- ////////////////////////////////////////////////////////////////////////////////////////////////
                               START SECTION 6 - THE TESTIMONIALS  
/////////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="testimonials" class="testimonials">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,96L48,128C96,160,192,224,288,213.3C384,203,480,117,576,117.3C672,117,768,203,864,202.7C960,203,1056,117,1152,117.3C1248,117,1344,203,1392,245.3L1440,288L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
  <div class="container">
    <div class="row text-center text-white">
      <h1 class="display-3 fw-bold">Testimonials</h1>
      <hr style="width: 100px; height: 3px; " class="mx-auto">
      <p class="lead pt-1">what our clients are saying</p>
    </div>

<?php
    $query = "SELECT name, testimony FROM testimonials";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
      <div class="row align-items-center">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php foreach ($testimonials as $index => $testimonial): ?>
              <!-- CAROUSEL ITEM -->
              <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                <!-- Testimonials card -->
                <div class="testimonials__card">
                  <p class="lh-lg">
                    <i class="fas fa-quote-left"></i>
                    <?= htmlspecialchars($testimonial['testimony']) ?>
                    <i class="fas fa-quote-right"></i>
                    <div class="ratings p-1">
                      <!-- Static 5 stars, you can adjust later if needed -->
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </p>
                </div>
                <!-- Client name & role -->
                <div class="testimonials__name">
                  <h3><?= htmlspecialchars($testimonial['name']) ?></h3>
                  <p class="fw-light">Client</p> <!-- Adjust this to a fixed text or add role column if needed -->
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Carousel Controls -->
          <div class="text-center">
            <button class="btn btn-outline-light fas fa-long-arrow-alt-left" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev"></button>
            <button class="btn btn-outline-light fas fa-long-arrow-alt-right" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next"></button>
          </div>
        </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,96L48,128C96,160,192,224,288,213.3C384,203,480,117,576,117.3C672,117,768,203,864,202.7C960,203,1056,117,1152,117.3C1248,117,1344,203,1392,245.3L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
</section>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
                       START SECTION 6 - THE FAQ 
//////////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="faq" class="faq">
  <div class="container">
    <div class="row text-center">
      <h1 class="display-3 fw-bold text-uppercase">faq</h1>
      <div class="heading-line"></div>
      <p class="lead">frequently asked questions, get knowledge befere hand</p>
    </div>
<?php
    $query = "SELECT question, answer FROM faq"; // Assuming 'faq' table has 'question' and 'answer' columns
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="row mt-5">
  <div class="col-md-12">
    <div class="accordion" id="accordionExample">
      <?php foreach ($faqs as $index => $faq): ?>
        <!-- ACCORDION ITEM -->
        <div class="accordion-item shadow mb-3">
          <h2 class="accordion-header" id="heading<?= $index ?>">
            <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
              <?= htmlspecialchars($faq['question']) ?>
            </button>
          </h2>
          <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <strong>Answer:</strong> <?= htmlspecialchars($faq['answer']) ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<section>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////
                              START SECTION 7 - THE PORTFOLIO  
//////////////////////////////////////////////////////////////////////////////////////////////////////-->

<section id="portfolio" class="portfolio">
  <div class="container">
    <div class="row text-center">
      <h1 class="display-3 fw-bold text-uppercase">portfolio</h1>
      <div class="heading-line"></div>
      <p class="lead">Check out some of our recent projects</p>
    </div>

    <?php
    try {
        $query = "SELECT project_name, description, image_url, project_link FROM portfolio";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo '<p class="text-danger">Error fetching portfolio items: ' . $e->getMessage() . '</p>';
        $projects = [];
    }
    ?>

    <div class="row mt-5">
      <?php if (!empty($projects)): ?>
        <?php foreach ($projects as $project): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="portfolio-box shadow">
              <img src="<?= htmlspecialchars($project['image_url']) ?>" 
                   alt="<?= htmlspecialchars($project['project_name']) ?> image" 
                   title="<?= htmlspecialchars($project['project_name']) ?>" 
                   class="img-fluid border rounded">
              <div class="portfolio-info p-3">
                <div class="caption">
                  <h4><?= htmlspecialchars($project['project_name']) ?></h4>
                  <p><?= htmlspecialchars($project['description']) ?></p>
                  <?php if (!empty($project['project_link'])): ?>
                    <a href="<?= htmlspecialchars($project['project_link']) ?>" 
                       target="_blank" 
                       class="btn btn-primary btn-sm mt-2">View Project</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center">No portfolio items available at the moment. Please check back later.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////
                           START SECTION  - THE FOOTER  
///////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="contact" class="contact bg-light py-5">
  <div class="container">
    <div class="row text-center">
      <h1 class="display-4 fw-bold">Contact Messages</h1>
      <hr style="width: 100px; height: 3px; background-color: #000;" class="mx-auto">
      <p class="lead pt-3">
        Here are the messages we've received from our valued users. Feel free to get in touch with us anytime!
      </p>
    </div>

    <?php
      $query = "SELECT name, email, message FROM contact";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="row mt-4">
      <?php if (!empty($contacts)): ?>
        <?php foreach ($contacts as $contact): ?>
          <div class="col-md-6 mb-4">
            <div class="card shadow">
              <div class="card-body">
                <h5 class="card-title"><strong>Name:</strong> <?= htmlspecialchars($contact['name']) ?></h5>
                <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($contact['email']) ?></p>
                <p class="card-text"><strong>Message:</strong> <?= nl2br(htmlspecialchars($contact['message'])) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-md-12 text-center">
          <p class="text-muted">No messages have been received yet.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>



<!-- ///////////////////////////////////////////////////////////////////////////////////////////
                           START SECTION 8 - THE FOOTER  
///////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="footer" class="footer bg-dark text-light py-5">
  <div class="container-fluid"> <!-- Changed to container-fluid for full width -->
    <div class="row text-center">
      <h1 class="display-4 fw-bold">Links</h1>
      <hr style="width: 100px; height: 3px; background-color: #fff;" class="mx-auto">
      <p class="lead pt-3">
        Here are some important links and contact information. Feel free to reach out!
      </p>
    </div>

    <?php
      // Query to fetch footer data
      $query = "SELECT footer_content, social_links FROM footer";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $footerItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="row mt-4">
      <?php if (!empty($footerItems)): ?>
        <?php foreach ($footerItems as $item): ?>
          <div class="col-md-4 mb-4">
            <div class="card shadow">
              <div class="card-body">
                <?php if (!empty($item['social_links'])): ?>
                  <a href="<?= htmlspecialchars($item['social_links']) ?>" class="card-link" target="_blank"><?= htmlspecialchars($item['footer_content']) ?></a>
                <?php else: ?>
                  <p class="card-text"><?= htmlspecialchars($item['footer_content']) ?></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-md-12 text-center">
          <p class="text-muted">No footer items available yet.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="row text-center mt-5">
      <div class="col-md-12">
        <p>&copy; 2025 Selam. All Rights Reserved.</p>
        <p><a href="privacy-policy.php" class="text-light">Privacy Policy</a> | <a href="terms-of-service.php" class="text-light">Terms of Service</a></p>
      </div>
    </div>
    <hr>
    <div class="row text-left mt-5">
      <div class="col-md-12">
        <p><a href="../admin/login.php" class="text-light">Are you admin(selam,selam)</a></p>
      </div>
    </div>
</section>





<!-- BACK TO TOP BUTTON  -->
<a href="#" class="shadow btn-primary rounded-circle back-to-top">
  <i class="fas fa-chevron-up"></i>
</a>



   
    <script src="assets/vendors/js/glightbox.min.js"></script>

    <script type="text/javascript">
      const lightbox = GLightbox({
        'touchNavigation': true,
        'href': 'https://www.youtube.com/watch?v=J9lS14nM1xg',
        'type': 'video',
        'source': 'youtube', //vimeo, youtube or local
        'width': 900,
        'autoPlayVideos': 'true',
});
    
    </script>
     <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>