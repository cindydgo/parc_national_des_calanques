import { useState } from 'react';
import { AuthContext } from './AuthContext';

export const AuthProvider = ({ children }) => {
    const loginURL = 'http://localhost:8000/?resource=auth&action=loginApi';
    const logoutURL = 'http://localhost:8000/?resource=auth&action=logoutApi';
    const [user, setUser] = useState(null);

    const login = async (email, password) => {
        const response = await fetch(loginURL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password }),
            credentials: 'include',
        });

        if (!response.ok) {
            throw new Error('Erreur de connexion');
        }

        const data = await response.json();
        
        setUser(data.data.user);
    };

    const logout = async () => {
        const response = await fetch(logoutURL, {
        method: 'POST',
        credentials: 'include',
        });
        
        if (!response.ok) {
            throw new Error('Erreur de déconnexion');
        }

        setUser(null);
    };

    return (
        <AuthContext.Provider value={{ user, login, logout }}>
            {children}
        </AuthContext.Provider>
    );
}

//loading, setLoading could be added for better UX