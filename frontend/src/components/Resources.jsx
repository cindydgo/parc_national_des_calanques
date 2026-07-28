import Router from "../api/Router.js";
import { useState, useEffect } from "react";
import { Link, useParams } from "react-router-dom";
import Slideshow from "./Slideshow.jsx";
import { getImagesForResources } from "../data/ResourcesData.js";
import { Accordion, AccordionBody, AccordionHeader } from 'react-bootstrap';
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';
import "../assets/css/Resources.css";

const ResourcesComponent = () => {
    const { resourceId } = useParams();

    const [resources, setResources] = useState([]);
    const [success, setSuccess] = useState(false);
    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        const HttpResource = Router("resources");
        const resourcesData = async() => {
            setLoaded(false);
            setSuccess(false);

            try {
                const fetchResult = resourceId
                    ? await HttpResource.getOne(resourceId)
                    : await HttpResource.getAll({ limit: 6 });

                if (fetchResult.success) {
                    const data = fetchResult.data;
                    setResources(Array.isArray(data) ? data : [data]);
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

        resourcesData();
    }, [resourceId]);

    if (!loaded) {
        return <p>Chargement en cours...</p>;
    }

    if (!success) {
        return (
            <div>
                <p>Une erreur est survenue...</p>
                <p>{ resources?.message }</p>
            </div>
        )
    }

    return (
        <div className="resources-container p-3">
            {resourceId ? (
                <>
                    <h2 className="fw-semibold d-flex justify-content-center align-items-center gap-2">
                        {resources[0]?.name}
                        <span className="resource-badge-title badge">{resources[0].type}</span>
                    </h2>
                </>
            ) : (
                <h2 className="fw-semibold">Les Ressources</h2>
            )}
            <div className="resources-grid">
                {resources.length > 0 ? (
                    resources.map((resource, index) => {
                        const images = getImagesForResources(resource.slug);
                        return (
                            <div key={index} className= {resourceId ? "d-flex flex-column gap-3 m-3" : "p-2"}>
                                <Card style={{ height: resourceId ? 'auto' :'100%' }} className={resourceId ? "resources-box-shadow" : "resource-card"}>
                                    {resourceId ? (
                                        <Slideshow
                                            repertory="resources"
                                            images={images}
                                            slug={resource.slug}
                                        />
                                        ) : images[0] && (
                                            <div className="position-relative">
                                                <Card.Img
                                                    variant="top"
                                                    style={{ height: "200px", objectFit: "cover" }}
                                                    src={`/images/resources/${resource.slug}/${images[0]}`}
                                                    alt={resource.name}
                                                />
                                                <span className="resource-badge position-absolute badge">{resource.type}</span>
                                            </div>
                                        )
                                    }
                                    {resourceId ? (
                                        <Card.Body className="d-flex flex-column justify-content-evenly align-items-center p-4">
                                            <div>
                                                <span><b>Description :</b></span> {resource.description}
                                            </div>
                                        </Card.Body>
                                        ) : (
                                            <Card.Body>
                                                <Card.Title className="fw-semibold">{resource.name}</Card.Title>
                                                <Button variant="primary" to={`/resources/${resource.id}`} as={Link}>
                                                    En savoir plus
                                                </Button>
                                            </Card.Body>
                                        )
                                    }
                                </Card>
                                {resourceId && (
                                    <Accordion>
                                        <Accordion.Item eventKey="0">
                                            <Accordion.Header>
                                                <i className="fa-solid fa-info-circle me-2"></i>
                                                Caractéristiques générales
                                            </Accordion.Header>
                                            <AccordionBody className="d-flex flex-column align-items-start gap-2">
                                                <span><b>Rôle : </b>{resource.ecological_role}</span>
                                                <span><b>Surface : </b>{resource.surface}</span>
                                                <span><b>Envergure : </b>{resource.size}</span>
                                                <span><b>Période d'observation : </b>{resource.observation_period}</span>
                                            </AccordionBody>
                                        </Accordion.Item>
                                        <Accordion.Item eventKey="1">  
                                            <Accordion.Header>
                                                <i className="fa-solid fa-tree me-2"></i> 
                                                Milieu naturel
                                            </Accordion.Header>
                                            <Accordion.Body className="d-flex flex-column align-items-start gap-2">
                                                <span><b>Habitat      : </b>{resource.habitat}</span>
                                                <span><b>Localisation : </b>{resource.location}</span>
                                            </Accordion.Body>
                                        </Accordion.Item>
                                        <Accordion.Item eventKey="2">
                                            <Accordion.Header>
                                                <i className="fa-solid fa-shield-alt me-2"></i>
                                                Statut
                                            </Accordion.Header>
                                            <Accordion.Body className="d-flex flex-column align-items-start gap-2">
                                                <span><b>Statut   : </b>{resource.protection_status}</span>
                                                <span><b>État     : </b>{resource.state}</span>
                                                <span><b>Menaces  : </b>{resource.threats}</span>
                                            </Accordion.Body>
                                        </Accordion.Item>
                                        <Accordion.Item eventKey="3">
                                            <Accordion.Header>
                                                <i className="fa-solid fa-scale-balanced me-2"></i>
                                                Réglementation
                                            </Accordion.Header>
                                            <Accordion.Body className="d-flex flex-column align-items-start gap-2">
                                                <span><b>Règles : </b>{resource.recommendations}</span>
                                            </Accordion.Body>
                                        </Accordion.Item>
                                    </Accordion>
                                )}
                            </div>
                        );
                    })
                ) : (
                    <p>Aucune ressource à afficher.</p>
                )}
            </div>
        </div>
    );
}

export default ResourcesComponent;