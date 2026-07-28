import { useForm } from "react-hook-form"
import { useAuth } from "../Context/AuthContext"
import { useNavigate } from "react-router-dom"
import { useEffect } from "react"
import '../assets/css/Register.css'

function RegisterComponent() {
    const { register, handleSubmit } = useForm();
    const { user, login } = useAuth();
    const navigate = useNavigate();

    const URL = "http://localhost:8000/?resource=auth&action=registerApi";

    const onSubmit = async (data) => {
        const response = await fetch(URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                username: data.username,
                email: data.email,
                password: data.password
            }),
            credentials: "include",
        });

        if (!response.ok) throw new Error("Erreur lors de l'inscription");

        await login(data.email, data.password);
    };

    useEffect(() => {
        if (user) {
            navigate("/");
        }
    }, [user, navigate]);

    return (
        <div className="form-container d-flex justify-content-center vh-100">
            <form onSubmit={handleSubmit(onSubmit)} className="register-form d-flex flex-column gap-3 m-5 px-4 py-2 w-100">
                <h1 className="m-3">Inscription</h1>
                <input 
                    type="text" {...register('username')} 
                    placeholder="Username"
                    className="form-control rounded-lg"
                    required
                />
                <input 
                    type="email" {...register('email')} 
                    placeholder="Email" 
                    className="form-control rounded-lg"
                    required
                />
                <input 
                    type="password" {...register('password')} 
                    placeholder="Password"
                    className="form-control rounded-lg"
                    required 
                />
                <button type="submit" className="btn btn-custom my-2 fw-semibold">S'inscrire</button>
            </form>
        </div>
    );
}

export default RegisterComponent;

