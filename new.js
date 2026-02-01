const track = document.getElementById("carouselTrack");
const nextBtn = document.getElementById("nextBtn");
const prevBtn = document.getElementById("prevBtn");

let cards = document.querySelectorAll(".destination-card");

// Clone first & last
const firstClone = cards[0].cloneNode(true);
const lastClone = cards[cards.length - 1].cloneNode(true);

firstClone.classList.add("clone");
lastClone.classList.add("clone");

track.appendChild(firstClone);
track.insertBefore(lastClone, cards[0]);

cards = document.querySelectorAll(".destination-card");

const gap = 20;
let cardWidth = cards[0].offsetWidth + gap;

let index = 1;
let isAnimating = false;

// Initial position
track.style.transform = `translateX(${-cardWidth * index}px)`;

// Move function
function moveCarousel() {
    isAnimating = true;
    track.style.transition = "transform 0.5s ease";
    track.style.transform = `translateX(${-cardWidth * index}px)`;
}

// Next
nextBtn.addEventListener("click", () => {
    if (isAnimating) return;
    index++;
    moveCarousel();
});

// Prev
prevBtn.addEventListener("click", () => {
    if (isAnimating) return;
    index--;
    moveCarousel();
});

// INSTANT LOOP FIX (no delay)
track.addEventListener("transitionend", () => {
    track.style.transition = "none";

    if (cards[index].classList.contains("clone")) {
        index = index === cards.length - 1 ? 1 : cards.length - 2;

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                track.style.transform = `translateX(${-cardWidth * index}px)`;
            });
        });
    }

    isAnimating = false;
});

// Auto slide
setInterval(() => {
    nextBtn.click();
}, 6000);

// Resize fix
window.addEventListener("resize", () => {
    cardWidth = cards[0].offsetWidth + gap;
    track.style.transition = "none";
    track.style.transform = `translateX(${-cardWidth * index}px)`;
});

