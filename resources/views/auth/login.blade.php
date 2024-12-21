<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fun Portal</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">

    <style>
        body {
            font-family: 'Comic Sans MS', 'Comic Sans', cursive;
            background-color: #f0f8ff;
            overflow: hidden;
        }

        #app {
            position: relative;
            text-align: center;
            padding: 50px;
        }



        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }


        form {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
            text-align: left;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 2rem;
            color: #ff6347;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            background: #ff6347;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover {
            transform: scale(1.05);
        }

        .footer-text {
            margin-top: 20px;
            color: #888;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Floating Clouds and Stars -->
        <div class="floating-cloud cloud-5"></div>
        <div class="floating-star cloud-6"></div>
        <div class="floating-cloud cloud-7"></div>
        <div class="floating-star cloud-8"></div>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <h1>Welcome Back! 🌟</h1>
            <p>Ready to continue your coding adventure?</p>

            <center><label for="email">📧 Email:</label></center>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>

            <center><label for="password">🔒 Password:</label></center>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>

            <button type="submit" class="fun-btn">Login ➡️</button>
        </form>

        <!-- Footer -->
        <div class="footer-text">
            Not a member? <a href="{{ route('home') }}">Join the fun now!</a>
        </div>
    </div>
</body>

</html>
