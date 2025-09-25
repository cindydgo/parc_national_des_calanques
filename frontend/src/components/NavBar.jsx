import { NavLink } from "react-router-dom";
import "../assets/css/NavBar.css";

const NavBar = () => (
    <nav className="navbar">
        <ul>
            <li><NavLink to="/home">Accueil</NavLink></li>
            <li><NavLink to="/locations">Test de locations</NavLink></li>
            <li><NavLink to="/locations/3">Test de location avec ID</NavLink></li>
        </ul>
    </nav>
);

export default NavBar;