import '../assets/css/Footer.css'
//import footerLogo from '../../assets/footer_logo.png'
import { NavLink } from "react-router-dom";

function Footer() {
    return (
        <footer className="d-flex flex-column justify-content-center align-items-center">
            <p>
                <b>
                    © 2025 Le parc national des Calanques. 
                    Tous droits réservés
                </b>
            </p>
            <ul className="list-unstyled d-flex ps-0 mb-0">
                <li>
                    <NavLink
                        to="/terms-of-services"
                        className={({ isActive }) =>
                            `navlink-custom${isActive ? " active" : ""}`
                        }
                        >Mentions légales |
                    </NavLink>
                </li>
                <li>
                    <NavLink
                        to="/privacy-policy"
                        className={({ isActive }) =>
                            `navlink-custom${isActive ? " active" : ""}`
                        }
                        >&nbsp;Politique de confidentialité |
                    </NavLink>
                </li> 
                <li>
                    <NavLink
                        to="/site-map"
                        className={({ isActive }) =>
                            `navlink-custom${isActive ? " active" : ""}`
                        }
                        >&nbsp;Plan du site
                    </NavLink>
                </li>
            </ul>
        </footer>
    )
}

export default Footer