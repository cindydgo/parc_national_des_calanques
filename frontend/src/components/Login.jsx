import { useForm } from 'react-hook-form';
import { useAuth } from '../Context/AuthContext';
import { useNavigate } from 'react-router-dom';
import { useEffect } from 'react';

function LoginComponent() {
    const { register, handleSubmit } = useForm();
    const { user, login } = useAuth();
    const navigate = useNavigate();

    const onSubmit = async (data) => {
        try {
            await login(data.email, data.password);
        } catch (error) {
            alert(error.message);
        }
    };

    useEffect(() => {
        if (user) {
            navigate('/');
        }
    }, [user, navigate]);

    return (
        <form onSubmit={handleSubmit(onSubmit)}>
            <h1>Connexion</h1>
            <input type="email" {...register('email')} placeholder="Email" required />
            <input type="password" {...register('password')} placeholder="Mot de passe" required />
            <button type="submit">Se connecter</button>
        </form>
    );
}

export default LoginComponent;
