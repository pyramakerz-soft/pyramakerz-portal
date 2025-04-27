<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    
    <form id="registration-form" action="{{ route('register-student') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2>👤 Personal Information</h2>
        <label>
            <span>Name:</span>
            <input type="text" name="name" placeholder="Enter your name" required />
        </label>
        <label>
            <span>Email:</span>
            <input type="email" name="email" placeholder="Enter your email" required />
        </label>
        <label>
            <span>Phone:</span>
            <input type="tel" name="phone" placeholder="Enter your phone number" required />
        </label>
        <label>
            <span>Password:</span>
            <input type="password" name="password" placeholder="Create a password" required />
        </label>
        <label>
            <span>Gender:</span>
            <select name="gender" required>
                <option value="" disabled selected>Select your gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </label>
        <label>
            <span>Birthday:</span>
            <input type="date" name="bday" required />
        </label>
        <button type="submit" class="fun-btn submit-btn">✅ Register</button>
    </form>
</body>
</html>
