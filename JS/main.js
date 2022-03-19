// Déclaration des variables en début de script pour plus de clarté


const cardsArray = [
    {
        name: 'huruk',
        img: '../Medias/images/Huruk.jpg'
    },
    {
        name: 'huruk',
        img: '../Medias/images/Huruk.jpg'
    },
    {
        name: 'gollum',
        img: '../Medias/images/Gollum.jpg'
    },
    {
        name: 'gollum',
        img: '../Medias/images/Gollum.jpg'
    },
    {
        name: 'gimli',
        img: '../Medias/images/Gimli.jpg'
    },
    {
        name: 'gimli',
        img: '../Medias/images/Gimli.jpg'
    },
    {
        name: 'galadriel',
        img: '../Medias/images/Galadriel.jpg'
    },
    {
        name: 'galadriel',
        img: '../Medias/images/Galadriel.jpg'
    },
    {
        name: 'elrond',
        img: '../Medias/images/Elrond.jpg'
    },
    {
        name: 'elrond',
        img: '../Medias/images/Elrond.jpg'
    },
    {
        name: 'aragorn',
        img: '../Medias/images/Aragorn.jpg'
    },
    {
        name: 'aragorn',
        img: '../Medias/images/Aragorn.jpg'
    },
    {
        name: 'sauron',
        img: '../Medias/images/Sauron.jpg'
    },
    {
        name: 'sauron',
        img: '../Medias/images/Sauron.jpg'
    },
    {
        name: 'sam',
        img: '../Medias/images/Sam.jpg'
    },
    {
        name: 'sam',
        img: '../Medias/images/Sam.jpg'
    },
]

let cardsChosen = []
let cardsChosenId = []
let cardsWon = []
let counter = 60

const gridEl = document.querySelector('.grid')
const containerEl = document.querySelector('.container')
const timelineEl = document.querySelector('.timeline')
const startEl = document.querySelector('.start')
const displayScoreEl = document.querySelector('.display-score')

/* 
Création de la grille de jeu
Pour chaque image, création d'un élément html avec association d'attributs, de style
Ajout d'un évènement au click (retournement de la carte)
*/
const createGrid = () => {
    for (let i = 0; i < cardsArray.length; i++) {
        let card = document.createElement('img')
        card.setAttribute('src', '../Medias/images/recto.jpg')
        card.setAttribute('data-id', i)
        card.style.width = '100px'
        card.style.height = '100px'
        card.style.margin = '10px'
        card.style.border = '2px solid rgb(66, 57, 7)'
        card.style.borderRadius = '3px'
        card.addEventListener('click', flipCard)
        gridEl.appendChild(card)
    }
}


/*
Vérification de correspondance des cartes sélectionnées
Modification de l'affichage des cartes en fonction
SI correspondance des cartes alors sauvegarde dans les tableaux déclarés à cet effet
SI réussite, fin du compteur et envoi des données au serveur (pseudo récupéré et temps) via méthode Fetch()
*/
const checkForMatch = () => {
    let cards = document.querySelectorAll('img')
    const optionOneId = cardsChosenId[0]
    const optionTwoId = cardsChosenId[1]
    if (cardsChosen[0] === cardsChosen[1]) {
        cards[optionOneId].classList.add('invisible')
        cards[optionTwoId].classList.add('invisible')
        cardsWon.push(cardsChosen)
    } else {
        cards[optionOneId].setAttribute('src', '../Medias/images/recto.jpg')
        cards[optionTwoId].setAttribute('src', '../Medias/images/recto.jpg')
    }
    cardsChosen = []
    cardsChosenId = []
    if (cardsWon.length === cardsArray.length / 2) {
        clearInterval(timer)

        let nickname = window.prompt('Félicitations, quel est ton nom petit orc crasseux ?')
        let url = window.location + "api.php"

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ "nickname": nickname, "time": 60 - counter })
        }).then(res => res.json())
            .then(res => location.reload())
    }
    document.body.style.pointerEvents = "auto"
}

/*
Evènement de retournement des cartes
Placement des cartes dans les tableaux déclarés à cet effet
Impossibilité de click durant l'évenement (éviter bug) & lancement de la vérification
*/

function flipCard() {
    let cardId = this.getAttribute('data-id')
    cardsChosen.push(cardsArray[cardId].name)
    cardsChosenId.push(cardId)
    this.setAttribute('src', cardsArray[cardId].img)
    if (cardsChosen.length === 2) {
        document.body.style.pointerEvents = "none"
        setTimeout(checkForMatch, 1000)
    }
}

/*
Initialisation du compte à rebours & de son effet visuel
Vérification du temps restant et alertes au joueur
*/
const timer = () => {
    setInterval(() => {
        timelineEl.style.width = (counter / 100) * 160 + "%"
        counter = counter - 1

        if (counter <= 10) {
            timelineEl.classList.add('timeline-danger')
        }
        if (counter === -1) {
            clearInterval(timer)
            window.alert("Il n'y aura bientôt plus de comté Pipin... :(")
            location.reload()
        }
    }, 1000)
} 


/*
Affichage partie commencée
*/
startEl.addEventListener('click', () => {
    timer()
    containerEl.style.display="flex"
    startEl.style.display="none"
})

/*
Exécution des fonctions pour l'initialisation de l'app
*/
cardsArray.sort(() => 0.9 - Math.random())
createGrid()
