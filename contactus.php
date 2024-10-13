<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body {
      background-color: #f8f9fa;
    }
    .contact-container {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      position: relative;
    }
    .form-label {
      font-weight: 500;
    }
    .btn-custom {
      background-color: #007bff;
      color: white;
    }
    .btn-custom:hover {
      background-color: #0056b3;
    }
    .intro-text {
      font-size: 1rem;
      color: #6c757d;
      margin-bottom: 20px;
      text-align: center;
    }
    .btn-back {
        background-color: #9BB8CD;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
            position: fixed;
      top: 15px;
      left: 15px;
    }
    .btn-back:hover {
      background-color: #495057;
    }
  </style>
</head>
<body>

  <div class="container contact-container">
    <a href="home.php" class="btn btn-back btn-sm">←Back</a>
    <h2 class="text-center mb-3">Contact Us</h2>
    <p class="intro-text">
      If you encounter any issues or have questions, please don't hesitate to get in touch with us.  
      We are here to assist you and ensure a smooth experience with our system.
    </p>
    <form action="process_contact.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-custom btn-lg">Send Message</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
