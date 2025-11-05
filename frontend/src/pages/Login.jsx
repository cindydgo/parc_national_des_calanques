/* import { useState } from 'react';
import { useAuth } from '../Context/useAuth.jsx';

function Login() {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const { login } = useAuth();

    const handleSubmit = (event) => {
        event.preventDefault();
        const token = 'fake-token';  // Simuler l'obtention d'un token d'authentification
        login(token);
    };

    return (
        <form onSubmit={handleSubmit}>
        <label>
            Username:
            <input type="text" value={username} onChange={(e) => setUsername(e.target.value)} />
        </label>
        <label>
            Password:
            <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} />
        </label>
        <button type="submit">Log In</button>
        </form>
    );
}

export default Login;

/* maj pour react-router-dom v6
import React, { useState, useEffect } from 'react';
import { useAuth } from '../Context/AuthContext';
import { useNavigate } from 'react-router-dom';

function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const { authToken, login } = useAuth();
  const navigate = useNavigate();

  const handleSubmit = (event) => {
    event.preventDefault();
    login('fake-token');
  };

  // Effect pour écouter les changements sur authToken
  useEffect(() => {
    if (authToken) {
      navigate('/home');
    }
  }, [authToken, navigate]);

  return (
    <form onSubmit={handleSubmit}>
      <input type="text" value={username} onChange={(e) => setUsername(e.target.value)} />
      <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} />
      <button type="submit">Log In</button>
    </form>
  );
}

export default Login;
 */ 
const Login = () => {
    return <h1>login Page</h1>;
}

export default Login;