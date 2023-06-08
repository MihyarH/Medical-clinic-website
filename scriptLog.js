// Switch form functionality
const switchFormLink = document.getElementById('switch-form-link');
switchFormLink.addEventListener('click', function(e) {
  e.preventDefault();
  const loginForm = document.getElementById('login-form');
  
  if (loginForm.classList.contains('signup-form')) {
    // Transform the signup form into a login form
    loginForm.classList.remove('signup-form');
    document.querySelector('h2').textContent = 'Login';
    document.querySelector('button').textContent = 'Login';
    this.textContent = 'Sign up';
    hidePasswordStrengthMeter();
  } else {
    // Transform the login form into a signup form
    loginForm.classList.add('signup-form');
    document.querySelector('h2').textContent = 'Sign up';
    document.querySelector('button').textContent = 'Sign up';
    this.textContent = 'Back to Login';
    showPasswordStrengthMeter();
  }
});

// Switch to forgot password form functionality
const forgotPasswordLink = document.getElementById('forgot-password-link');
forgotPasswordLink.addEventListener('click', function(e) {
  e.preventDefault();
  const loginForm = document.getElementById('login-form');
  
  if (loginForm.classList.contains('forgot-password-form')) {
    // Transform the forgot password form into the login form
    loginForm.classList.remove('forgot-password-form');
    document.querySelector('h2').textContent = 'Login';
    document.querySelector('button').textContent = 'Login';
    switchFormLink.style.display = 'inline';
    this.textContent = 'Forgot password?';
  } else {
    // Transform the login form into the forgot password form
    loginForm.classList.add('forgot-password-form');
    document.querySelector('h2').textContent = 'Forgot Password';
    document.querySelector('button').textContent = 'Reset Password';
    switchFormLink.style.display = 'none';
    this.textContent = 'Back to Sign Up';
  }
});

// Function to show the password strength meter
function showPasswordStrengthMeter() {
  const passwordStrengthMeter = document.querySelector('#password-strength-meter');
  passwordStrengthMeter.style.display = 'block';
}

// Function to hide the password strength meter
function hidePasswordStrengthMeter() {
  const passwordStrengthMeter = document.querySelector('#password-strength-meter');
  passwordStrengthMeter.style.display = 'none';
}

// Password strength meter functionality
const passwordInput = document.getElementById('password');
const passwordStrengthMeter = document.querySelector('#password-strength-meter .meter');
const passwordStrengthMessage = document.querySelector('#password-strength-meter .message');

passwordInput.addEventListener('input', function() {
  const password = this.value;
  const strength = calculatePasswordStrength(password);
  const meterWidth = strength * 25 + '%';
  const meterColor = getMeterColor(strength);
  const strengthMessage = getStrengthMessage(strength);

  passwordStrengthMeter.style.width = meterWidth;
  passwordStrengthMeter.style.backgroundColor = meterColor;
  passwordStrengthMessage.textContent = strengthMessage;
});

// Function to calculate password strength
function calculatePasswordStrength(password) {
  // Calculate the password strength based on your desired logic
  // Here's a simple example based on the password length
  const length = password.length;

  if (length < 5) {
    return 0; // Very Weak
  } else if (length < 8) {
    return 1; // Weak
  } else if (length < 12) {
    return 2; // Medium
  } else if (length < 16) {
    return 3; // Strong
  } else {
    return 4; // Very Strong
  }
}

// Function to get meter color
function getMeterColor(strength) {
  // Map the strength level to a corresponding color
  // Customize the color codes based on your preference
  switch (strength) {
    case 0:
      return '#ff0000'; // Very Weak: Red
    case 1:
      return '#ff8c00'; // Weak: Orange
    case 2:
      return '#ffd700'; // Medium: Gold
    case 3:
      return '#32cd32'; // Strong: Lime Green
    case 4:
      return '#008000'; // Very Strong: Dark Green
    default:
      return '#808080'; // Default color for unknown levels
  }
}

// Function to get strength message
function getStrengthMessage(strength) {
  // Map the strength level to a corresponding message
  switch (strength) {
    case 0:
      return 'Very Weak';
    case 1:
      return 'Weak';
    case 2:
      return 'Medium';
    case 3:
      return 'Strong';
    case 4:
      return 'Very Strong';
    default:
      return 'Unknown';
  }
}


// Function to handle form submission
function handleSubmit(event) {
  event.preventDefault();

  // Get the input values
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  // Simulate checking the username and password
  const isUsernameValid = checkUsername(username);
  const isPasswordValid = checkPassword(password);

  if (isUsernameValid && isPasswordValid) {
    // If username and password exist in the database, proceed with login
    alert('Login successful!');
    // Add your logic for redirecting or further actions here
  } else {
    // If username or password doesn't exist in the database, display error message
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = 'Invalid username or password.';
    errorMessage.style.display = 'block';
  }
}

// Function to simulate checking the username
function checkUsername(username) {
  // Simulate checking the username in the database
  // Replace this with your own logic to check against the actual database
  // Return true if username exists, false otherwise
  return username === 'admin';
}

// Function to simulate checking the password
function checkPassword(password) {
  // Simulate checking the password in the database
  // Replace this with your own logic to check against the actual database
  // Return true if password exists, false otherwise
  return password === 'password';
}

// Add event listener to the form
const loginForm = document.getElementById('login-form');
loginForm.addEventListener('submit', handleSubmit);
