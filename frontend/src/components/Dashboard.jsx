import '../assets/css/Dashboard.css';
import Card from 'react-bootstrap/Card';

const DashboardComponent = () => {
    return (
        <div className="dashboard-container d-flex flex-column align-items-center">
            <div className="dashboard-grid d-flex gap-5 w-100">
                <div className="left-dashboard-grid d-flex flex-column align-items-center py-4" style={{ 'width': '16.7%'}}>
                    <ul className='list-unstyled w-100 ps-2'>
                        <li>
                            <i class="fa-solid fa-user"></i>
                            <p>Utilisateurs</p>
                        </li>
                        <li>
                            <i class="fa-solid fa-eye"></i>
                            <p>Visiteurs</p>
                        </li>
                        <li>
                            <i class="fa-solid fa-person-walking"></i>
                            <p>Sentiers</p>
                        </li>
                        <li>
                            <i class="fa-solid fa-house"></i>
                            <p>Campings</p>
                        </li>
                        <li>
                            <i class="fa-solid fa-tree"></i>
                            <p>Ressources</p>
                        </li>
                    </ul>
                </div>
                <div className="right-dashboard-grid d-flex flex-column gap-3 py-4" style={{ 'width': '70%'}}>
                    <h1>Tableau de bord</h1>
                    <Card className="dashboard-card">
                        <Card.Body className="dashboard-card-body"><b>Gestion des Utilisateurs</b></Card.Body>
                        <Card.Body className="dashboard-card-body">
                            Création, modification et suppression des comptes <br />pour les administrateurs du parc.
                        </Card.Body>
                    </Card>
                    <Card className="dashboard-card">
                        <Card.Body className="dashboard-card-body"><b>Gestion des Visiteurs</b></Card.Body>
                        <Card.Body className="dashboard-card-body">
                            Enregistrement et suivi des informations des visiteurs.<br />
                            Gestion des abonnements et des cartes membres.
                        </Card.Body>
                    </Card>
                    <Card className="dashboard-card">
                        <Card.Body className="dashboard-card-body"><b>Gestion des Sentiers</b></Card.Body>
                        <Card.Body className="dashboard-card-body">
                            Création, modification et suppression des sentiers.<br />
                            Affichage des cartes avec les niveaux de difficulté.
                        </Card.Body>
                    </Card>
                    <Card className="dashboard-card">
                        <Card.Body className="dashboard-card-body"><b>Gestion des Campings</b></Card.Body>
                        <Card.Body className="dashboard-card-body">
                            Système de réservation en ligne pour les campings du parc.<br />
                            Suivi des réservations et gestion des disponibilités.
                        </Card.Body>
                    </Card>
                    <Card className="dashboard-card">
                        <Card.Body className="dashboard-card-body"><b>Gestion des Ressources</b></Card.Body>
                        <Card.Body className="dashboard-card-body">
                            Gestion des ressources disponibles pour les visiteurs.<br />
                            Ajout et mise à jour des ressources.
                        </Card.Body>
                    </Card>
                </div>
            </div>
        </div>
    );
}

export default DashboardComponent;