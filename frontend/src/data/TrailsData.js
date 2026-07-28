const sentierImages = {
    "sentier-de-l-eissadon-1": ["sentier-de-l-eissadon-1-1.jpg", "sentier-de-l-eissadon-1-2.jpg"],
    "sentier-des-goudes-2": ["sentier-des-goudes-2-1.jpg", "sentier-des-goudes-2-2.jpg"],
    "sentier-du-cap-canaille-3": ["sentier-du-cap-canaille-3-1.jpg", "sentier-du-cap-canaille-3-2.jpg", "sentier-du-cap-canaille-3-3.jpg"],
    "sentier-de-morgiou-4": ["sentier-de-morgiou-4-1.jpg", "sentier-de-morgiou-4-2.jpg", "sentier-de-morgiou-4-3.jpg"],
    "sentier-de-sugiton-5": ["sentier-de-sugiton-5-1.jpg", "sentier-de-sugiton-5-2.jpg", "sentier-de-sugiton-5-3.jpg"],
    "sentier-6": ["sentier-6-1.jpg", "sentier-6-2.jpg"]
};

export function getImagesForSentier(sentierSlug) {
    return sentierImages[sentierSlug] || [];
}