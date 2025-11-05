import { NavLink } from "react-router-dom";
import "../assets/css/Navbar.css";

const NavBar = () => (
    <nav className="navbar">
        <ul>
            <li><NavLink to="/">Accueil</NavLink></li>
            <li><NavLink to="/sentiers">Sentiers</NavLink></li>
            <li><NavLink to="/resources">Ressources</NavLink></li>
            <li><NavLink to="/campings">Campings</NavLink></li>
            <li><NavLink to="/login">Se connecter</NavLink></li>
            <li><NavLink to="/register">S'inscrire</NavLink></li>
        </ul>
    </nav>
);

export default NavBar;


//let location = useLocation()
    
    // return (
    //     <nav className='header-nav'>
    //         <img src={Logo} alt="logo Parc National des Calanques"/>
    //         <ul>
    //             <li>
    //                 <Link 
    //                     to="/" 
    //                     className={location.pathname === "/" ? "active" : ""}
    //                 >
    //                     Accueil
    //                 </Link>
    //             </li>
    //             <li>
    //                 <Link 
    //                     to="/about" 
    //                     className={location.pathname === "/about" ? "active" : ""}
    //                 >
    //                     A Propos
    //                 </Link>
    //                 <Link 
    //                     to="/login" 
    //                     className={location.pathname === "/login" ? "active" : ""}
    //                 >
    //                     Se connecter
    //                 </Link>
    //                 <Link 
    //                     to="/register" 
    //                     className={location.pathname === "/register" ? "active" : ""}
    //                 >
    //                     S'inscrire
    //                 </Link>
    //             </li>
    //         </ul>
    //     </nav>
    // )