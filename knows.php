<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
    <link rel="stylesheet" href="style.css">
    <script src="scripts/word-list.js" defer></script>
    <script src="scripts/script.js" defer></script>
</head>
<body>

    <style>
        /* Importing Google font - Open Sans */
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap");
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Open Sans", sans-serif;
}
body {
    display: flex;
    padding: 0 10px;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: linear-gradient(-45deg, #0BC8BF, #353389);
}
.container {
    display: flex;
    width: 850px;
    gap: 70px;
    padding: 60px 40px;
    background: #fff;
    border-radius: 10px;
    align-items: flex-end;
    justify-content: space-between;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.hangman-box img {
    user-select: none;
    max-width: 270px;
}
.hangman-box h1 {
    font-size: 1.45rem;
    text-align: center;
    margin-top: 20px;
    text-transform: uppercase;
}
.game-box .word-display {
    gap: 10px;
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
.word-display .letter {
    width: 28px;
    font-size: 2rem;
    text-align: center;
    font-weight: 600;
    margin-bottom: 40px;
    text-transform: uppercase;
    border-bottom: 3px solid #000;
}
.word-display .letter.guessed {
    margin: -40px 0 35px;
    border-color: transparent;
}
.game-box h4 {
    text-align: center;
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 15px;
}
.game-box h4 b {
    font-weight: 600;
}
.game-box .guesses-text b {
    color: #ff0000;
}
.game-box .keyboard {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
    margin-top: 40px;
    justify-content: center;
}
:where(.game-modal, .keyboard) button {
    color: #fff;
    border: none;
    outline: none;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 4px;
    text-transform: uppercase;
    background: #5E63BA;
}
.keyboard button {
    padding: 7px;
    width: calc(100% / 9 - 5px);
}
.keyboard button[disabled] {
    pointer-events: none;
    opacity: 0.6;
}
:where(.game-modal, .keyboard) button:hover {
    background: #8286c9;
}
.game-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    pointer-events: none;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 0 10px;
    transition: opacity 0.4s ease;
}
.game-modal.show {
    opacity: 1;
    pointer-events: auto;
    transition: opacity 0.4s 0.4s ease;
}
.game-modal .content {
    padding: 30px;
    max-width: 420px;
    width: 100%;
    border-radius: 10px;
    background: #fff;
    text-align: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.game-modal img {
    max-width: 130px;
    margin-bottom: 20px;
}
.game-modal img[src="images/victory.gif"] {
    margin-left: -10px;
}
.game-modal h4 {
    font-size: 1.53rem;
}
.game-modal p {
    font-size: 1.15rem;
    margin: 15px 0 30px;
    font-weight: 500;
}
.game-modal p b {
    color: #5E63BA;
    font-weight: 600;
}
.game-modal button {
    padding: 12px 23px;
}

@media (max-width: 782px) {
    .container {
        flex-direction: column;
        padding: 30px 15px;
        align-items: center;
    }
    .hangman-box img {
        max-width: 200px;
    }
    .hangman-box h1 {
        display: none;
    }
    .game-box h4 {
        font-size: 1rem;
    }
    .word-display .letter {
        margin-bottom: 35px;
        font-size: 1.7rem;
    }
    .word-display .letter.guessed {
        margin: -35px 0 25px;
    }
    .game-modal img {
        max-width: 120px;
    }
    .game-modal h4 {
        font-size: 1.45rem;
    }
    .game-modal p {
        font-size: 1.1rem;
    }
    .game-modal button {
        padding: 10px 18px;
    }
}

body {
  margin: 0;
  padding: 0;
  
  height: 100vh;
  width: 100vw;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

#next {
  width: 48px;
  height: 48px;
  right: 10px;
 
  border-radius: 48px;
  border: 3px solid #f2af29;
  transition: all 0.3s ease;
}

#next::after {
  content: "\9C";
  font-size: 18px;
  color: #f2af29;
  transition: all 0.3s ease;
}

#next:hover {
  border-color: #14519f;
}

 
</style>
    <div class="game-modal">
        <div class="content">
            <img src="#" alt="gif">
            <h4>  Over!</h4>
            <p>The correct word was: <b>rainbow</b></p>
            <button class="play-again">Play Again</button>
        </div>
    </div>
    <div class="container">
        <button id="next">&nbsp&nbspSKIP</button>
        <div class="hangman-box">
            <img src="#" draggable="false" alt="hangman-img">
            <h1>Hangman  D</h1>

        </div>
        <div class="game-box">
            <ul class="word-display"></ul>
            <h4 class="hint-text">Hint: <b></b></h4>
            <h4 class="guesses-text">Incorrect guesses: <b></b></h4>
            <div class="keyboard"></div>
        </div>
    </div>
    <script >
        const wordList = [
    

 
    { word: "e11", hint: "A disease that occurs when your blood glucose is too high. CODE" }, // Diabetes
    { word: "i10", hint: "A condition in which the force of the blood against the artery walls is too high. CODE" }, // Hypertension
    { word: "m19.90", hint: "Inflammation of the joints, causing pain and stiffness. CODE" }, // Arthritis
    { word: "j45.909", hint: "A respiratory condition marked by spasms in the bronchi of the lungs, causing difficulty in breathing.CODE" }, // Asthma
    { word: "c80.1", hint: "A disease caused by an uncontrolled division of abnormal cells in a part of the body.CODE" }, // Cancer
    { word: "j10.1", hint: "A viral infection that attacks your respiratory system – your nose, throat, and lungs.CODE" }, // Influenza
    { word: "a15.0", hint: "An infectious disease that mainly affects the lungs.CODE" }, // Tuberculosis
    { word: "b50", hint: "A disease caused by a plasmodium parasite, transmitted by the bite of infected mosquitoes.CODE" }, // Malaria
    { word: "b20", hint: "A virus that attacks the body's immune system.CODE" }, // HIV
    { word: "b24", hint: "A chronic, potentially life-threatening condition caused by HIV.CODE" }, // AIDS
    { word: "b05", hint: "A highly contagious viral infection that causes a total-body skin rash and flu-like symptoms.CODE" }, // Measles
    { word: "b01", hint: "A highly contagious viral infection causing an itchy, blister-like rash on the skin.CODE" }, // Chickenpox
    { word: "k71", hint: "An inflammation of the liver.CODE" }, // Hepatitis
    { word: "j18.9", hint: "An infection that inflames the air sacs in one or both lungs.CODE" }, // Pneumonia
    { word: "a00", hint: "An acute diarrheal illness caused by infection of the intestine with Vibrio cholerae bacteria.CODE" }, // Cholera
    { word: "a98.4", hint: "A severe, often fatal disease in humans and nonhuman primates caused by the Ebola virus.CODE" }, // Ebola
    { word: "a82", hint: "A deadly virus spread to people from the saliva of infected animals.CODE" }, // Rabies
    { word: "a90", hint: "A mosquito-borne viral disease occurring in tropical and subtropical areas.CODE" }, // Dengue
    { word: "a92.5", hint: "A virus spread by Aedes mosquitoes, which can cause birth defects if contracted during pregnancy.CODE" }, // Zika
    { word: "b26", hint: "A viral infection that primarily affects saliva-producing glands located near your ears.CODE" }, // Mumps
    { word: "a80", hint: "A crippling and potentially deadly infectious disease caused by the poliovirus.CODE" }, // Polio
    { word: "b03", hint: "An eradicated viral disease that used to be contagious, disfiguring, and often deadly.CODE" }, // Smallpox
    { word: "a50", hint: "A bacterial infection usually spread by sexual contact.CODE" }, // Syphilis
    { word: "a54", hint: "A sexually transmitted bacterial infection that, if untreated, may cause infertility.CODE" }, // Gonorrhea
    { word: "a56", hint: "A common sexually transmitted infection that may not cause symptoms.CODE" }, // Chlamydia
    { word: "u07.1", hint: "A highly contagious disease caused by the novel coronavirus SARS-CoV-2.CODE" }, // COVID-19
    { word: "a69.20", hint: "An infectious disease caused by the Borrelia bacterium, spread by ticks.CODE" }, // Lyme
    { word: "b18.1", hint: "A serious liver infection caused by the hepatitis B virus.CODE" }, // Hepatitis B
    { word: "b18.2", hint: "An infection caused by a virus that attacks the liver and leads to inflammation.CODE" }, // Hepatitis C
    { word: "g03.9", hint: "Inflammation of the protective membranes covering the brain and spinal cord.CODE" }, // Meningitis
    { word: "b00.1", hint: "A viral infection causing contagious sores, most often around the mouth or on the genitals.CODE" }, // Herpes
    { word: "a08.4", hint: "A very contagious virus that causes vomiting and diarrhea.CODE" }, // Norovirus
    { word: "a08.0", hint: "A contagious virus that can cause gastroenteritis (inflammation of the stomach and intestines).CODE" }, // Rotavirus
    { word: "m32.9", hint: "An autoimmune disease where the body's immune system becomes hyperactive and attacks normal, healthy tissue.CODE" }, // Lupus
    { word: "k90.0", hint: "An immune reaction to eating gluten, a protein found in wheat, barley, and rye.CODE" }, // Celiac
    { word: "k50.90", hint: "A type of inflammatory bowel disease (IBD) that may affect any part of the gastrointestinal tract.CODE" }, // Crohn's
    { word: "k51.90", hint: "A chronic inflammatory bowel disease that causes inflammation in the digestive tract.CODE" }, // Ulcerative Colitis
    { word: "g30.9", hint: "A progressive disease that destroys memory and other important mental functions.CODE" }, // Alzheimer's
    { word: "g20", hint: "A disorder of the central nervous system that affects movement, often including tremors.CODE" }, // Parkinson's
    { word: "g35", hint: "A disease in which the immune system eats away at the protective covering of nerves.CODE" }, // Multiple Sclerosis
    { word: "m05.79", hint: "A chronic inflammatory disorder affecting many joints, including those in the hands and feet.CODE" }, // Rheumatoid Arthritis
    { word: "l40.9", hint: "A skin disease marked by red, itchy, scaly patches.CODE" }, // Psoriasis
    { word: "l20.9", hint: "A condition that makes your skin red and itchy.CODE" }, // Eczema
    { word: "l71.9", hint: "A common skin condition that causes redness and visible blood vessels in your face.CODE" }, // Rosacea
    { word: "m10", hint: "A form of arthritis characterized by severe pain, redness, and tenderness in joints.CODE" }, // Gout
    // Add additional entries to reach 1000
 

    //  // related to medicaion
    { word: "anatomy", hint: "The study of the structure of the human body." },
    { word: "biopsy", hint: "A medical test involving the removal of cells or tissues for examination." },
    { word: "cardiology", hint: "The branch of medicine dealing with the heart and its diseases." },
    { word: "diagnosis", hint: "The process of identifying a disease or condition from its signs and symptoms." },
    { word: "epidemiology", hint: "The study of how diseases spread and can be controlled." },
    { word: "fracture", hint: "A break or crack in a bone." },
    { word: "genetics", hint: "The study of heredity and the variation of inherited characteristics." },
    { word: "hematology", hint: "The branch of medicine concerned with the study of blood, blood-forming organs, and blood diseases." },
    { word: "immunology", hint: "The branch of medicine and biology concerned with immunity." },
    { word: "jaundice", hint: "A yellowing of the skin and eyes due to liver disease or bile obstruction." },
    { word: "kinesiology", hint: "The study of body movement." },
    { word: "leukemia", hint: "A type of cancer found in your blood and bone marrow." },
    { word: "metastasis", hint: "The spread of cancer cells from the place where they first formed to another part of the body." },
    { word: "nephrology", hint: "The branch of medicine that deals with the physiology and diseases of the kidneys." },
    { word: "oncology", hint: "The study and treatment of tumors and cancer." },
    { word: "pathology", hint: "The study of diseases, their causes, and effects." },
    { word: "quarantine", hint: "A restriction on the movement of people and goods to prevent the spread of disease." },
    { word: "radiology", hint: "The science dealing with X-rays and other high-energy radiation for diagnosis and treatment of diseases." },
    { word: "surgery", hint: "The treatment of injuries or disorders of the body by incision or manipulation." },
    { word: "trauma", hint: "A physical injury or wound caused by external force or violence." },
    { word: "ultrasound", hint: "Sound or other vibrations having an ultrasonic frequency, used in medical imaging." },
    { word: "vaccination", hint: "The administration of a vaccine to help the immune system develop protection from a disease." },
    { word: "x-ray", hint: "A form of electromagnetic radiation used for medical imaging." },
    { word: "yoga", hint: "A practice involving physical postures, breath control, and meditation to promote health and relaxation." },
    { word: "zen", hint: "A form of meditation in Zen Buddhism, aimed at achieving enlightenment and self-discovery." },
    { word: "acupuncture", hint: "A traditional Chinese medicine practice of inserting needles into the skin to treat various conditions." },
    { word: "bandage", hint: "A strip of material used to bind up a wound or protect an injured part of the body." },
    { word: "coma", hint: "A state of deep unconsciousness that lasts for a prolonged or indefinite period." },
    { word: "detoxification", hint: "The process of removing toxic substances from the body." },
    { word: "eczema", hint: "A medical condition in which patches of skin become rough and inflamed." },
    { word: "fibrosis", hint: "The thickening and scarring of connective tissue, usually as a result of injury." },
    { word: "glucose", hint: "A simple sugar that is an important energy source in living organisms." },
    { word: "homeopathy", hint: "A system of alternative medicine based on the principle of treating 'like with like'." },
    { word: "insulin", hint: "A hormone produced in the pancreas that regulates the amount of glucose in the blood." },
    { word: "joints", hint: "The points at which two bones meet in the body." },
    { word: "keratin", hint: "A fibrous protein forming the main structural constituent of hair, feathers, hoofs, claws, horns, etc." },
    { word: "larynx", hint: "The hollow muscular organ forming an air passage to the lungs and holding the vocal cords." },
    { word: "migraines", hint: "Severe, recurring headaches often accompanied by nausea and sensitivity to light and sound." },
    { word: "narcotics", hint: "Drugs that dull the senses, relieve pain, and induce sleep." },
    { word: "orthopedics", hint: "The branch of medicine dealing with the correction of deformities of bones or muscles." },
    { word: "prognosis", hint: "The likely course of a disease or ailment." },
    { word: "rehabilitation", hint: "The process of restoring someone to health or normal life through training and therapy after imprisonment, addiction, or illness." },
    { word: "sphygmomanometer", hint: "An instrument for measuring blood pressure." },
    { word: "therapeutics", hint: "The branch of medicine concerned with the treatment and cure of diseases." },
    { word: "ulcer", hint: "An open sore on an external or internal surface of the body." },
    { word: "vitamins", hint: "Organic compounds essential for normal growth and nutrition." },
    { word: "wellness", hint: "The state of being in good health, especially as an actively pursued goal." },
    { word: "xenograft", hint: "A surgical graft of tissue from one species to an unlike species." },
    { word: "yawning", hint: "Involuntary opening of the mouth with a deep inhalation, often due to tiredness or boredom." },
    { word: "zoster", hint: "Another term for shingles, a viral infection causing a painful rash." },
    { word: "allergy", hint: "A condition in which the immune system reacts abnormally to a foreign substance." },
    { word: "bronchitis", hint: "Inflammation of the lining of bronchial tubes, which carry air to and from the lungs." },
    { word: "chiropractic", hint: "A form of alternative medicine focused on diagnosis and treatment of mechanical disorders of the musculoskeletal system." },
    { word: "diabetes", hint: "A disease that occurs when your blood glucose is too high." },
    { word: "epilepsy", hint: "A neurological disorder marked by sudden recurrent episodes of sensory disturbance, loss of consciousness, or convulsions." },
    { word: "fever", hint: "A temporary increase in average body temperature often due to an illness." },
    { word: "gland", hint: "An organ in the body that secretes particular chemical substances for use in the body or for discharge into the surroundings." },
    { word: "hemorrhage", hint: "An escape of blood from a ruptured blood vessel." },
    { word: "incision", hint: "A surgical cut made in skin or flesh." },
    { word: "jaundice", hint: "A yellowing of the skin and eyes due to liver disease or bile obstruction." },
    { word: "ketoacidosis", hint: "A serious diabetes complication where the body produces excess blood acids (ketones)." },
    { word: "lupus", hint: "An autoimmune disease that occurs when your body's immune system attacks your own tissues and organs." },
    { word: "malaria", hint: "A disease caused by a plasmodium parasite, transmitted by the bite of infected mosquitoes." },
    { word: "nebulizer", hint: "A device for producing a fine spray of liquid, used for example for inhaling a medicinal drug." },
    { word: "osteoporosis", hint: "A condition in which bones become weak and brittle." },
    { word: "pediatrics", hint: "The branch of medicine dealing with children and their diseases." },
    { word: "quarantine", hint: "A restriction on the movement of people and goods to prevent the spread of disease." },
    { word: "resuscitation", hint: "The action or process of reviving someone from unconsciousness or apparent death." },
    { word: "sepsis", hint: "A life-threatening condition that arises when the body's response to infection causes injury to its own tissues and organs." },
    { word: "transplant", hint: "An operation in which an organ or tissue is transplanted." },
    { word: "ultrasound", hint: "Sound or other vibrations having an ultrasonic frequency, used in medical imaging." },
    { word: "vaccine", hint: "A substance used to stimulate the production of antibodies and provide immunity against diseases." },
    { word: "wheezing", hint: "A high-pitched whistling sound made while breathing." },
    { word: "xenotransplantation", hint: "The transplantation of living cells, tissues, or organs from one species to another." },
    { word: "yellow fever", hint: "A viral infection spread by a particular species of mosquito." },
    { word: "zinc", hint: "A trace element essential for the immune system, wound healing, and DNA synthesis." },

    // // related to disess

    { word: "diabetes", hint: "A disease that occurs when your blood glucose is too high." },
    { word: "hypertension", hint: "A condition in which the force of the blood against the artery walls is too high." },
    { word: "arthritis", hint: "Inflammation of the joints, causing pain and stiffness." },
    { word: "asthma", hint: "A respiratory condition marked by spasms in the bronchi of the lungs, causing difficulty in breathing." },
    { word: "cancer", hint: "A disease caused by an uncontrolled division of abnormal cells in a part of the body." },
    { word: "influenza", hint: "A viral infection that attacks your respiratory system – your nose, throat, and lungs." },
    { word: "tuberculosis", hint: "An infectious disease that mainly affects the lungs." },
    { word: "malaria", hint: "A disease caused by a plasmodium parasite, transmitted by the bite of infected mosquitoes." },
    { word: "HIV", hint: "A virus that attacks the body's immune system." },
    { word: "AIDS", hint: "A chronic, potentially life-threatening condition caused by HIV." },
    { word: "measles", hint: "A highly contagious viral infection that causes a total-body skin rash and flu-like symptoms." },
    { word: "chickenpox", hint: "A highly contagious viral infection causing an itchy, blister-like rash on the skin." },
    { word: "hepatitis", hint: "An inflammation of the liver." },
    { word: "pneumonia", hint: "An infection that inflames the air sacs in one or both lungs." },
    { word: "cholera", hint: "An acute diarrheal illness caused by infection of the intestine with Vibrio cholerae bacteria." },
    { word: "ebola", hint: "A severe, often fatal disease in humans and nonhuman primates caused by the Ebola virus." },
    { word: "rabies", hint: "A deadly virus spread to people from the saliva of infected animals." },
    { word: "dengue", hint: "A mosquito-borne viral disease occurring in tropical and subtropical areas." },
    { word: "zika", hint: "A virus spread by Aedes mosquitoes, which can cause birth defects if contracted during pregnancy." },
    { word: "mumps", hint: "A viral infection that primarily affects saliva-producing glands located near your ears." },
    { word: "polio", hint: "A crippling and potentially deadly infectious disease caused by the poliovirus." },
    { word: "smallpox", hint: "An eradicated viral disease that used to be contagious, disfiguring, and often deadly." },
    { word: "syphilis", hint: "A bacterial infection usually spread by sexual contact." },
    { word: "gonorrhea", hint: "A sexually transmitted bacterial infection that, if untreated, may cause infertility." },
    { word: "chlamydia", hint: "A common sexually transmitted infection that may not cause symptoms." },
    { word: "covid-19", hint: "A highly contagious disease caused by the novel coronavirus SARS-CoV-2." },
    { word: "lyme", hint: "An infectious disease caused by the Borrelia bacterium, spread by ticks." },
    { word: "hepatitis B", hint: "A serious liver infection caused by the hepatitis B virus." },
    { word: "hepatitis C", hint: "An infection caused by a virus that attacks the liver and leads to inflammation." },
    { word: "meningitis", hint: "Inflammation of the protective membranes covering the brain and spinal cord." },
    { word: "herpes", hint: "A viral infection causing contagious sores, most often around the mouth or on the genitals." },
    { word: "norovirus", hint: "A very contagious virus that causes vomiting and diarrhea." },
    { word: "rotavirus", hint: "A contagious virus that can cause gastroenteritis (inflammation of the stomach and intestines)." },
    { word: "lupus", hint: "An autoimmune disease where the body's immune system becomes hyperactive and attacks normal, healthy tissue." },
    { word: "celiac", hint: "An immune reaction to eating gluten, a protein found in wheat, barley, and rye." },
    { word: "crohn's", hint: "A type of inflammatory bowel disease (IBD) that may affect any part of the gastrointestinal tract." },
    { word: "ulcerative colitis", hint: "A chronic inflammatory bowel disease that causes inflammation in the digestive tract." },
    { word: "alzheimer's", hint: "A progressive disease that destroys memory and other important mental functions." },
    { word: "parkinson's", hint: "A disorder of the central nervous system that affects movement, often including tremors." },
    { word: "multiple sclerosis", hint: "A disease in which the immune system eats away at the protective covering of nerves." },
    { word: "rheumatoid arthritis", hint: "A chronic inflammatory disorder affecting many joints, including those in the hands and feet." },
    { word: "psoriasis", hint: "A skin disease marked by red, itchy, scaly patches." },
    { word: "eczema", hint: "A condition that makes your skin red and itchy." },
    { word: "rosacea", hint: "A common skin condition that causes redness and visible blood vessels in your face." },
    { word: "gout", hint: "A form of arthritis characterized by severe pain, redness, and tenderness in joints." },
    { word: "e11", hint: "A disease that occurs when your blood glucose is too high."},
    { word: "i10", hint: "A condition in which the force of the blood against the artery walls is too high."}
];
 

 document.querySelector("#next").addEventListener("click", function() {
    location.reload();
});


const wordDisplay = document.querySelector(".word-display");
const guessesText = document.querySelector(".guesses-text b");
const keyboardDiv = document.querySelector(".keyboard");
const hangmanImage = document.querySelector(".hangman-box img");
const gameModal = document.querySelector(".game-modal");
const playAgainBtn = gameModal.querySelector("button");


const next = document.querySelector("#next");


// location.reload();






// Initializing game variables
let currentWord, correctLetters, wrongGuessCount;
const maxGuesses = 6;

const resetGame = () => {
    // Ressetting game variables and UI elements
    correctLetters = [];
    wrongGuessCount = 0;
    hangmanImage.src = "images/hangman-0.svg";
    guessesText.innerText = `${wrongGuessCount} / ${maxGuesses}`;
    wordDisplay.innerHTML = currentWord.split("").map(() => `<li class="letter"></li>`).join("");
    keyboardDiv.querySelectorAll("button").forEach(btn => btn.disabled = false);
    gameModal.classList.remove("show");
}

const getRandomWord = () => {
    // Selecting a random word and hint from the wordList
    const { word, hint } = wordList[Math.floor(Math.random() * wordList.length)];
    currentWord = word; // Making currentWord as random word
    document.querySelector(".hint-text b").innerText = hint;
    resetGame();
}

const gameOver = (isVictory) => {
    // After game complete.. showing modal with relevant details
    const modalText = isVictory ? `You found the word:` : 'The correct word was:';
    gameModal.querySelector("img").src = `images/${isVictory ? 'victory' : 'lost'}.gif`;
    gameModal.querySelector("h4").innerText = isVictory ? 'Congrats!' : 'Game Over!';
    gameModal.querySelector("p").innerHTML = `${modalText} <b>${currentWord}</b>`;
    gameModal.classList.add("show");
}

const initGame = (button, clickedLetter) => {
    // Checking if clickedLetter is exist on the currentWord
    if(currentWord.includes(clickedLetter)) {
        // Showing all correct letters on the word display
        [...currentWord].forEach((letter, index) => {
            if(letter === clickedLetter) {
                correctLetters.push(letter);
                wordDisplay.querySelectorAll("li")[index].innerText = letter;
                wordDisplay.querySelectorAll("li")[index].classList.add("guessed");
            }
        });
    } else {
        // If clicked letter doesn't exist then update the wrongGuessCount and hangman image
        wrongGuessCount++;
        hangmanImage.src = `images/hangman-${wrongGuessCount}.svg`;
    }
    button.disabled = true; // Disabling the clicked button so user can't click again
    guessesText.innerText = `${wrongGuessCount} / ${maxGuesses}`;

    // Calling gameOver function if any of these condition meets
    if(wrongGuessCount === maxGuesses) return gameOver(false);
    if(correctLetters.length === currentWord.length) return gameOver(true);
}

// Creating keyboard buttons for letters and numbers
for (let i = 48; i <= 57; i++) { // 0-9
    const button = document.createElement("button");
    button.innerText = String.fromCharCode(i);
    keyboardDiv.appendChild(button);
    button.addEventListener("click", (e) => initGame(e.target, String.fromCharCode(i)));
}

for (let i = 65; i <= 90; i++) { // A-Z
    const button = document.createElement("button");
    button.innerText = String.fromCharCode(i).toLowerCase(); // Use lowercase for consistency
    keyboardDiv.appendChild(button);
    button.addEventListener("click", (e) => initGame(e.target, String.fromCharCode(i).toLowerCase()));
}

getRandomWord();
playAgainBtn.addEventListener("click", getRandomWord);

next.addEventListener("click", getRandomWord);


    </script>
</body>
</html>