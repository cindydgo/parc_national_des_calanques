import { Routes, Route, Link } from "react-router-dom";
import Home from "./pages/Home";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Dashboard from "./pages/Dashboard";

export default function App() {
    return (
        <div>
        <nav>
            <Link to="/">Accueil</Link> |{" "}
            <Link to="/login">Connexion</Link> |{" "}
            <Link to="/register">Inscription</Link> |{" "}
            <Link to="/dashboard">Tableau de bord</Link>
        </nav>

        <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />
            <Route path="/dashboard" element={<Dashboard />} />
        </Routes>
    </div>
    );
}
