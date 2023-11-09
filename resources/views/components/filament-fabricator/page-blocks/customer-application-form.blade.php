@aware(['page'])
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/own/application.css') }}" />
        @filamentStyles
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased"> 
        @filamentScripts
        @vite('resources/js/app.js')
        @livewire('notifications')

        <header>
        </ul>
          <!-- User registration and menu icon -->
          <div class="main">
            <a href="#" class="user"
              >Log In<i class="ri-account-circle-fill"></i
            ></a>
            <div class="ri-menu-line" id="menu-icon"></div>
          </div>
        </header>
    
        <main>
          <section id="Content1">
              <img src="{{ env('APP_URL') . 'images/application_page_heading_image.jpg' }}" alt="section1-image-bg" />
              <div class="tagline-text">
                <h2 class="animate">Application</h2>
                <p class="contact-desc">
                    Rev up your career and apply today to join our motorcycle-loving team, where passion and innovation drive us forward. See requirements below and take the first step toward an exciting journey with us.
                </p>
                <div class="buttons">
                  <button class="inquire-button" onclick="toggleInquireSection()">
                   SEE REQUIREMENTS
                  </button>
                  <button class="inquire-button" onclick="toggleApplicationSection()">
                    SEND APPLICATION
                  </button>
                </div>
              </div>
            </div>
          </section>
    
          <section id="Content2">
            <div class="heading">
              <h1 class="Title">REQUIREMENTS:</h1>
              <p class="content">
                Gear up with the essentials - the road to success begins here, armed
                with all the requirements you need.
              </p>
            </div>
            <div class="container">
                  <div class="specs-content">
                    <div class="specs-title">Requirements 1</div>
                  </div>
                  <div class="specs-content">
                    <div class="specs-title">Requirements 2</div>
                  </div>
                  <div class="specs-content">
                    <div class="specs-title">Requirements 3</div>
                  </div>
                  <div class="specs-content">
                    <div class="specs-title">Requirements 4</div>
                  </div>
                  <div class="specs-content">
                    <div class="specs-title">Requirements 5</div>
                  </div>
                  <div class="specs-content">
                    <div class="specs-title">BRequirements 6</div>
                  </div>
                  <div class="specs-content">
                    <div class="specs-title">Requirements 7</div>
                  </div>
              </div>
          </section>
    
            <section id="Content3">
                <h2>PROBIKES MOTORCYLE CENTER</h2>
                <p>Howard Tower Corner 6th Ave., Caloocan City</p>
                <p>Tel. No. 362-9946</p>
            </section>
      <h3>UNIT TO BE FINANCED</h3>
        <form>
            @livewire('application-form')
        </form>
    
        <!--Footer Design-->
        <footer>
          <div class="content">
            <div class="row1 box">
              <div class="upper">
                <div class="topic">BrandName</div>
                <p>
                  Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet,
                  deleniti enim eum itaque voluptas saepe provident atque voluptate
                  tempore deserunt at exercitationem soluta.
                </p>
              </div>
            </div>
    
            <div class="row2 box">
              <li><a href="../html/index.html">Home</a></li>
              <li><a href="../html/products.html">Products</a></li>
              <li><a href="../html/application.html">Application</a></li>
              <br />
              <li><a href="../html/privacy-policy.html">Privacy Policy</a></li>
              <li><a href="../html/Terms-and-condition.html">Terms &amp Condition</a></li>
              <li><a href="../html/contact.html">FAQs</a></li>
            </div>
    
            <div class="row3 box">
              <div class="topic">Contact us</div>
              <div class="phone">
                <a href="#"><i class="ri-phone-fill"></i>+6391234567</a>
              </div>
              <div class="email">
                <a href="#"><i class="ri-mail-fill"></i>group5@email.com</a>
              </div>
              <div class="address">
                <a href="#"><i class="ri-navigation-fill"></i>Lian, Batangas</a>
              </div>
            </div>
    
            <div class="row4 box">
              <div class="topic">Sign up to our Newsletter</div>
              <form action="#">
                <input type="text" placeholder="Enter email address" required="" />
                <input type="submit" name="" value="Send" />
                <div class="media-icons">
                  <a href="http://facebook.com" target="_blank"
                    ><i class="ri-facebook-fill ri-1x"></i
                  ></a>
                  <a href="http://instagram.com" target="_blank"
                    ><i class="ri-instagram-fill ri-1x"></i
                  ></a>
                  <a href="http://twitter.com" target="_blank"
                    ><i class="ri-twitter-fill ri-1x"></i
                  ></a>
                  <a href="http://messenger.com" target="_blank"
                    ><i class="ri-messenger-fill ri-1x"></i
                  ></a>
                </div>
              </form>
            </div>
          </div>
          <div class="bottom">
            <p>Copyright © 2023 <span>BrandName</span> Made by Group5</p>
          </div>
        </footer>
    
        <!--JS Link-->
        <script type="text/javascript" src="../javascript/script.js"></script>


    </body>
        
</html>
