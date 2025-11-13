import { useAuth } from '../Context/AuthContext';
import { useNavigate } from 'react-router-dom';

function LogoutComponent() {
    const { logout } = useAuth();
    const navigate = useNavigate();

    const handleLogout = async () => {
        await logout();
        navigate('/login');
    };

    return (
        <button type="submit" onClick={handleLogout}>Se déconnecter</button>
    );
}

export default LogoutComponent;
