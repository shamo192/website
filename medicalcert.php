<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Certificate</title>
    
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative; /* For positioning child elements */
        }

        /* Certificate container styling */
        .certificate-container {
            background-color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 90%;
            position: relative; /* Position relative to its normal position */
            z-index: 1; /* Ensure it's above the buttons */
        }

        /* Image inside the certificate */
        .certificate-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        /* Button styling */
        .button {
            display: inline-block;
            font-size: 16px;
            padding: 12px 24px;
            color: white;
            background: linear-gradient(90deg, #007BFF, #0056b3);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            position: fixed;
            z-index: 2; /* Ensure buttons are above other content */
        }

        /* Print Button */
        .print-button {
            top: 10px;
            right: 10px;
        }

        /* Back Button */
        .back-button {
            top: 10px;
            left: 10px;
        }

        /* Hover effects */
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Hide everything except the certificate during printing */
        @media print {
            body {
                background-color: white;
                height: auto;
            }

            .print-button, .back-button {
                display: none; /* Hide buttons when printing */
            }

            .certificate-container {
                box-shadow: none;
                margin: 0;
                width: 100%;
                border: none;
            }
        }
    </style>
</head>

<body>

    <!-- Print Button -->
    <button class="button print-button" onclick="window.print()">🖨 Print Certificate</button>

    <!-- Back Button -->
    <a class="button back-button" href="OPD.php">&#9166; Back</a>

    <!-- Certificate Container -->
    <div class="certificate-container">
        <img src="medicalcert.jpg" alt="Medical Certificate">
    </div>

</body>
</html>
