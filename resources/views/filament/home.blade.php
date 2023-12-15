<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Probike Motorstar Online</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400,700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header, nav, section, footer {
            padding: 1em;
        }

        header {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
        }

        nav {
            background-color: #34495e;
            color: #fff;
            text-align: center;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 1em;
            margin: 0 1em;
            display: inline-block;
        }

        section {
            background-color: #fff;
            margin: 1em;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        section h2 {
            color: #3498db;
        }

        section p {
            color: #555;
        }

        footer {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0px -4px 4px rgba(0, 0, 0, 0.1);
        }

        @media only screen and (max-width: 600px) {
            nav a {
                display: block;
                width: 100%;
                box-sizing: border-box;
                margin: 0;
                padding: 1em 0;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Probike Motorstar Online</h1>
        <p>Your destination for quality motorcycles.</p>
    </header>

    <nav>
        <a href="#home">Home</a>
        <a href="#models">Models</a>
        <a href="#gallery">Gallery</a>
        <a href="#contact">Contact</a>
        <a href="customer">Login</a>
    </nav>

    <section id="home">
        <h2>Welcome to Probike Motorstar Online</h2>
        <p>Explore our collection of high-performance motorcycles designed for enthusiasts like you.</p>
    </section>

    <section id="models">
        <h2>Our Models</h2>
        <p>Discover our range of motorcycles, each crafted for a unique riding experience.</p>
        <!-- Add more content and images for each model -->
    </section>

    <section id="gallery">
        <h2>Gallery</h2>
        <p>Check out the stunning images of our motorcycles in action.</p>
        <!-- Add an image gallery -->
    </section>

    <section id="contact">
        <h2>Contact Us</h2>
        <p>Have questions or want to learn more? Reach out to us.</p>
        <!-- Add a contact form or contact information -->
    </section>

    <footer>
        <p>&copy; 2023 Probike Motorstar Online. All rights reserved.</p>
    </footer>

</body>
</html>
