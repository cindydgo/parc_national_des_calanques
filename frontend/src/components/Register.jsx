import { useForm } from "react-hook-form"
import { useAuth } from "../Context/AuthContext"
import { useNavigate } from "react-router-dom"
import { useEffect } from "react"

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
            password: data.password,
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
        <form onSubmit={handleSubmit(onSubmit)}>
            <h1>Inscription</h1>
            <input type="text" {...register('username')} placeholder="Username" />
            <input type="email" {...register('email')} placeholder="Email" />
            <input type="password" {...register('password')} placeholder="Password" />
            <button type="submit">S'inscrire</button>
        </form>
    );
}

export default RegisterComponent;

