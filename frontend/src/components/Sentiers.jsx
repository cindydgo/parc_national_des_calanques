import Router from "../api/Router.js";
import { useState, useEffect } from "react";
import { Link, useParams } from "react-router-dom";
import Slideshow from "./Slideshow"; 
import DifficultySignal from "./DifficultySignal";
import Modal from "./Modal";
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';
import { getImagesForSentier } from "../data/TrailsData.js";
import "../assets/css/Sentiers.css";

const SentiersComponent = () => {const {sentierId } = useParams();
    const [sentiers, setSentiers] = useState([]);
    const [success, setSuccess] = useState(false);
    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        const HttpSentiers = Router("sentiers");
        const sentiersData = async() => {
            setLoaded(false);
            setSuccess(false);

            try {
                const fetchResult = sentierId
                    ? await HttpSentiers.getOne(sentierId)
                    : await HttpSentiers.getAll({ limit: 6 });

                if (fetchResult.success) {
                    const data = fetchResult.data;
                    setSentiers(Array.isArray(data) ? data : [data]);
                    setSuccess(true);
                } else {
                    console.error(fetchResult.errors);
                }
            } catch (err) {
                console.error(err);
            } finally {
                setLoaded(true);
            }
        };

        sentiersData();
    }, [sentierId]);

    if (!loaded) {
        return <p>Chargement en cours...</p>;
    }

    if (!success) {
        return (
            <div>
                <p>Une erreur est survenue...</p>
                <p>{ sentiers?.message }</p>
            </div>
        )
    }

    return (
        <div className="trails-container p-3">
            {sentierId ? (
                <h2 className="fw-semibold">{sentiers[0]?.name}</h2>
            ) : (
                <h2 className="fw-semibold">Les Sentiers</h2>
            )}
            {<div className="trails-grid">
                {sentiers.length > 0 ? (
                    sentiers.map((sentier, index) => {
                        const images = getImagesForSentier(sentier.slug);

                        return (
                            <div key={index} className="p-2">
                                <Card style={{ height: sentierId ? 'auto' : '100%' }} className={sentierId ? 'trails-box-shadow' : 'trail-card'}>
                                    {sentierId ? (
                                        <Slideshow
                                            repertory="trails"
                                            images={images}
                                            slug={sentier.slug}
                                        />
                                    ) : images[0] && (
                                            <Card.Img
                                                variant="top"
                                                style={{ height: "200px", objectFit: "cover" }}
                                                src={`/images/trails/${sentier.slug}/${images[0]}`}
                                                alt={sentier.name}
                                            />
                                        )
                                    }
                                    <Card.Body>
                                        {sentierId && (
                                        <div className="d-flex flex-column aign-items-center justify-content-center">
                                            <Card.Text>
                                                <b>Description :</b> {sentier.description}
                                            </Card.Text>
                                            <div className="d-flex justify-content-center gap-3">
                                                <Modal 
                                                    position={[sentier.latitude, sentier.longitude]}
                                                    zoom={13}
                                                    popup={`${sentier.name}, Latitude : ${sentier.latitude}, Longitude : ${sentier.longitude}`}
                                                />
                                                <Button variant="outline-danger">
                                                    <i class="fa-regular fa-heart"></i> Ajouter aux favoris
                                                </Button>
                                            </div>
                                        </div>
                                        )}
                                        {!sentierId && (
                                            <>
                                            <Card.Title className="fw-semibold">{sentier.name}</Card.Title>
                                            <Button variant="primary" to={`/sentiers/${sentier.id}`} as={Link}>
                                                En savoir plus
                                            </Button>
                                            </>
                                        )}
                                    </Card.Body>
                                </Card>
                                {sentierId && (
                                    <div className="mt-3 mb-3">
                                        <div className="grid-trails-cards">
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start">
                                                        <span><b>Difficulté :</b></span>
                                                        <span>Niveau {sentier.difficulty}</span>
                                                    </div>
                                                    <DifficultySignal level={sentier.difficulty} />
                                                </Card.Body>
                                            </Card>
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start"> 
                                                        <span><b>Distance :</b></span>
                                                        <span>{sentier.distance} km</span>
                                                    </div>
                                                    <i class="fa-solid fa-person-hiking fs-5"></i>
                                                </Card.Body>
                                            </Card>
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start">
                                                        <span><b>Duration :</b></span>
                                                        <span>{sentier.duration} min</span>
                                                    </div>
                                                    <i class="fa-regular fa-clock fs-5"></i>
                                                </Card.Body>
                                            </Card>
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start">
                                                        <span><b>Elevation :</b></span> 
                                                        <span>{sentier.elevation} m</span>
                                                    </div>
                                                    <i class="fa-solid fa-mountain fs-5"></i>
                                                </Card.Body>
                                            </Card>
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start">
                                                        <span><b>Exposition :</b></span>
                                                        <span>{sentier.exposition}</span>
                                                    </div>
                                                    <i class="fa-solid fa-temperature-full fs-5"></i>
                                                </Card.Body>
                                            </Card>
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start">
                                                        <span><b>Type :</b></span>
                                                        <span>{sentier.type}</span>
                                                    </div>
                                                    <i class="fa-solid fa-signs-post fs-5"></i>
                                                </Card.Body>
                                            </Card>
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start">
                                                        <span><b>Public :</b></span>
                                                        <span>{sentier.public}</span>
                                                    </div>
                                                    <i class="fa-solid fa-people-group fs-5"></i>
                                                </Card.Body>
                                            </Card>
                                            <Card className="trails-box-shadow">
                                                <Card.Body className="d-flex justify-content-between align-items-center gap-2">
                                                    <div className="d-flex flex-column align-items-start">
                                                        <span><b>Animaux autorisés :</b></span>
                                                        {sentier.pets_allowed && sentier.pets_allowed > 0 ? (
                                                            <div className="d-flex align-items-center gap-2">
                                                                <span>Oui</span>
                                                                <i className="fa-solid fa-square-check text-success"></i>
                                                            </div>
                                                        ) : (
                                                            <div className="d-flex align-items-center gap-2">
                                                                <span>Non</span>
                                                                <i className="fa-solid fa-square-xmark text-danger"></i>
                                                            </div>
                                                        )}
                                                    </div>
                                                    <i class="fa-solid fa-dog fs-5"></i>
                                                </Card.Body>
                                            </Card>
                                        </div>
                                    </div>
                                )}
                            </div>
                        );
                    })
                ) : (
                    <p>Aucun Sentier à afficher.</p>
                )}
            </div>}
        </div>
    );
}


export default SentiersComponent;