import NavBar from "./Navbar.jsx"
import Logo from '/images/logo-calanques.jpg'
import { Link } from "react-router"

function Header() {
    return(
        <header className="d-flex align-items-center shadow-sm">
            <Link to="/" className="logo-link" style={{'width': '20%'}}>
                <img className="logo" src={Logo} alt="Logo Parc National des Calanques" />
            </Link>
            <NavBar />
        </header>
    )
}

export default Header