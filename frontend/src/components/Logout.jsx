import { useAuth } from '../Context/AuthContext';
import { useNavigate } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import "../assets/css/Logout.css";

function LogoutComponent() {
    const { logout } = useAuth();
    const navigate = useNavigate();

    const handleLogout = async () => {
        await logout();
        navigate('/login');
    };

    return (
        <button type="submit" className="btn btn-custom fw-semibold" onClick={handleLogout}>Se déconnecter</button>
    );
}

export default LogoutComponent;
