import Slideshow from "../components/Slideshow"
import Card from 'react-bootstrap/Card'
import Button from "react-bootstrap/Button"
import Map from "./Map"
import image1 from '/images/slideshow/calanque1.jpeg'
import image2 from '/images/slideshow/calanque2.jpg'
import image3 from '/images/slideshow/calanque3.jpg'   
import image4 from '/images/slideshow/calanque4.jpg'
import image5 from '/images/slideshow/calanque5.jpg'
import image6 from '/images/slideshow/calanque6.jpg'
import '../assets/css/Home.css'

function HomeComponent() {
    const images = [image1, image2, image3, image4, image5, image6];
    return (
        <div className="home-container h-100">
            <h1 className="home-title fs-2 p-3 fw-semibold">
                Bienvenue au Parc National des Calanques
            </h1>
            <Slideshow images={images} />
            <article className="d-flex flex-column m-4">
                <h2 className="home-subtitle fs-3 fw-semibold">
                    Tous les articles
                </h2>
                <div className="article-grid-cards">
                    <Card>
                        <Card.Body className="d-flex flex-column justify-content-between align-items-center">
                            <Card.Text>
                                Explorez nos articles pour en savoir plus sur la faune, la flore du Parc National des Calanques.
                            </Card.Text>
                            <Button variant="primary" href="/articles">
                            Lire la suite
                        </Button>
                        </Card.Body>
                    </Card>
                    <Card>
                        <Card.Body className="d-flex flex-column justify-content-between align-items-center">
                            <Card.Text>
                                Découvrez les sentiers de randonnée, les points de vue panoramiques et les activités de plein air disponibles dans le parc.
                            </Card.Text>
                            <Button variant="primary" href="/articles">
                                Lire la suite
                            </Button>
                        </Card.Body>
                    </Card>
                    <Card>
                        <Card.Body className="d-flex flex-column justify-content-between align-items-center">
                            <Card.Text>
                                Informez-vous sur les efforts de conservation et les programmes de sensibilisation visant à protéger la biodiversité unique du parc.
                            </Card.Text>
                            <Button variant="primary" href="/articles">
                                Lire la suite
                            </Button>
                        </Card.Body>
                    </Card>
                    <Card>
                        <Card.Body className="d-flex flex-column justify-content-between align-items-center">
                            <Card.Text>
                                Les programmes de sensibilisation visant à protéger la biodiversité unique du parc.
                            </Card.Text>
                            <Button variant="primary" href="/resources">
                                Lire la suite
                            </Button>
                        </Card.Body>
                    </Card>
                </div>
            </article>
            <div className="home-map-container m-4">
                <h2 className="home-subtitle fs-3 fw-semibold mb-3">
                    Carte du Parc National des Calanques
                </h2>
                <div className="home-map-box-shadow">
                    <Map 
                        position={[43.2125, 5.4433]}
                        zoom={10}
                        popup="Parc National des Calanques"
                    />
                </div>
            </div>
        </div>
    )
}

export default HomeComponent