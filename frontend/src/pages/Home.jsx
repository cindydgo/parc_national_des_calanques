//import { Link } from "react-router-dom"
import Slideshow from "../components/Slideshow"

function Home() {
    return (
        <div className="home">
            {/*<Slideshow images=/>*/}
            <h1>Bienvenue au Parc National des Calanques</h1>
        </div>
    )
}

export default Home

/*  <section className="home-logements">
            {logements.map(logement => (
                <div className="logement" key={logement.id}>
                    <Link to={`/logements/${logement.id}`}>
                        <img src={logement.cover} alt="logement" />
                        <p className='logement_title'>{logement.title}</p>
                    </Link>
                </div>
            ))}
            </section> */