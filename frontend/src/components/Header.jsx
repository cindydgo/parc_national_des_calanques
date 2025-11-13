import NavBar from "./Navbar.jsx"
import Logo from '../assets/images/logo-calanques.jpg'
import LogoutComponent from "./Logout.jsx"  

function Header() {
    return(
        <header>
            <img className="logo" src={Logo} alt="Logo Parc National des Calanques" />
            <NavBar />
            <LogoutComponent />
        </header>
    )
}

export default Header