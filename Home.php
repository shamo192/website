<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit - Municipality of Burgos</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F5F5F5;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #9BB8CD;
            padding: 4px 20px; /* Reduced padding for a slimmer header */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 5px; /* Adjusted margin */
        }

        #img {
            width: 60px; /* Adjusted size for the logo */
            height: 60px;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-right: 10px;
        }

        #title-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1, h2 {
            margin: 0;
            font-size: 12px; /* Adjusted font size for a slimmer look */
            text-align: center;
        }

        #navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5px; /* Adjusted margin */
        }

        #navigation a {
            text-decoration: none;
            color: #fff;
            margin: 0 5px;
            font-size: 14px; /* Adjusted font size */
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center; /* Center vertically */
            text-align: center;
            padding: 100px 15px 50px; /* Space for header and footer */
            box-sizing: border-box;
        }

        .content-body {
            background-color: #fff; /* White background for contrast */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 800px; /* Limit the width for readability */
            max-height: 400px; /* Limit the height to avoid overflow */
            overflow-y: auto; /* Add scroll if content overflows */
            color: #333; /* Dark text for better readability */
        }

        .intro-container {
            line-height: 1.6; /* Improved line height for readability */
        }

        h1, h2 {
            color: #405D72; /* Darker color for headings */
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px; /* Larger size for main heading */
        }

        h2 {
            font-size: 20px; /* Slightly smaller for subheading */
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #758694;
            padding: 0px 0;
            text-align: center;
            color: #fff;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }

        /* Media query for responsive design */
        @media (min-width: 768px) {
            #header {
                padding: 10px 40px; /* Slightly increased for larger screens */
            }

            #img {
                width: 80px; /* Increase size for larger screens */
                height: 80px;
            }

            h1, h2 {
                font-size: 14px; /* Adjusted font size for larger screens */
            }

            #navigation a {
                font-size: 16px; /* Adjusted font size for larger screens */
                margin: 0 10px;
            }

            .content-body {
                padding: 30px;
            }

            h1 {
                font-size: 28px; /* Increase size for larger screens */
            }

            h2 {
                font-size: 24px; /* Increase size for larger screens */
            }
        }
    </style>
</head>
<body>
    <div id="header">
        <div id="logo-container">
            <img src="logoofburgos.png" id="img" alt="Logo">
            <div id="title-container">
                <h1>RURAL HEALTH UNIT OF THE</h1>
                <h2>MUNICIPALITY OF BURGOS</h2>
            </div>
        </div>
        <div id="navigation">
            <a href="">Help</a>
            <a href="aboutus.php">About us</a>
            <a href="login.php">Log in</a>
        </div>
    </div>
    
    <div class="container">
        <div class="content-body">
            <h1>Welcome to the Rural Health Unit!</h1>
            <h2>Introducing the Patient Record Management System (PRMS)</h2>
            <div class="intro-container">
                <p>
                    The Patient Record Management System (PRMS) is designed to streamline the management of patient information within healthcare settings. By enabling healthcare providers to efficiently store, retrieve, and analyze vital patient data, PRMS ensures high-quality care and enhances communication between healthcare professionals and patients.
                </p>
                <p>
                    This system facilitates easy access to medical histories and treatment plans while maintaining strict security protocols to protect patient privacy. Additionally, PRMS is equipped with analytical tools that support data-driven decision-making, allowing organizations to track patient outcomes and improve operational efficiency.
                </p>
                <p>
                    Ultimately, PRMS enhances healthcare delivery and fosters collaboration among providers, ensuring that patients receive the best possible care.
                </p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Municipality of Burgos. All Rights Reserved.</p>
        <p>
            <a href="privacypoli.php">Privacy Policy</a> | 
            <a href="termsofservice.php">Terms of Service</a> | 
            <a href="contactus.php">Contact Us</a>
        </p>
    </footer>
</body>
</html>
