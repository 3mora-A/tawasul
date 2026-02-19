function toggleForm() {
  document.getElementById('login-form').classList.toggle('hidden');
  document.getElementById('signup-form').classList.toggle('hidden');
  document.getElementById('forgot-password-form').classList.add('hidden');
}

function toggleForgotPasswordForm() {
  document.getElementById('login-form').classList.add('hidden');
  document.getElementById('signup-form').classList.add('hidden');
  document.getElementById('forgot-password-form').classList.remove('hidden');
}

function backToLogin() {
  document.getElementById('forgot-password-form').classList.add('hidden');
  document.getElementById('login-form').classList.remove('hidden');
}






function validateForm(event) {
  console.log('validateForm ran');
  event.preventDefault(); // Prevent immediate submission

  const alertBox = document.getElementById('alert');
  alertBox.innerHTML = '';

  const password = document.getElementById('password').value.trim();
  const confirmPassword = document.getElementById('confirmPassword').value.trim();

  let errorMessages = [];

  if (password.length < 8) {
    errorMessages.push('Password must be at least 8 characters long.');
  }
  if (!/[A-Z]/.test(password)) {
    errorMessages.push('Password must contain at least one uppercase letter.');
  }
  if (!/[a-z]/.test(password)) {
    errorMessages.push('Password must contain at least one lowercase letter.');
  }
  if (!/\d/.test(password)) {
    errorMessages.push('Password must contain at least one number.');
  }
  if (!/[@$!%*?&]/.test(password)) {
    errorMessages.push('Password must contain at least one special character (@, $, _, etc).');
  }
  if (password !== confirmPassword) {
    errorMessages.push('Passwords do not match!');
  }

  if (errorMessages.length > 0) {
    alertBox.innerHTML = errorMessages.join('<br>');
    alertBox.style.color = 'red';
    return false;
  }

  // ✅ Submit the form manually if no errors
  event.target.submit();
}
