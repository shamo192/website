<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F5F5F5;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        #container {
            background-color: #fff; /* White background for contrast */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 800px; /* Limit the width for readability */
            text-align: center;
        }

        h1 {
            font-size: 24px; /* Larger size for the main heading */
            color: #405D72; /* Darker color for headings */
        }

        p {
            line-height: 1.6; /* Improved line height for readability */
            margin: 10px 0;
        }

        .back-button {
            background-color: #9BB8CD;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #758694; /* Darken the button on hover */
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Welcome to Our Patient Record Management System (PRMS)</h1>
        <p>
            We are fourth-year students of Saint Ferdinand College, and welcome to our capstone project. PRMS is developed by a group of dedicated students, reflecting our passion for learning and commitment to creating practical solutions that address real-world challenges. Our system aims to help the Rural Health Unit (RHU) in Burgos, Isabela, to improve patient management, streamline data tracking, and enhance service delivery, offering a user-friendly and efficient platform.
        </p>
        <p>
            Throughout this journey, we applied the knowledge and skills gained during our studies to build a responsive, accessible, and reliable system. More than just a requirement for graduation, this project represents our drive to make a meaningful contribution to the community and prepare ourselves for future careers.
        </p>
        <p>
            Thank you for taking the time to explore our work and be part of our journey!
        </p>
        <a href="home.php" class="back-button">Back to Home</a>
    </div>
</body>
</html>
