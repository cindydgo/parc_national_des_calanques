const campingImages = {
    "camping-les-cigales-1": ["camping-les-cigales-1-1.jpg", "camping-les-cigales-1-2.jpg"],
    "camping-garlaban-2": ["camping-garlaban-2-1.jpg", "camping-garlaban-2-2.jpg", "camping-garlaban-2-3.jpg", "camping-garlaban-2-4.jpg"],
    "camping-ceyreste-3": ["camping-ceyreste-3-1.jpg", "camping-ceyreste-3-2.jpg", "camping-ceyreste-3-3.jpg"],
    "camping-la-baie-4": ["camping-la-baie-4-1.png", "camping-la-baie-4-2.png"],
    "camping-marseille-provence-5": ["camping-marseille-provence-5-1.jpg", "camping-marseille-provence-5-2.jpg"],
    "camping-6": ["image14.jpg", "image15.jpg"]
};

export function getImagesForCamping(campingSlug) {
    return campingImages[campingSlug] || [];
}