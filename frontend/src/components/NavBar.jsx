import { NavLink } from "react-router-dom";
import { useAuth } from "../Context/AuthContext";
import LogoutComponent from "./Logout";
import "../assets/css/Navbar.css";

const NavBar = () => {
    const {user} = useAuth();

    return (
        <div className="d-flex w-100">
            { user ?
            <nav className="navbar w-100 ">
                <div className="d-flex w-100 justify-content-center align-items-center gap-4">
                    <ul className="list-unstyled d-flex gap-4 ps-0 mb-0">
                        <li>
                            <NavLink
                                to="/"
                                className={({ isActive }) =>
                                    `navlink-custom${isActive ? " active" : ""}`
                                }
                            >Accueil
                            </NavLink>
                        </li>
                        <li>
                            <NavLink
                                to="/sentiers"
                                className={({ isActive }) =>
                                    `navlink-custom${isActive ? " active" : ""}`
                                }
                            >Sentiers
                            </NavLink>
                        </li>
                        <li>
                            <NavLink
                                to="/resources"
                                className={({ isActive }) =>
                                    `navlink-custom${isActive ? " active" : ""}`
                                }
                            >Ressources
                            </NavLink>
                        </li>
                        <li>
                            <NavLink
                                to="/campings"
                                className={({ isActive }) =>
                                    `navlink-custom${isActive ? " active" : ""}`
                                }
                            >Campings
                            </NavLink>
                        </li>
                        <li>
                            <NavLink
                                to="/dashboard"
                                className={({ isActive }) =>
                                    `navlink-custom${isActive ? " active" : ""}`
                                }
                            >Tableau de bord
                            </NavLink>
                        </li>
                    </ul>
                    <LogoutComponent />
                </div>
            </nav>
            :  
            <nav className="navbar d-flex justify-content-center align-items-center w-100">
                <ul className="list-unstyled d-flex gap-4 ps-0 mb-0">
                    <li>
                        <NavLink
                            to="/"
                            className={({ isActive }) =>
                                `navlink-custom${isActive ? " active" : ""}`
                            }
                        >Accueil
                        </NavLink>
                    </li>
                    <li>
                        <NavLink
                            to="/sentiers"
                            className={({ isActive }) =>
                                `navlink-custom${isActive ? " active" : ""}`
                            }
                        >Sentiers
                        </NavLink>
                    </li>
                    <li>
                        <NavLink
                            to="/resources"
                            className={({ isActive }) =>
                                `navlink-custom${isActive ? " active" : ""}`
                            }
                        >Ressources
                        </NavLink>
                    </li>
                    <li>
                        <NavLink
                            to="/campings"
                            className={({ isActive }) =>
                                `navlink-custom${isActive ? " active" : ""}`
                            }
                        >Campings
                        </NavLink>
                    </li>
                    <li className="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-user"></i>
                        <NavLink
                            to="/login"
                            className={({ isActive }) =>
                                `navlink-custom${isActive ? " active" : ""}`
                            }
                        >Se connecter
                        </NavLink>
                    </li>
                </ul>
            </nav>
            }
        </div>
        );
    };

export default NavBar;