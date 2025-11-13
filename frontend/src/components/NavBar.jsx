import { NavLink } from "react-router-dom";
import "../assets/css/Navbar.css";

const NavBar = () => (
    <nav className="navbar">
        <ul>
            <li>
                <NavLink
                    to="/"
                    className={({ isActive }) =>
                    isActive ? "active" : ""
                    }
                >Accueil
                </NavLink>
            </li>
            <li>
                <NavLink
                    to="/sentiers"
                    className={({ isActive }) =>
                    isActive ? "active" : ""
                    }
                >Sentiers
                </NavLink>
            </li>
            <li>
                <NavLink
                    to="/resources"
                    className={({ isActive }) =>
                    isActive ? "active" : ""
                    }
                >Ressources
                </NavLink>
            </li>
            <li>
                <NavLink
                    to="/"
                    className={({ isActive }) =>
                    isActive ? "active" : ""
                    }
                >Campings
                </NavLink>
            </li>
            <li>
                <NavLink
                    to="/login"
                    className={({ isActive }) =>
                    isActive ? "active" : ""
                    }
                >Se connecter
                </NavLink>
            </li>
            <li>
                <NavLink
                    to="/register"
                    className={({ isActive }) =>
                    isActive ? "active" : ""
                    }
                >S'inscrire
                </NavLink>
            </li>
        </ul>
    </nav>
);

export default NavBar;

/*  export default function CategoryProduct() {
    let { categoryId, productId } = useParams();
  // ...
} */