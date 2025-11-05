import NavBar from "./Navbar.jsx"
import Logo from '../assets/images/logo-calanques.jpg'  

function Header() {
    return(
        <header>
            <img className="logo" src={Logo} alt="Logo Parc National des Calanques" />
            <NavBar />
        </header>
    )
}

export default Header