import { useForm } from 'react-hook-form';
import { useAuth } from '../Context/AuthContext';
import { Link } from 'react-router-dom';
import { useNavigate } from 'react-router-dom';
import { useEffect } from 'react';
import '../assets/css/Login.css';

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
        <div className='form-container d-flex justify-content-center vh-100'>
            <form onSubmit={handleSubmit(onSubmit)} className='login-form d-flex flex-column gap-3 m-5 px-4 py-2 w-100'>
                <h1 className='m-3'>Connexion</h1>
                <input 
                    type="email" {...register('email')} 
                    placeholder="Email"
                    className="form-control rounded-lg"    
                    required 
                />
                <input 
                    type="password" {...register('password')} 
                    placeholder="Mot de passe" 
                    className="form-control rounded-lg"
                    required 
                />
                <button type="submit" className='btn btn-custom my-2 fw-semibold'>Se connecter</button>
                <p>
                    Si vous n'avez pas encore de compte,&nbsp;
                    <Link to="/register">cliquez ici</Link>
                </p>
            </form>
        </div>
    );
}

export default LoginComponent;
