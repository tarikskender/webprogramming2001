window.onload = () => {

  document.getElementById("signInButton").addEventListener('click', async (e) => {

    e.preventDefault();

    const email = document.querySelector('#exampleInputEmail1').value;
    const password = document.querySelector('#exampleInputPassword1').value;

    const res = await fetch('http://localhost:8000/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password })
    });

    const result = await res.json();

    if (res.ok) {
      alert('Login successful!');
      window.location.href = './index.html';
    } else {
      alert(result.error || 'Login failed');
    }
  });
};