// Destination Details Data
        const destinationData = {
            nuwara: {
                title: "Nuwara Eliya",
                location: "Central Province, Sri Lanka",
                image: "Nuwaraeliya.jpeg",
                description: "Nuwara Eliya, known as 'Little England,' is a charming hill station nestled in the heart of Sri Lanka's tea country. With its cool climate, colonial architecture, and lush green landscapes, it offers a refreshing escape from the tropical heat. The town is surrounded by rolling tea plantations, misty mountains, and cascading waterfalls.",
                highlights: [
                    "Visit world-famous tea estates and factories",
                    "Explore Victoria Park and Gregory Lake",
                    "Experience colonial-era architecture",
                    "Enjoy strawberry farms and fresh produce",
                    "Trek to Horton Plains National Park"
                ]
            },
            galle: {
                title: "Galle Fort",
                location: "Southern Province, Sri Lanka",
                image: "Galle.webp",
                description: "Galle Fort is a UNESCO World Heritage Site that showcases the best of Dutch colonial architecture. Built in the 16th century by the Portuguese and later fortified by the Dutch, this historic fortress is a living city with boutique hotels, cafes, museums, and art galleries set within its ancient ramparts.",
                highlights: [
                    "Walk along the historic fort walls",
                    "Visit the iconic lighthouse",
                    "Explore Dutch Reformed Church",
                    "Shop for local handicrafts and gems",
                    "Enjoy sunset views over the Indian Ocean"
                ]
            },
            ella: {
                title: "Ella",
                location: "Uva Province, Sri Lanka",
                image: "Ella.jpeg",
                description: "Ella is a small mountain village that has become one of Sri Lanka's most popular destinations. Known for its breathtaking natural beauty, Ella offers stunning views, hiking opportunities, and a laid-back atmosphere perfect for travelers seeking adventure and relaxation.",
                highlights: [
                    "Hike to Little Adam's Peak and Ella Rock",
                    "Walk across the Nine Arch Bridge",
                    "Visit Ravana Falls and Ravana Cave",
                    "Take the scenic train journey from Kandy",
                    "Enjoy panoramic views from Ella Gap"
                ]
            },
            jaffna: {
                title: "Jaffna",
                location: "Northern Province, Sri Lanka",
                image: "Jaffna.jpeg",
                description: "Jaffna is the cultural capital of Sri Lanka's Tamil community, offering a unique blend of history, culture, and tradition. This northern city is known for its distinct cuisine, vibrant Hindu temples, and beautiful coastal scenery. Jaffna provides an authentic experience of Tamil culture and heritage.",
                highlights: [
                    "Visit the historic Jaffna Fort",
                    "Explore Nallur Kandaswamy Temple",
                    "Discover the Jaffna Public Library",
                    "Take a boat to Nagadeepa and Delft Island",
                    "Taste authentic Jaffna cuisine"
                ]
            },
            kandy: {
                title: "Kandy",
                location: "Central Province, Sri Lanka",
                image: "Kandy.jpeg",
                description: "Kandy, the last royal capital of Sri Lanka, is a sacred city that houses the Temple of the Sacred Tooth Relic. Surrounded by mountains and home to a beautiful lake, Kandy is the cultural heart of the island, hosting the famous Esala Perahera festival annually.",
                highlights: [
                    "Visit the Temple of the Tooth (Sri Dalada Maligawa)",
                    "Stroll around Kandy Lake",
                    "Watch traditional Kandyan dance performances",
                    "Explore the Royal Botanical Gardens in Peradeniya",
                    "Visit tea museums and plantations nearby"
                ]
            },
            colombo: {
                title: "Colombo",
                location: "Western Province, Sri Lanka",
                image: "Colombo.jpeg",
                description: "Colombo is Sri Lanka's bustling commercial capital and largest city. It's a vibrant metropolis that seamlessly blends colonial heritage with modern development. From historic temples and churches to contemporary shopping malls and restaurants, Colombo offers diverse experiences for every traveler.",
                highlights: [
                    "Visit Gangaramaya Temple and Beira Lake",
                    "Explore the historic Galle Face Green",
                    "Shop at Pettah Markets and Odel",
                    "Discover colonial architecture in Fort area",
                    "Enjoy the beach at Mount Lavinia"
                ]
            },
            matara: {
                title: "Matara",
                location: "Southern Province, Sri Lanka",
                image: "Matara.jpeg",
                description: "Matara is a charming coastal town in the southern part of Sri Lanka. Known for its beautiful beaches, historic sites, and relaxed atmosphere, Matara offers a perfect blend of culture and seaside leisure. The town features colonial-era architecture and ancient Buddhist temples.",
                highlights: [
                    "Visit the historic Matara Fort",
                    "Explore Paravi Duwa Temple on the island",
                    "Relax at Polhena and Mirissa beaches",
                    "See the star-shaped fortress",
                    "Experience local fishing village life"
                ]
            },
            trinco: {
                title: "Trincomalee",
                location: "Eastern Province, Sri Lanka",
                image: "Trinco.jpeg",
                description: "Trincomalee, or Trinco, is blessed with one of the finest natural harbors in the world. This eastern coastal city offers pristine beaches, crystal-clear waters, and incredible marine life. It's a paradise for beach lovers, divers, and those seeking whale watching adventures.",
                highlights: [
                    "Visit the ancient Koneswaram Temple",
                    "Relax on Nilaveli and Uppuveli beaches",
                    "Go whale and dolphin watching",
                    "Snorkel at Pigeon Island National Park",
                    "Explore Fort Frederick and its historical sites"
                ]
            },
            sigiriya: {
                title: "Sigiriya",
                location: "Central Province, Sri Lanka",
                image: "Sigiriya.jpeg",
                description: "Sigiriya, also known as Lion Rock, is an ancient rock fortress and one of Sri Lanka's most iconic landmarks. This UNESCO World Heritage Site rises 200 meters above the surrounding plains and features spectacular frescoes, water gardens, and the remains of an ancient palace. It's a testament to the ingenuity of ancient Sri Lankan civilization.",
                highlights: [
                    "Climb the ancient rock fortress",
                    "View the famous Sigiriya frescoes",
                    "Explore the water gardens and boulder gardens",
                    "Visit the nearby Dambulla Cave Temple",
                    "Enjoy panoramic views from the summit"
                ]
            }
        };

        // Destination Modal functionality
        const destinationModal = document.getElementById('destinationModal');
        const destinationCloseBtn = document.getElementById('destinationCloseBtn');
        const destinationCards = document.querySelectorAll('.destination-card');

        destinationCards.forEach(card => {
            card.addEventListener('click', () => {
                const destination = card.getAttribute('data-destination');
                const data = destinationData[destination];

                document.getElementById('destinationModalImg').src = data.image;
                document.getElementById('destinationModalTitle').textContent = data.title;
                document.getElementById('destinationModalLocation').textContent = data.location;
                document.getElementById('destinationModalDescription').textContent = data.description;

                const highlightsList = document.getElementById('destinationModalHighlights');
                highlightsList.innerHTML = '';
                data.highlights.forEach(highlight => {
                    const li = document.createElement('li');
                    li.textContent = highlight;
                    highlightsList.appendChild(li);
                });

                destinationModal.classList.add('active');
            });
        });

        destinationCloseBtn.addEventListener('click', () => {
            destinationModal.classList.remove('active');
        });

        destinationModal.addEventListener('click', (e) => {
            if (e.target === destinationModal) {
                destinationModal.classList.remove('active');
            }
        });
 

        const btn = document.querySelector('.submit-btn');

document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevents the page from reloading

    btn.innerText = 'Sending...';

    // These IDs must match your EmailJS Dashboard
    const serviceID = 'service_kds7r3s';
    const templateID = 'template_8z49qjp';

    // This creates an object from your form inputs
    const templateParams = {
        from_name: document.getElementById('name').value,
        reply_to: document.getElementById('email').value,
        message: document.getElementById('message').value
    };

    emailjs.send(serviceID, templateID, templateParams)
        .then(() => {
            btn.innerText = 'Send Message';
            alert('Message Sent Successfully!');
            document.getElementById('contactForm').reset(); // Clears the form
        }, (err) => {
            btn.innerText = 'Send Message';
            alert('Failed to send message. Error: ' + JSON.stringify(err));
        });
});