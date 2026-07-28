import "../assets/css/TermsOfServices.css";
import 'bootstrap/dist/css/bootstrap.min.css';
import { Accordion } from 'react-bootstrap';

const TermsOfServicesComponent = () => {
    return (
        <div className="terms-of-services-container p-3 vh-100">
            <h1>Mentions Légales</h1>
            <p className="fw-medium">
                Bienvenue sur le site du Parc des Calanques.<br/>
                En utilisant ce site, vous acceptez les présentes mentions légales.
            </p>
            <section className="my-4 mx-3">
                <Accordion className="terms-of-services-accordion">
                    <Accordion.Item eventKey="0">
                        <Accordion.Header>Informations générales</Accordion.Header>
                        <Accordion.Body>
                        <p>Le site www.calanques-parcnational.fr est édité par l'établissement public du Parc national des Calanques.</p>
                        <p>
                            Siège administratif :

                            141 avenue du Prado 13008 Marseille
                            contact@calanques-parcnational.fr
                            T. : +33(0)4.20.10.50.00
                        </p>
                        </Accordion.Body>
                    </Accordion.Item>
                    <Accordion.Item eventKey="1">
                        <Accordion.Header>Droits de propriété intellectuelle</Accordion.Header>
                        <Accordion.Body>
                            <p>
                                Le site du Parc national des Calanques est une œuvre de l'esprit protégée par la législation en vigueur.<br/>
                                L'ensemble du contenu de ce site est régi par le code de la propriété Intellectuelle.<br/>
                                La présentation et le contenu du présent site constituent une œuvre protégée par les lois en vigueur sur la propriété intellectuelle, dont le Parc national des Calanques est titulaire. <br/>
                                Les dénominations ou appellations, les logos, le nom des produits et des services de la gamme, sont, sauf exception, des marques déposées par le Parc national des Calanques.<br/>
                                D'autres marques sont également citées.<br/>
                                Elles sont utilisées par le Parc national des Calanques soit avec l'autorisation de leur titulaire, soit comme simple indication de produits ou services proposés par le Parc national des Calanques.<br/>
                                Les textes, slogans, dessins, modèles, images, séquences animées, sonores ou non, ainsi que toutes œuvres intégrées dans le site sont la propriété du Parc national des Calanques ou de tiers les ayant autorisés à les utiliser.<br/>
                                Toutes les photographies illustrant ce site sont protégées par le droit d'auteur et exploitées par le Parc national des Calanques en droits gérés.<br/>
                                Toute utilisation autre des photographies sans l'autorisation expresse du Parc national des Calanques constitue une contrefaçon.<br/>
                                Les droits de l'auteur de ce site sont réservés pour toute forme d'utilisation.<br/>
                                En particulier, toute reproduction, représentation, utilisation ou modification, par quelque procédé que ce soit et sur quelque support que ce soit,
                                de tout ou partie du site, de tout ou partie des différentes œuvres et modèles de produits qui le composent,
                                sans avoir obtenu l'autorisation préalable du Parc national des Calanques, est strictement interdite et constitue un délit de contrefaçon puni par la loi.
                            </p>
                        </Accordion.Body>
                    </Accordion.Item>
                    <Accordion.Item eventKey="2">
                        <Accordion.Header>Avertissements</Accordion.Header>
                        <Accordion.Body>
                            <p>
                                Les informations publiées sont régulièrement vérifiées.<br/>
                                Le Parc national des Calanques décline toute responsabilité en cas d'erreur ou d'omission.<br/> 
                                Pour signaler une erreur ou demander la rectification d'informations, remplir le formulaire de contact.<br/>

                                Les informations techniques qui se trouvent sur ce site n'ont qu'une valeur informative et sont susceptibles d'évoluer en fonction des modifications législatives et réglementaires.<br/>
                                Le Parc national des Calanques ne peut être tenu responsable de l'interprétation que vous pourriez faire des informations contenues dans ce site.<br/>

                                Il appartient à l'utilisateur de ce site de prendre toutes les mesures appropriées de façon à protéger ses propres données et/ou logiciels de la contamination par d'éventuels virus circulant sur le réseau Internet.<br/>
                                De manière générale, le Parc national des Calanques décline toute responsabilité à un éventuel dommage survenu pendant la consultation du présent site.<br/> 
                                Les liens proposés vers d'autres sites sont communiqués à titre indicatif et ne sauraient engager la responsabilité du Parc national des Calanques, tant en ce qui concerne les contenus que les conditions d'accès.<br/> 
                                Sont autorisés, sans accord express préalable :

                                la citation, respectant le droit moral de l'auteur par l’indication de son nom et de la source.<br/>
                                La citation est nécessairement courte, cette notion s'appréciant tant par rapport à la publication dont elle est extraite que par rapport à celle dans laquelle elle est introduite.<br/>
                                La citation illustre un propos et ne doit pas concurrencer la publication à laquelle elle est empruntée.<br/>
                                La multiplication des citations, aboutissant à une anthologie, est considérée comme une œuvre dérivée,<br/>
                                et donc soumise à l'accord préalable de l'auteur ou de l'ayant droit ;<br/>
                                la création d'un lien, à la condition impérative que ce lien ouvre une nouvelle fenêtre du navigateur et que la page atteinte par le lien ne soit pas imbriquée à l'intérieur d'autres pages, en particulier par voie de cadres (ou « frames »), 
                                appartenant au site appelant que cette ou ces page(s) apparaisse(nt) dans une page entière sous l'URL www.calanques-parcnational.fr.<br/>
                                Dans les autres cas, et notamment :<br/>

                                si vous souhaitez utiliser/afficher le logo du Parc national des Calanques<br/>
                                si le contenu du site www.calanques-parcnational.fr doit s'intégrer dans la navigation de votre site, en particulier par voie de cadres (ou frames)<br/>
                                si l'accès aux pages contenant le lien vers le site www.calanques-parcnational.fr n'est pas gratuit<br/>
                                vous devez demander l'autorisation expresse du Parc national des Calanques en remplissant le formulaire de contact.<br/>

                                Le Parc national des Calanques dégage toute responsabilité concernant les liens créés par d'autres sites vers ses propres sites.<br/>
                                L'existence de tels liens ne peut permettre d'induire que le Parc national des Calanques cautionne ces sites ou qu'il en approuve les contenus.<br/>
                                Afin de garantir l’identité et l’intégrité de son site, le Parc national des Calanques se réserve le droit d’interdire les liens qui ne répondraient pas à l’objet dudit site ou qui pourraient porter préjudice à l’image de l’institution.<br/> 
                                Le Parc national des Calanques ne peut être tenu responsable du contenu (éditoriaux, illustrations ...) des sites vers lesquels ses sites renvoient.
                            </p>
                        </Accordion.Body>
                    </Accordion.Item>
                    <Accordion.Item eventKey="3">
                        <Accordion.Header>Droit applicable</Accordion.Header>
                        <Accordion.Body>
                            <p>
                                Les présentes Conditions Générales sont soumises au droit interne français.<br/>
                                La langue des Conditions Générales est la langue française.<br/>
                                En cas de litige, les tribunaux français seront seuls compétents.
                            </p>
                        </Accordion.Body>
                    </Accordion.Item>
                    <Accordion.Item eventKey="4">
                        <Accordion.Header>Lois de référence</Accordion.Header>
                        <Accordion.Body>
                            <p className="fw-medium">Loi 78-17 du 6 janvier 1978 Loi relative à l'informatique, aux fichiers et aux libertés</p>
                            <p className="fw-medium">Loi du 29 juillet 1881 Loi sur la liberté de la presse</p>
                            <p className="fw-medium">Loi 2000-719 du 1er août 2000 Extrait de la loi portant sur la responsabilité des prestataires techniques</p>
                        </Accordion.Body>
                    </Accordion.Item>
                </Accordion>
            </section>
        </div>
    )
};

export default TermsOfServicesComponent;