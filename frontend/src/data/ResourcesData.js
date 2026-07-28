const resourcesImages = {
    "pin-d-alep": ["pin-d-alep-1.jpg", "pin-d-alep-2.jpg", "pin-d-alep-3.jpg"],
    "posidonie": ["posidonie-1.jpg", "posidonie-2.jpg"],
    "faucon-pelerin": ["faucon-pelerin-1.jpg", "faucon-pelerin-2.png", "faucon-pelerin-3.jpg"],
    "falaises-morgiou": ["falaises-morgiou-1.jpg", "falaises-morgiou-2.jpg", "falaises-morgiou-3.jpg"],
    "orchidee-sauvage": ["orchidee-sauvage-1.jpg", "orchidee-sauvage-2.jpg"]
};


export function getImagesForResources(resourceSlug) {
    return resourcesImages[resourceSlug] || [];
}