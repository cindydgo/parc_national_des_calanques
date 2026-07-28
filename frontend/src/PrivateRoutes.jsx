import { Navigate } from 'react-router-dom';
import { useAuth } from './Context/AuthContext.jsx';

const PrivateRoutes = ({ children }) => {
    const { user, loading } = useAuth();

    if (loading) {
        return <div>Chargement...</div>;
    }

    if (!user) {
        return <Navigate to="/login" replace />;
    }

    return children;
};

export default PrivateRoutes;